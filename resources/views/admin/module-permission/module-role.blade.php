@extends('layouts.app')
@push('css-custom')
    <link rel="stylesheet" href="{{ asset('theme/plugins/input_tags/tagsinput.min.css') }}">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endpush
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
                        <li class="breadcrumb-item active">Module Role</li>
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
                            <h5>Menu Name: {{ $menu->description }}</h5>
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                @foreach ($userGroup as $ug)
                                    @if ($ug->name == 'super-admin')
                                        @php
                                            $idHref = '#custom-tabs-two-super-admin';
                                            $idTab = 'super-admin-tab';
                                            $groupValue = $ug->id;
                                        @endphp
                                    @elseif($ug->name == 'operator')
                                        @php
                                            $idHref = '#custom-tabs-operator';
                                            $idTab = 'operator-tab';
                                            $groupValue = $ug->id;
                                        @endphp
                                    @else
                                        @php
                                            $idHref = '#custom-tabs-two-reguler';
                                            $idTab = 'reguler-user-tab';
                                            $groupValue = $ug->id;
                                        @endphp
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link group-tab-custom" id="{{ $idTab }}"
                                            data-group="{{ $groupValue }}" data-module="{{ $menu->id }}""
                                            data-toggle="pill" href="{{ $idHref }}" role="tab"
                                            aria-controls="custom-tabs-two-home"
                                            aria-selected="true">{{ Str::upper($ug->name) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                @foreach ($userGroup as $ugs)
                                    @if ($ugs->name == 'super-admin')
                                        @php
                                            $tabPaneId = 'custom-tabs-two-super-admin';
                                        @endphp
                                    @elseif($ugs->name == 'operator')
                                        @php
                                            $tabPaneId = 'custom-tabs-operator';
                                        @endphp
                                    @else
                                        @php
                                            $tabPaneId = 'custom-tabs-two-reguler';
                                        @endphp
                                    @endif
                                    <div class="tab-pane fade show" id="{{ $tabPaneId }}" role="tabpanel"
                                        aria-labelledby="{{ $tabPaneId }}">
                                        <form action="javascript:;" method="post" class="form-module-role" id="">
                                            @csrf
                                            <div class="form-group row">
                                                <input type="hidden" name="moduleValue"
                                                    value="{{ base64_encode($menu->id) }}">
                                                <input type="hidden" name="groupValue" class="group-value-custom">
                                                <label for="">{{ Str::upper($ugs->name) }}: Access
                                                    Permission</label>
                                                <select name="is_access" class="is-access" class="form-control">

                                                </select>
                                            </div>
                                            <div class="form-group row">
                                                <label for="">Function</label>
                                                <input type="text" name="function" class="function-field" id=""
                                                    class="form-control">
                                            </div>
                                            <div class="form-group row">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-back ml-1">Back</button>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('js-custom')
    <script src="{{ asset('theme/plugins/input_tags/tagsinput.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dist/js/admin/module-permission/module-role.min.js?q=') . time() }}"></script>
@endpush
