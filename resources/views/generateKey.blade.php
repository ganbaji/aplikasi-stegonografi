@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Generate Key</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Generate Key</li>
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
            <form action="{{ route('generateKey') }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="p">Bilangan P</label>
                            <input type="number" name="p" class="form-control" id="p" placeholder="Bilangan Prima">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="q">Bilangan q</label>
                            <input type="number" name="q" class="form-control" id="q" placeholder="Bilangan Prima">
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label >nilai n</label>
                        <p class="">{{ $n ?? "" }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label >nilai m</label>
                        <p class="">{{ $m ?? "" }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label >nilai e</label>
                        <p class="">{{ $e ?? "" }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label >nilai d</label>
                        <p class="">{{ $d ?? "" }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label >Private key</label>
                        <p class="">
                          {{ session('privateKey') ?? "" }} </p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label >Public Key</label>
                        <p class=""> {{ session('publicKey') ?? "" }} </p>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
      
       
          </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection