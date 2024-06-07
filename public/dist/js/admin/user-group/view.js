var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];

    var handleData = function () {
        table = $("#table-user-group").DataTable({
            responsive: true,
            autoWidth: true,
            pageLength: 15,
            dom: "Bfrtip",
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            searching: true,
            paging: true,
            lengthMenu: [
                [15, 25, 50],
                [15, 25, 50],
            ],
            language: {
                info: "Show _START_ - _END_ from _TOTAL_ data",
                infoEmpty: "Show 0 - 0 from 0 data",
                infoFiltered: "",
                zeroRecords: "Data not found",
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
            columnsDefs: [
                { searchable: false, target: [0, 1] },
                { orderable: false, target: 0 },
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: url + "/admin/user-group/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "cbox", orderable: false },
                { data: "rnum", orderable: false },
                { data: "name", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {
                $(".data-menu-cbox").on("click", function () {
                    handleAddDeleteAselected(
                        $(this).val(),
                        $(this).parents()[1]
                    );
                });
                $("#btn-delete").attr("disabled", "");
                aSelected.splice(0, aSelected.length);
            },
        });
        $("#table-user-group tbody").on("click", "tr", function () {
            handleEdit(table.row(this).data());
        });
        $("#btn-refresh").click(function (e) {
            table.ajax.reload();
        });
        //add permission condition if true or false
        if ($.inArray("add", ModuleFn) !== -1) {
            $("#btn-add").removeAttr("disabled");
        } else {
            $("#btn-add").attr("disabled", "disabled");
        }
        //delete permission condition if true or false
        if ($.inArray("delete", ModuleFn) !== -1) {
            $("#btn-delete").removeClass("disabled");
        } else {
            $("#btn-delete").addClass("disabled");
        }
    };

    var handleAddDeleteAselected = function (value, parentElement) {
        var check_value = $.inArray(value, aSelected);
        if (check_value !== -1) {
            $(parentElement).removeClass("table-info");
            aSelected.splice(check_value, 1);
        } else {
            $(parentElement).addClass("table-info");
            aSelected.push(value);
        }

        handleBtnDisableEnable();
    };

    var handleBtnDisableEnable = function () {
        if (aSelected.length > 0) {
            $("#btn-delete").removeAttr("disabled");
        } else {
            $("#btn-delete").attr("disabled", "");
        }
    };

    var handleEdit = function (value) {
        $(document).on("click", ".btn-edit", function () {
            const dataEdit = $(this).data("edit");
            $("#name-edit").val(value.name);
            handleUpdate(dataEdit);
        });
    };

    var handleUpdate = function (handleEdit) {
        $("#form-edit-user-group").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            $.ajax({
                url: url + "/admin/user-group/update/" + handleEdit,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 3500);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };
    var handleSubmit = function () {
        $("#form-add-user-group").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            $.ajax({
                url: url + "/admin/user-group/save",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 3500);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };

    var handleDelete = function () {
        $("#btn-delete").click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url + "/admin/user-group/delete",
                        data: {
                            _token: csrf_token,
                            ids: aSelected,
                        },
                        success: function (response) {
                            if (response.success == true) {
                                Swal.fire(
                                    "Deleted!",
                                    "Your file has been deleted.",
                                    "success"
                                );
                                table.ajax.reload();
                            }
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Internal Server Error",
                            });
                        },
                    });
                }
            });
        });
    };

    return {
        init: function () {
            handleData();
            handleDelete();
            handleSubmit();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
