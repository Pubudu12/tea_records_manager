$("#reportForm-first").validate({
    rules: {
        title:{
            required: true,
        },
        year: {
            required: true,
        },
        month: {
            required: true,
        },
        sale_number: {
            required: true,
        },
        publish_date:{
            required: true
        },
        report_day_one:{
            required: true
        },
        report_day_two:{
            // required: true
        }
    },
    messages: {
        title: {
            required: "Title is required.",
        },
        year: {
            required: "Sales Average Name is required.",
        },
        month: {
            required: "Sales month Period is required.",
        },
        sale_number: {
            required: "Sales number is required.",
        },
        publish_date:{
            required: "Publish date Period is required.",
        },
        report_day_one:{
            required: "Auction day /01 is required.",
        },
        report_day_two:{
            // required: "Auction day /02 Period is required.",
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
        // alert('valid form submitted'); // for demo
        return true; // for demo
    }
});
