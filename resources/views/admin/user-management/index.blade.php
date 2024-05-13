@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Management</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-sm btn-info" id="btn-refresh"><i
                                    class="bi bi-arrow-clockwise"></i> Refresh</button>
                            <a href="{{ route('user_management.add') }}" class="btn btn-sm btn-primary"><i
                                    class="fa fa-user-plus" aria-hidden="true"></i> Register User</a>
                            <button type="button" id="btn-delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"
                                    aria-hidden="true"></i>
                                Delete</button>
                        </div>
                        <div class="card-body">
                            <table id="table-user" class="table table-bordered table-hover" style="width: 100%">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <th style="width: 15px">No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('js-custom')
    <script src="{{ asset('dist/js/admin/user-management/view.min.js?q=') . time() }}"></script>
@endpush
