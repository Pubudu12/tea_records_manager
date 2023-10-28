$("#detailForm").validate({
    rules: {
        cataloguesSalesNo: {
            required: true,
        },
        cataloguesDate: {
            required: true,
        },
        cataloguesComments: {
            required: true,
        }
    },
    messages: {
        cataloguesSalesNo: {
            required: "This field is required.",
        },
        cataloguesDate: {
            required: "This field is required.",
        },
        cataloguesComments: {
            required: "This field is required.",
        }
    },
    errorPlacement: function(label, element) {
        label.addClass('mt-2 text-danger');
        label.insertAfter(element);
    },
    highlight: function(element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
    },
    submitHandler: function (form) { // for demo
        alert('valid form submitted'); // for demo
        // return false; // for demo
    }
});