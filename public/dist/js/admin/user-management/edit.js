var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    //function to get user data from ajax request
    var handleUserEdit = function () {
        $.ajax({
            type: "POST",
            url: url + "/admin/user-management/user-edit",
            async: true,
            data: {
                _token: csrf_token,
                ue: ue,
            },
            dataType: "json",
            success: function (response) {
                var responseData = response.data;
                $("#name").val(responseData.name);
                $("#email").val(responseData.ue);
                $("#uid").val(responseData.uid);
                $("#roles").append(
                    $("<option>", {
                        value: responseData.urole,
                        text: responseData.roles,
                        attr: "selected",
                    })
                );
            },
        });
    };
    // function for dropdown roles
    var handleDropdownRole = function () {
        $("#roles").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "Select/type roles",
            dataType: "json",
            ajax: {
                method: "POST",
                url: url + "/admin/user-group/list-user-group",
                data: function (params) {
                    return {
                        _token: csrf_token,
                        search: params.term,
                        page: params.page || 1, // search term
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    // var datas = JSON.parse(data);
                    return {
                        results: data.items,
                        pagination: {
                            more: false,
                        },
                    };
                },
            },
            templateResult: format,
            templateSelection: formatSelection,
        });
    };
    //base dropdown setup function
    function format(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }
    function formatSelection(repo) {
        return repo.text;
    }
    //end base dropdown setup function
    // function update user data
    var handleUpdate = function () {
        //button back
        $("#btn-back").click(function (e) {
            e.preventDefault();
            window.location.href = url + "/admin/user-management";
        });

        $("#form-update-user").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            $.ajax({
                url: url + "/admin/user-management/user-update",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location.href = url + "/admin/user-management";
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
            handleDropdownRole();
            handleUpdate();
            handleUserEdit();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
