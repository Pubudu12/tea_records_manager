$("#create_user_form").validate({
    rules: {
        oos_Ttl: {
            required: true,
            // minlength: 6
        },
        sales_No: {
            required: true,
            // minlength: 6
        },
        year_oos: {
            required: true,
        },
        date_oos: {
            required: true,
        },
        ex_estate_lots: {
            required: true,
        },
        ex_estate_qty: {
            required: true,
        },
        mainSaleLots: {
            required: true,
        },
        mainSaleQty: {
            required: true,
        },
        lowGrownLeafyLot: {
            required: true,
        },
        lowGrownLeafyQty: {
            required: true,
        },
        lowGrownTippyLot: {
            required: true,
        },
        lowGrownTippyQty: {
            required: true,
        },
        premFloweryLot: {
            required: true,
        },
        premFloweryQty: {
            required: true,
        },
        hmoGradeDustLot: {
            required: true,
        },
        hmoGradeDustQty: {
            required: true,
        },
        offGradesLot: {
            required: true,
        },
        offGradesQty: {
            required: true,
        },
        dustLot: {
            required: true,
        },
        dustQty: {
            required: true,
        },
        rePrintTotal1: {
            required: true,
        },
        rePrintTotal2: {
            required: true,
        },
        buyerPrompt: {
            required: true,
        },
        sellerPrompt: {
            required: true,
        }
    },
    messages: {
      oos_Ttl: {
            required: "This field is required.",
            minlength: "Your username must consist of at least 6 characters"
        },
        sales_No: {
            required: "This field is required.",
            minlength: "Your password must be at least 6 characters long"
        },
        year_oos: {
            required: "This field is required.",
            minlength: "Your username must consist of at least 6 characters"
        },
        date_oos: {
            required: "This field is required.",
            minlength: "Your password must be at least 6 characters long"
        },
        ex_estate_lots: {
            required: "This field is required.",
            minlength: "Your username must consist of at least 6 characters"
        },
        ex_estate_qty: {
            required: "This field is required.",
        },
        mainSaleLots: {
            required: "This field is required.",
            minlength: "Your username must consist of at least 6 characters"
        },
        mainSaleQty: {
            required: "This field is required.",
        },
        lowGrownLeafyLot: {
            required: "This field is required.",
        },
        lowGrownLeafyQty: {
            required: "This field is required.",
        },
        lowGrownTippyLot: {
            required: "This field is required.",
        },
        lowGrownTippyQty: {
            required: "This field is required.",
        },
        premFloweryLot: {
            required: "This field is required.",
        },
        premFloweryQty: {
            required: "This field is required.",
        },
        hmoGradeDustLot: {
            required: "This field is required.",
        },
        hmoGradeDustQty: {
            required: "This field is required.",
        },
        offGradesLot: {
            required: "This field is required.",
        },
        offGradesQty: {
            required: "This field is required.",
        },
        buyerPrompt: {
            required: "This field is required.",
        },
        sellerPrompt: {
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