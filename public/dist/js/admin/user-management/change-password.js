var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");
    // function register user
    var handleUpdatePassword = function () {
        //button back
        $("#btn-back").click(function (e) {
            e.preventDefault();
            window.location.href = url + "/admin/user-management";
        });

        $("#form-change-password").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            $.ajax({
                url: url + "/admin/user-management/change-password",
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
            handleUpdatePassword();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
