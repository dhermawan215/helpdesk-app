var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    var handleAddData = function () {
        $("#form-add-module").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            $.ajax({
                url: url + "/admin/module-permission/module-create",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location.href = url + "/admin/module-permission";
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
            handleAddData();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
