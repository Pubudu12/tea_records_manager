$("#commentForm").validate({
    rules: {
        overallSaleNo: {
            required: true,
            // minlength: 6
        },
        overallSaleTxtArea: {
            required: true,
        },
        wQBestBop: {
            required: true,
            // minlength: 6
        },
        wQBestBopf: {
            required: true,
        },
        wQBelowBop: {
            required: true,
            // minlength: 6
        },
        wQBelowBopf: {
            required: true,
        },
        wQPlainerBop: {
            required: true,
            // minlength: 6
        },
        wQPlainerBopf: {
            required: true,
        },
        wQNuwaraEliyaBop: {
            required: true,
        },
        wQNuwaraEliyaBopf: {
            required: true,
        },
        cTCHighBP1: {
            required: true,
        },
        cTCMediumBP1: {
            required: true,
        },
        cTCLowBP1: {
            required: true,
        },
        cTCHighPF1: {
            required: true,
        },
        cTCMediumPF1: {
            required: true,
        },
        cTCLowPF1: {
            required: true,
        },
        lowGrownBopBest: {
            required: true,
        },
        lowGrownBopBelow: {
            required: true,
        },
        lowGrownBopPlainer: {
            required: true,
        },
        lowGrownBopfBest: {
            required: true,
        },
        lowGrownBopfBelow: {
            required: true,
        },
        lowGrownBopfPlainer: {
            required: true,
        },
        lGTippySelectBop: {
            required: true,
        },
        lGTippyBestBop: {
            required: true,
        },
        lGTippyBelowBop: {
            required: true,
        },
        lGTippySelectBopf: {
            required: true,
        },
        lGTippyBestBopf: {
            required: true,
        },
        lGTippyBelowBopf: {
            required: true,
        },
        lGTippySelectBopf1: {
            required: true,
        },
        lGTippyBestBopf1: {
            required: true,
        },
        lGTippyBelowBopf1: {
            required: true,
        },
        premiumFlowBopSelect: {
            required: true,
        },
        premiumFlowBopBest: {
            required: true,
        },
        premiumFlowBopBelow: {
            required: true,
        },
        premiumFlowBopfSelect: {
            required: true,
        },
        premiumFlowBopfBest: {
            required: true,
        },
        premiumFlowBopfBelow: {
            required: true,
        }
    },
    messages: {
        overallSaleNo: {
            required: "This field is required.",
            // minlength: "Your username must consist of at least 6 characters"
        },
        overallSaleTxtArea: {
            required: "This field is required.",
        },
        wQBestBop: {
            required: "This field is required.",
            // minlength: "Your username must consist of at least 6 characters"
        },
        wQBestBopf: {
            required: "This field is required.",
        },
        wQBelowBop: {
            required: "This field is required.",
            // minlength: "Your username must consist of at least 6 characters"
        },
        wQBelowBopf: {
            required: "This field is required.",
        },
        wQPlainerBop: {
            required: "This field is required.",
            // minlength: "Your username must consist of at least 6 characters"
        },
        wQPlainerBopf: {
            required: "This field is required.",
        },
        wQNuwaraEliyaBop: {
            required: "This field is required.",
        },
        wQNuwaraEliyaBopf: {
            required: "This field is required.",
        },
        cTCHighBP1: {
            required: "This field is required.",
        },
        cTCMediumBP1: {
            required: "This field is required.",
        },
        cTCLowBP1: {
            required: "This field is required.",
        },
        cTCHighPF1: {
            required: "This field is required.",
        },
        cTCMediumPF1: {
            required: "This field is required.",
        },
        cTCLowPF1: {
            required: "This field is required.",
        },
        lowGrownBopBest: {
            required: "This field is required.",
        },
        lowGrownBopBelow: {
            required: "This field is required.",
        },
        lowGrownBopPlainer: {
            required: "This field is required.",
        },
        lowGrownBopfBest: {
            required: "This field is required.",
        },
        lowGrownBopfBelow: {
            required: "This field is required.",
        },
        lowGrownBopfPlainer: {
            required: "This field is required.",
        },
        lGTippySelectBop: {
            required: "This field is required.",
        },
        lGTippyBestBop: {
            required: "This field is required.",
        },
        lGTippyBelowBop: {
            required: "This field is required.",
        },
        lGTippySelectBopf: {
            required: "This field is required.",
        },
        lGTippyBestBopf: {
            required: "This field is required.",
        },
        lGTippyBelowBopf: {
            required: "This field is required.",
        },
        lGTippySelectBopf1: {
            required: "This field is required.",
        },
        lGTippyBestBopf1: {
            required: "This field is required.",
        },
        lGTippyBestBopf1: {
            required: "This field is required.",
        },
        premiumFlowBopfSelect: {
            required: "This field is required.",
        },
        premiumFlowBopfBest: {
            required: "This field is required.",
        },
        premiumFlowBopfBelow: {
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