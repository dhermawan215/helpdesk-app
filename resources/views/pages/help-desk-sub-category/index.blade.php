@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Help Desk Sub Category</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item ">Help Desk Category</li>
                        <li class="breadcrumb-item active">Add Help Desk Sub Category</li>
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
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Add Sub Category Form</div>
                        <div class="card-body">
                            <form action="javascript:;" method="post" id="form-add-sub-category">
                                @csrf
                                <input type="hidden" name="formValueCategory" value="{{ $formValue }}">
                                <div class="row">
                                    <div class="col">
                                        <label for="category-name">Category Name</label>
                                        <input type="text" name="category_name" class="form-control" readonly
                                            placeholder="Category name" value="{{ $categoryName }}">
                                    </div>
                                    <div class="col">
                                        <label for="category-name">Sub category Name</label>
                                        <input type="text" name="sub_category_name" class="form-control"
                                            placeholder="Sub category name">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ $homeUrl }}" class="btn btn-sm btn-outline-secondary"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                            <button type="button" class="btn btn-sm btn-info" id="btn-refresh"><i
                                    class="bi bi-arrow-clockwise"></i> Refresh</button>
                            <button type="button" id="btn-delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"
                                    aria-hidden="true"></i>
                                Delete</button>
                        </div>
                        <div class="card-body">
                            <table id="table-help-desk-sub-category" class="table table-bordered table-hover"
                                style="width: 100%">
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
    <!-- modal edit help desk category -->
    <div class="modal fade" id="modal-edit-sub-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal edit help desk sub category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:;" id="form-edit-sub-category" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category-name">Sub Category Name</label>
                            <input type="text" name="sub_category_name" id="edit-sub-category-name" class="form-control"
                                placeholder="sub category name">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-success" id="btn-update">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /modal edit help desk category  -->
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
        ModuleFn = @json($moduleFn);
        var categoryName = '{{ base64_encode($formValue) }}'
    </script>
    <script src="{{ asset('dist/js/pages/help-desk-sub-category/view.min.js?q=') . time() }}"></script>
@endpush
