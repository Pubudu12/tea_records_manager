
$("#userForm").validate({
    rules: {
        name:{
            required: true,
        },
        email: {
            required: true,
            email: true
        },
        role: {
            required: true,
        },
        password: {
            required: true,
            minlength: 6
        },
        c_password:{
            required: true,
            minlength: 6,
            equalTo: '#password'
        }
    },
    messages: {
        name:{
            required: "Name is required.",
        },
        email: {
            required: "Email is required.",
        },
        role: {
            required: "Role is required.",
        },
        password: {
            required: "Password is required.",
        },
        c_password:{
            required: "Comfirm password is required.",
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



$("#updateUserForm").validate({
    rules: {
        name:{
            required: true,
        },
        email: {
            required: true,
            email: true
        },
        role: {
            required: true,
        },
        password: {
            required: false,
            minlength: 6
        },
        c_password:{
            required: false,
            minlength: 6,
            equalTo: '#password'
        }
    },
    messages: {
        name:{
            required: "Name is required.",
        },
        email: {
            required: "Email is required.",
        },
        role: {
            required: "Role is required.",
        },
        password: {
            required: "Password is required.",
        },
        c_password:{
            required: "Comfirm password is required.",
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
