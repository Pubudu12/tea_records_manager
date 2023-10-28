
$("#reportForm").validate({
    rules: {
        qty:{
            required: true,
        },
        avg_lkr: {
            required: true,
        },
        avg_usd: {
            required: true,
        },
    },
    messages: {
        qty:{
            required: "Enter Quantity in (M/Kgs).",
        },
        avg_lkr: {
            required: "Enter Average Price in LKR.",
        },
        avg_usd: {
            required: "Enter Average Price in USD.",
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