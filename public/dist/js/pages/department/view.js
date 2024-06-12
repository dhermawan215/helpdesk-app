var Index = (function () {
    var csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];

    var handleDataTabelUser = function () {
        table = $("#table-department").DataTable({
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
                url: url + "/department/list",
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
        // get edit data when tr clicked
        $("#table-department tbody").on("click", "tr", function () {
            handleEdit(table.row(this).data());
        });
        // btn refresh on click
        $("#btn-refresh").click(function (e) {
            e.preventDefault();
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
    //push data to variable aSelected
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
    //control button disabled enable
    var handleBtnDisableEnable = function () {
        if (aSelected.length > 0) {
            $("#btn-delete").removeAttr("disabled");
        } else {
            $("#btn-delete").attr("disabled", "");
        }
    };
    //delete method
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
                        url: url + "/department/delete",
                        data: {
                            _token: csrf_token,
                            dValue: aSelected,
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
    //edit method
    var handleEdit = function (value) {
        $(document).on("click", ".btn-edit", function () {
            const dataEdit = $(this).data("edit");
            $("#edit-department-name").val(value.name);
            handleUpdate(dataEdit);
        });
    };
    //update method
    var handleUpdate = function (handleEdit) {
        $("#form-edit-department").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            $.ajax({
                url: url + "/department/update/" + handleEdit,
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

    //method submit form
    var handleSubmitForm = function () {
        $("#form-add-department").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            $.ajax({
                url: url + "/department/save",
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

    return {
        init: function () {
            handleDataTabelUser();
            handleDelete();
            handleSubmitForm();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
