var Index = (function () {
    const csrf_token = $('meta[name="csrf_token"]').attr("content");

    //bug show data when load the tab
    var handleTabClick = function () {
        $(".group-tab-custom").on("click", function () {
            const groupValue = $(this).data("group");
            const moduleValue = $(this).data("module");
            const panelName = $(this).data("panel");

            let idButtonName = "#btn-update-" + panelName;
            let idFunctionName = "#function-field-" + panelName;
            let idAccessName = "#is-access-" + panelName;
            let idFormValuesName = "#form-values-" + panelName;
            let idGroupValues = "#group-values-" + panelName;

            $(idGroupValues).val(groupValue);

            handleIsAccess(idAccessName);
            $.ajax({
                type: "POST",
                url: url + "/admin/module-permission/module-role/show",
                data: {
                    _token: csrf_token,
                    uGroup: groupValue,
                    uModule: moduleValue,
                },
                success: function (response) {
                    var responseValue = response.value;
                    $(idAccessName).append(
                        $("<option>", {
                            value: responseValue.id,
                            text: responseValue.text,
                            attr: "selected",
                        })
                    );
                    $(idFunctionName).val(responseValue.function);
                    $(idFunctionName).tagsinput();
                    $(idFormValuesName).val(responseValue.formValue);
                    $(idButtonName).removeAttr("disabled");
                },
                error: function (response) {
                    toastr.error(response.responseJSON.message);
                    $(idFunctionName).val("");
                    $(idButtonName).attr("disabled", "disabled");
                },
            });
        });
    };

    var handleIsAccess = function (idAccessName) {
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

        $(idAccessName).select2({
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
                    url: url + "/admin/module-permission/module-role/update",
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
            handleTabClick();
            handleSubmitModuleRole();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
