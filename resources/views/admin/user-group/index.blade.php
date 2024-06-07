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
                        <li class="breadcrumb-item active">User Group</li>
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
                            <button type="button" class="btn btn-sm btn-primary" id="btn-add" data-toggle="modal"
                                data-target="#modal-add-user-group"><i class="fa fa-plus" aria-hidden="true"></i> Add
                                Data</button>
                            <button type="button" id="btn-delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"
                                    aria-hidden="true"></i>
                                Delete</button>
                        </div>
                        <div class="card-body">
                            <table id="table-user-group" class="table table-bordered table-hover" style="width: 100%">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <th style="width: 15px">No</th>
                                        <th>Name</th>
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

    <!-- modal add user-group -->
    <div class="modal fade" id="modal-add-user-group">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Add User Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:;" id="form-add-user-group" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="group name">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /modal add user-group  -->
    <!-- modal edit user-group -->
    <div class="modal fade" id="modal-edit-user-group">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Edit User Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:;" id="form-edit-user-group" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name-edit" class="form-control"
                                placeholder="group name">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /modal add user-group  -->
@endsection
@push('js-custom')
    <script src="{{ asset('theme/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('theme/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        ModuleFn = @json($moduleFn)
    </script>
    <script src="{{ asset('dist/js/admin/user-group/view.min.js?q=') . time() }}"></script>
@endpush
