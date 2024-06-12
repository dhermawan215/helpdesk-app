var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    var table;
    var aSelected = [];

    var handleData = function () {
        table = $("#table-user").DataTable({
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
                url: url + "/admin/user-management/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "cbox", orderable: false },
                { data: "rnum", orderable: false },
                { data: "name", orderable: false },
                { data: "email", orderable: false },
                { data: "roles", orderable: false },
                { data: "active", orderable: false },
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
        $("#btn-refresh").click(function (e) {
            table.ajax.reload();
        });
        //add permission condition if true or false
        if ($.inArray("add", ModuleFn) !== -1) {
            $("#btn-add").removeClass("disabled");
        } else {
            $("#btn-add").addClass("disabled");
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
    //function for checklist user active/inactive
    var handleActiveUser = function () {
        $(document).on("change", ".activeuser", function () {
            if ($(this).is(":checked")) {
                const cbxVal = $(this).data("toggle");
                const activeVal = "1";
                $.ajax({
                    type: "POST",
                    url: `${url}/admin/user-management/active-user`,
                    data: {
                        _token: csrf_token,
                        cbxValue: cbxVal,
                        acValue: activeVal,
                    },
                    success: function (response) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            table.ajax.reload();
                        }, 3500);
                    },
                });
            } else {
                const cbxVal = $(this).data("toggle");
                const activeVal = "0";
                $.ajax({
                    type: "POST",
                    url: `${url}/admin/user-management/active-user`,
                    data: {
                        _token: csrf_token,
                        cbxValue: cbxVal,
                        acValue: activeVal,
                    },
                    success: function (response) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            table.ajax.reload();
                        }, 3500);
                    },
                });
            }
        });
    };

    return {
        init: function () {
            handleData();
            handleDelete();
            handleActiveUser();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
