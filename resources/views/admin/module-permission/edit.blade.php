@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Group Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">User Group Management</li>
                        <li class="breadcrumb-item active">Edit Module</li>
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
                            <h5>Form Edit module</h5>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="form-edit-module">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="formValue" id="formValue"
                                    value="{{ base64_encode($value->id) }}">
                                <div class="form-group">
                                    <label for="name">Module Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="module name" value="{{ $value->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="route_name">Route Name</label>
                                    <input type="text" class="form-control" name="route_name" id="route-name"
                                        placeholder="route name" value="{{ $value->route_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="link_path">Link/Path</label>
                                    <input type="text" class="form-control" name="link_path" id="link-path"
                                        placeholder="link/path" value="{{ $value->link_path }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" name="description" id="description"
                                        placeholder="description" value="{{ $value->description }}">
                                </div>
                                <div class="form-group">
                                    <label for="icon">Icon</label>
                                    <input type="text" class="form-control" name="icon" id="icon"
                                        placeholder="icon" value="{{ $value->icon }}">
                                </div>
                                <div class="form-group">
                                    <label for="order_menu">Position Menu</label>
                                    <input type="text" class="form-control" name="order_menu" id="order_menu"
                                        placeholder="order menu" value="{{ $value->order_menu }}">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    <a href="{{ $url }}" class="btn btn-sm btn-outline-secondary ml-1">Back</a>
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
    <script src="{{ asset('dist/js/admin/module-permission/edit.min.js?q=') . time() }}"></script>
@endpush
