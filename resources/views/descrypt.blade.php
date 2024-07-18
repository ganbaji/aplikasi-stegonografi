@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Descrypt and Extract</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Descrypt and Extract</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Quick Example</h3>
            </div>
            @if (\Session::has('error'))
            <div class="alert alert-danger">
                    {!! \Session::get('error') !!}
            </div>
            @endif
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('extract')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="privateKey">private Key</label>
                  <input type="text" class="form-control" id="privateKey" name="privateKey" placeholder="d,n">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File image (PNG only)</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="image" id="image" required>
                      <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                  </div>
                <div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Process</button>
                </div>
              </div>
          </form>
          <div class="mt-3">
            <a class="btn btn-success" href="{{ asset('storage/extracted_file.xlsx') }}" download>Download File Descrypt</a>
          </div>
          </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection