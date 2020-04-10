@extends('admin.layouts.app')

@section('title', 'User')


@section('content')
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success</strong> {{ Session::get('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @elseif(Session::has('error'))
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List users</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm">
                      <a href="{{ route('user-create') }}" class="btn btn-sm  btn-primary">
                          <span class="glyphicon glyphicon-plus-sign"></span> New</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                @if(!empty($list_users))
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>User</th>
                      <th>Email</th>
                      <th>Phone Number</th>
                      <th>Note</th>
                      <th style="width:100px; text-align: center;" class="action">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php($i = 1)
                    @foreach( $list_users as $user )
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td><span class="tag tag-success">{{ $user->phone_number }}</span></td>
                      <td>{{ $user->note }}</td>
                      <td style="text-align: center;"><a href="{{ route('user-edit', ['id'=> $user->id ]) }}"><ion-icon size="small" name="create-outline"></ion-icon></a>&nbsp;<a href="{{ route('user-delete', ['id'=> $user->id]) }}"><ion-icon size="small" name="trash-outline"></ion-icon></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection