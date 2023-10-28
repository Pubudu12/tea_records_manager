
$("#loginForm").validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        password: {
            required: true,
        }
    },
    messages: {
        email: {
            required: "Email is required.",
        },
        password: {
            required: "Password is required.",
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
