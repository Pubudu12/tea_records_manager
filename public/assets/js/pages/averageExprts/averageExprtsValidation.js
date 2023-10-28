$("#averageExportsForm").validate({
    rules: {
        salesExpName: {
            required: true,
            // minlength: 6
        },
        salesExpPeriod: {
            required: true,
        }
    },
    messages: {
        salesExpName: {
            required: "Sales Export Name is required.",
            // minlength: "Your username must consist of at least 6 characters"
        },
        salesExpPeriod: {
            required: "Sales Export Period is required.",
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