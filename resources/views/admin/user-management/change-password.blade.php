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
                        <li class="breadcrumb-item"><a href="{{ route('user_management') }}">User Management</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
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
                            <h5>Form change password, email: {{ $email }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="form-change-password">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="password">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password Confirmation</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password-confirmation" placeholder="password confirmation">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">Change Password</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        id="btn-back">Back</button>
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
    <script src="{{ asset('dist/js/admin/user-management/change-password.min.js?q=') . time() }}"></script>
@endpush
