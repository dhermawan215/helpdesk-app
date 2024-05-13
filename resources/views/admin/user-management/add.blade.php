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
                    <li class="breadcrumb-item">User Management</li>
                    <li class="breadcrumb-item active">Register</li>
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
                        <h5>Form Register User</h5>
                    </div>
                    <div class="card-body">
                        <form action="javascript:;" method="post" id="form-register-user">
                            @csrf
                            <div class="form-group">
                                <label for="name">Username/Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="username/name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="password">
                            </div>
                            <div class="form-group">
                                <label for="is-active">Active Status</label>
                                <select name="is_active" id="is-active" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="roles">Roles</label>
                                <select name="roles" id="roles" class="form-control">

                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary">Register</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="btn-back">Back</button>
                            </div>
                        </form>
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
<script src="{{ asset('theme/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('dist/js/admin/user-management/add.min.js?q=') . time() }}"></script>
@endpush