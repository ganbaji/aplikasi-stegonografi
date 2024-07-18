@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Encrypt and Insert</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Encrypt and Insert</li>
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
          <form action="{{ route('hide') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputFile">File image (PNG only)</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="image" id="image">
                      <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                  </div>
                <div>
                <div class="form-group">
                  <label for="publickey">Public Key</label>
                  <input type="text" class="form-control" id="publickey" name="publicKey" placeholder="e,n">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File Excel (Excel only)</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="file" id="file">
                      <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Process</button>
                </div>
              </div>
          </form>
          <div class="mt-3">
            <a class="btn btn-success" href="{{ asset('storage/output.png')}}" download><i class="fa fa-download" aria-hidden="true"></i> Download Encrypt</a>
          </div>
          </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection