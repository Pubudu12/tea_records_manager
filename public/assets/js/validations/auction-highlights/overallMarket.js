
// $.validator.addMethod("validateOverall", function (value, element) {
//     alert('called')
//         var flag = true;
                
//         $("[name^=overall_markrt_qty]").each(function (i, j) {
            
//         // $(this).parent('p').find('label.error').remove();
//         // $(this).parent('p').find('label.error').remove();                        
//         if ($.trim($(this).val()) === '') {
//             flag = false;
//             console.log('called inside')
            
//             $(this).parent('p').append('<label  id="id_ct'+i+'-error" class="error">This field is required.</label>');
//         }
//     });
                           
//     return flag;
// }, "");


$("#reportForm").validate({
    rules: {
        "overall_markrt_qty[]":{
            validateOverall: true,
        },
        "overall_demand[]": {
            required: true,
        },
    },
    messages: {
        "overall_markrt_qty[]":{
            required: "Enter Quantity in (M/Kgs).",
        },
        "overall_demand[]": {
            required: "Enter Average Price in LKR.",
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