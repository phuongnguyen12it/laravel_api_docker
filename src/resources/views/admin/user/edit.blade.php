@extends('admin.layouts.app')

@section('title', 'User')


@section('content')
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
              <li class="breadcrumb-item active">Users create</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error</strong> {{ Session::get('error') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('user-update', ['id' => $user_id]) }}" method="post">
              	{{ csrf_field() }}
                <input type="hidden" name='id' value="{{ !empty($user->id) ? $user->id : '' }}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ !empty($user->name) ? $user->name : '' }}">
                  </div>
                  <div class="form-group">
                    <label for="name">Phone number</label>
                    <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter phone number" value="{{ !empty($user->phone_number) ? $user->phone_number : '' }}">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="{{ !empty($user->password) ? $user->password : '' }}">
                  </div>
                  <div class="form-group">
                    <label for="name">Note</label>
                    <input type="text" class="form-control" name="note" id="note" placeholder="Enter your note" value="{{ !empty($user->note) ? $user->note : '' }}">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection