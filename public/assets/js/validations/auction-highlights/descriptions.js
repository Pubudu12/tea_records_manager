
$("#reportForm").validate({
    rules: {
        highlight_name:{
            required: true,
        },
    },
    messages: {
        highlight_name:{
            required: "Enter the title.",
        },
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
        // alert('valid form submitted'); // for demo
        // return false; // for demo
    }
});