var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");

    var handleInputTag = function () {
        $(".function-field").tagsinput();
    };

    var handleTabClick = function () {
        $(".group-tab-custom").on("click", function () {
            const groupValue = $(this).data("group");
            $(".group-value-custom").val(groupValue);
        });
    };

    var handleIsAccess = function () {
        var dataIsAccess = [
            {
                id: "1",
                text: "Yes",
            },
            {
                id: "0",
                text: "No",
            },
        ];

        $(".is-access").select2({
            allowClear: true,
            placeholder: "Select access permission",
            data: dataIsAccess,
        });
    };

    var handleSubmitModuleRole = function () {
        $(".form-module-role").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            if (confirm("is right?")) {
                $.ajax({
                    url: url + "/permission-management/module-role/save",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.href = responses.url;
                        }, 4500);
                    },
                    error: function (response) {
                        $.each(response.responseJSON, function (key, value) {
                            toastr.error(value);
                        });
                    },
                });
            }
        });
    };

    return {
        init: function () {
            handleInputTag();
            handleTabClick();
            handleSubmitModuleRole();
            handleIsAccess();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
