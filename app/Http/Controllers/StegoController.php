<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class StegoController extends Controller
{
    public function index()
    {
        return view('generateKey');
    
    }
    public function encrypt()
    {
        return view('encrypt');
    
    }
    public function descrypt()
    {
        return view('descrypt');
    
    }



    public function calculate(Request $request)
    {
        $request->validate([
            'p' => 'required|integer',
            'q' => 'required|integer',
        ]);

        $p = $request->input('p');
        $q = $request->input('q');

    
        if ($this->isPrime($p) && $this->isPrime($q)) {
            $n = $p * $q;                   
            $m = ($p-1) * ($q-1);       


        $e = $this->findE($m);
        if ($e === -1) {
            return response()->json(['error' => 'Failed to find appropriate e'], 400);
        }

        $d = $this->modInverse($e, $m);

        $publicKey = $e.','.$n;
        
        $privateKey = $d.','.$n;

                
            
            session([
                'nilaiN' =>$n,
                'nilaiM' =>$m,
                'nilaiE' =>$e,
                'nilaiD' =>$d,
                'publicKey' =>$publicKey,
                'privateKey' =>$privateKey
            ]);
            
            return view('generateKey', compact('p', 'q', 'm', 'n', 'e', 'd', 'privateKey', 'publicKey'));
        } else {
            return redirect()->back()->with(['error' => 'Both numbers must be prime.']);
        }
    }

    public function reset(){
        
        session()->forget([
            'nilaiN',
            'nilaiM',
            'nilaiE',
            'nilaiD',
            'publicKey' ,
            'privateKey'
        ]);
        return redirect()->route('index');
    }
    
    private function isPrime($number)
    {
        if ($number < 2) {
            return false;
        }
        for ($i = 2; $i <= sqrt($number); $i++) {
            if ($number % $i == 0) {
                return false;
            }
        }
        return true;
    }

    private function gcd($a, $b)
    {
        while ($b != 0) {
            $t = $b;
            $b = $a % $b;
            $a = $t;
        }
        return $a;
    }
    
    private function findE($phi)
    {
        for ($e = 2; $e < $phi; $e++) {
            if ($this->gcd($e, $phi) == 1) {
                return $e;
            }
        }
        return -1; 
    }


    private function modInverse($a, $m)
    {
        $m0 = $m;
        $y = 0;
        $x = 1;

        if ($m == 1) {
            return 0;
        }

        while ($a > 1) {
            
            $q = intval($a / $m);
            $t = $m;

            $m = $a % $m;
            $a = $t;
            $t = $y;

            $y = $x - $q * $y;
            $x = $t;
        }

        if ($x < 0) {
            $x += $m0;
        }

        return $x;
    }

        public function hideFile(Request $request)
        {
            
            if ($request->input('publicKey') != session("publicKey") ) {
                return redirect()->back()->with('error', 'tidak sesuai nilai Public Key');
            }
    
            $imagePath = $request->file('image')->getPathName();
            $filePath = $request->file('file')->getPathName();

            $outputImagePath = storage_path('app/public/output.png');
            
            
            $this->hideFileInImage($imagePath, $filePath, $outputImagePath);
    
    
            
            return redirect()->back();
        
        }
    
        public function showExtractForm()
        {
            return view('extract');
        }
    
        public function extractFile(Request $request)
        {
            if ($request->input('privateKey') != session("privateKey") ) {
                return redirect()->back()->with('error', 'tidak sesuai nilai Private Key');
            }
            $imagePath = $request->file('image')->getPathName();

            $outputFilePath = storage_path('app/public/extracted_file.xlsx');
    
            $this->readFileFromImage($imagePath, $outputFilePath);
    
            
            return redirect()->back();
            
        }
        
    
        private function hideFileInImage($imagePath, $filePath, $outputImagePath)
        {
            $image = imagecreatefrompng($imagePath);
            if (!$image) {
                die("Gagal membuka gambar.");
            }
    
            $fileContents = file_get_contents($filePath);
            if ($fileContents === false) {
                die("Gagal membaca file.");
            }

            $fileSize = strlen($fileContents);
            echo "File size: $fileSize bytes\n";
    
            $sizeBits = str_pad(decbin($fileSize), 32, '0', STR_PAD_LEFT);
            
            $fileBits = $sizeBits;
            for ($i = 0; $i < $fileSize; $i++) {
                $char = $fileContents[$i];
                $fileBits .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
            }
            
            $fileBitsLength = strlen($fileBits);
            echo "Total bits to hide: $fileBitsLength\n";
            
            $width = imagesx($image);
            $height = imagesy($image);
            $totalPixels = $width * $height;
    

            $maxBits = $totalPixels * 3;
            echo "Maximum bits that can be hidden: $maxBits\n";
    
            if ($fileBitsLength > $maxBits) {
                die("File terlalu besar untuk disembunyikan dalam gambar ini.");
            }
    
            $bitIndex = 0;
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if ($bitIndex >= $fileBitsLength) {
                        break 2; 
                    }
    
                    $rgb = imagecolorat($image, $x, $y);
                    $colors = imagecolorsforindex($image, $rgb);
    
                    $red = ($colors['red'] & 0xFE) | intval($fileBits[$bitIndex++]);
                    if ($bitIndex >= $fileBitsLength) break;
    
                    $green = ($colors['green'] & 0xFE) | intval($fileBits[$bitIndex++]);
                    if ($bitIndex >= $fileBitsLength) break;
    
                    $blue = ($colors['blue'] & 0xFE) | intval($fileBits[$bitIndex++]);
                    if ($bitIndex >= $fileBitsLength) break;
    
                    $newColor = imagecolorallocate($image, $red, $green, $blue);
                    if ($newColor === false) {
                        $newColor = imagecolorclosest($image, $red, $green, $blue);
                    }
    
                    imagesetpixel($image, $x, $y, $newColor);
                }
            }
    
            imagepng($image, $outputImagePath);
            imagedestroy($image);
            echo "File berhasil disembunyikan dalam gambar.\n";
        }
    
        private function readFileFromImage($imagePath, $outputFilePath)
        {
            $image = imagecreatefrompng($imagePath);
        if (!$image) {
            die("Gagal membuka gambar.");
        }

        $width = imagesx($image);
        $height = imagesy($image);

        $fileBits = '';
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($image, $x, $y);
                $colors = imagecolorsforindex($image, $rgb);

                $fileBits .= ($colors['red'] & 1);
                $fileBits .= ($colors['green'] & 1);
                $fileBits .= ($colors['blue'] & 1);
            }
        }

        $fileBitsLength = strlen($fileBits);
        echo "Total bits read: $fileBitsLength\n";

        $sizeBits = substr($fileBits, 0, 32);
        $fileSize = bindec($sizeBits);

        echo "File size read: $fileSize bytes\n";

        if (32 + $fileSize * 8 > $fileBitsLength) {
            die("Panjang file melebihi panjang bit yang tersedia.");
        }

        $fileContents = '';
        for ($i = 32; $i < 32 + $fileSize * 8; $i += 8) {
            if ($i + 8 > $fileBitsLength) {
                die("Indeks melebihi panjang file bits saat membaca karakter.");
            }

            $char = chr(bindec(substr($fileBits, $i, 8)));
            $fileContents .= $char;
        }

        file_put_contents($outputFilePath, $fileContents);
        imagedestroy($image);
        echo "File berhasil dibaca dari gambar.\n";
    }
}