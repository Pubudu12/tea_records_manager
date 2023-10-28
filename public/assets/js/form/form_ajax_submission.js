
    $(".form-label-group").length&&$(".form-label-group").find("label").on("click",function(){$(this).parents(".form-label-group").find("input").focus()});


    function notifyMessage(message, title = null, status = null, notificationType = 1){

        switch (notificationType) {


            case 0:


                // No Success Notifications
                switch (status) {
                    case 1: // Success
                        // showSuccessToast(message);
                    break;

                    case 0: //Error
                        showDangerToast(message)
                    break;

                    default: //Default
                        showInfoToast(message)
                    break;
                }

                break;


            case 1:

                // Notification Type
                switch (status) {
                    case 1: // Success
                        successConfirmDialog(title, message);
                    break;

                    case 0: //Error
                        errorConfirmDialog(title, message)
                    break;

                    default: //Default
                        defaultConfirmDialog(title, message)
                    break;
                }

                break;

            case 2:

                switch (status) {
                    case 1: // Success
                        showSuccessToast(message);
                    break;

                    case 0: //Error
                        showDangerToast(message)
                    break;

                    default: //Default
                        showInfoToast(message)
                    break;
                }

                break;

            default:

                switch (status) {
                    case 1: // Success
                        showSuccessToast(message);
                    break;

                    case 0: //Error
                        showDangerToast(message)
                    break;

                    default: //Default
                        showInfoToast(message)
                    break;
                }



        } // Switch End



    } //notifyMessage



    function validUrl(url){
        url_validate = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if(url_validate.test( url )){
            return true;
        } else {
            return false;
        }
    }

    function afterSuccess(key, url){

        // IF actionAfterSuccess == 0 => No Action
        // IF actionAfterSuccess == 1 => No Refresh Same Page
        // IF actionAfterSuccess == 2 => Redirect to the given url
        // IF actionAfterSuccess == 3 => Click Button By ID
        switch(key){
            case 0:
                //No Action
            break;

            case 1:
                //Redirect same page
                window.location = window.location.href;
            break;

            case 2:

                if(validUrl(url)){
                    window.location = url;
                }else{
                    $("#clickhereForDataTable").click()
                    // console.log("function");
                }

            break;

            case 3:
                // This is to click the id
                // Only #ID
                $("#"+url).click();
            break;
        }

    }


    function clearFormFields(form){

        form.find('input[type="text"]').not('.dont_clear').val('');
    }

    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    // =============================================================================================
    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------

    // Submittions

    $(document).on("click",'.submit_form',function(){

        var form = $(this).parents('form');
        var doValidation = $(this).data('validate');

        if(doValidation == Number(1)){
            var formId = form.attr('id');
            var validation = $("#"+formId).valid();

            if(validation){
                //validation pass
                // Process to submit
            }else{
                //validation failed return to fill the form
                return false;
            }
        }// check whether do validation or not, if end



        var actionAfterSuccess = form.data('action-after');
        var redirectUrl = form.data('redirect-url');

        // 1 for confirm dialog box
        // 2 for notification dialog box
        var notificationTye = $(this).data('notify_type');
        if (typeof notificationTye == "undefined") {
            var notificationTye = 1;
        }


        // Loading
        showDomLoading(form)


        var formData = new FormData(form[0]);

        $.confirm({
            title: 'Are you sure?',
            theme: 'material',
            content: '<h6> Press confirm to process </h6>',
            buttons: {

                close: {
                    text: 'Close', // With spaces and symbols

                },
                ok: {
                    text: 'Confirm', // With spaces and symbols
                    action: function () {
                        showDomLoading(form)
                        // Ajax Start
                        $.ajax({
                            type: form.attr('method'),
                            url: form.attr('action'),
                            data: formData,
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (response) {

                                if(response['result'] == 1){

                                    notifyMessage(response['message'],"Success", 1, notificationTye);

                                    clearFormFields(form);

                                    setTimeout(function(){
                                        afterSuccess(actionAfterSuccess, redirectUrl);
                                    }, 1000)

                                }else{
                                    console.error(response);
                                    notifyMessage(response['message'],"Failed", 0, notificationTye);
                                }

                                hideDomLoading(form)
                            }, // success
                            error:function(err){
                                hideDomLoading(form)
                                notifyMessage('Please try again later',"Failed", 0, notificationTye);
                            }
                        }); // ajax end

                    },
                }

            }
        });

    });

    // Submit form without lconfirm dialog
    $(document).on("click",'.submit_form_no_confirm',function(){

        var form = $(this).parents('form');

        var formData = new FormData(form[0]);

        var doValidation = $(this).data('validate');

        if(doValidation == Number(1)){
            var formId = form.attr('id');
            var validation = $("#"+formId).valid();

            if(validation){
                //validation pass
                // Process to submit
            }else{
                //validation failed return to fill the form
                return false;
            }
        }// check whether do validation or not, if end


        // IF actionAfterSuccess == 0 => No Action
        // IF actionAfterSuccess == 1 => No Refresh Same Page
        // IF actionAfterSuccess == 2 => Redirect to the given url
        var actionAfterSuccess = form.data('action-after');
        var redirectUrl = form.data('redirect-url');

        // 1 for confirm dialog box
        // 2 for notification dialog box
        var notificationTye = $(this).data('notify_type');
        if (typeof notificationTye == "undefined") {
            var notificationTye = 1;
        }


        // Ajax Start

        showDomLoading(form)

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,

            success: function (response) {

                if(response['result'] == 1){

                    notifyMessage(response['message'],"Success", 1, notificationTye);

                    clearFormFields(form);

                    if (typeof response['redirectURL'] != "undefined") {
                        redirectUrl = response['redirectURL'];
                    }

                    setTimeout(function(){
                        afterSuccess(actionAfterSuccess, redirectUrl);
                    }, 1000)

                }else{

                    console.error(response);

                    notifyMessage(response['message'],"Failed", 0, notificationTye);
                }

                hideDomLoading(form)

            }, // success
            error:function(err){
                console.log('err');
                console.log(err);
                notifyMessage('Please try again later',"Failed", 0, notificationTye);
                // alert(err)
                hideDomLoading(form)
            }
        }); // ajax end


    });


    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    // =============================================================================================
    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------


    // delete
    function deleteItem(e){

        var dId = $(e).data('id');
        var redirectUrl = $(e).data('refresh');
        var dUrl = $(e).data('url');
        var dKey = $(e).data('key');

        var actionAfterSuccess = $(e).data('after-success');
        var notificationTye = 2;

        // Ajax
        $.confirm({
            title: 'Are you sure?',
            theme: 'material',
            content: '<h6> Press delete to process </h6>',
            type: 'red',
            buttons: {

                close: {
                    text: 'Close', // With spaces and symbols

                },
                ok: {
                    text: 'Delete', // With spaces and symbols
                    btnClass: 'btn-red',
                    action: function () {

                        showFullPageLoading()

                        // Ajax Start
                        $.ajax({
                            type: 'GET',
                            url: dUrl,
                            data: {'id': dId, 'delete': dKey},
                            dataType: 'json',
                            success: function (response) {

                                console.log(response);

                                if(response['result'] == 1){

                                    if (typeof response['redirectURL'] != "undefined") {
                                        redirectUrl = response['redirectURL'];
                                    }

                                    notifyMessage(response['message'],"Success", 1, notificationTye);
                                    setTimeout(function(){
                                        afterSuccess(actionAfterSuccess, redirectUrl);
                                    }, 1000)

                                }else{
                                    console.log(response['error']);

                                    notifyMessage(response['message'],"Failed", 0, notificationTye);
                                }

                                hideFullPageLoading()

                            }, // success
                            error:function(err){
                                console.log('err');
                                console.log(err);
                                notifyMessage('Please try again later',"Failed", 0, notificationTye);
                                // alert(err)
                                hideFullPageLoading()
                            }
                        }); // ajax end

                    },
                }

            }
        });


    } //deleteItem


    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    // =============================================================================================
    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------

    function singleOperations(e, prompt=true){

        let loadingDom = $(e);

        var dId = $(e).data('id');
        var redirectUrl = $(e).data('refresh');
        var dUrl = $(e).data('url');
        var dKey = $(e).data('key');
        var actionAfterSuccess = $(e).data('after-success');

        var notificationTye = 2;


        // If Confirm Dialog Box True
        if(prompt){



            $.confirm({
                title: 'Are you sure?',
                theme: 'material',
                content: '<h6> Press confirm to process </h6>',
                type: 'dark',
                buttons: {

                    close: {
                        text: 'Close', // With spaces and symbols

                    },
                    ok: {
                        text: 'Confirm', // With spaces and symbols
                        btnClass: 'btn-green',
                        action: function () {

                            showDomLoading(loadingDom);

                            // Ajax Start
                            $.ajax({
                                type: 'POST',
                                url: dUrl,
                                data: {'id': dId, 'singleOperations': dKey},
                                dataType: 'json',
                                success: function (response) {

                                    if(response['result'] == 1){

                                        if (typeof response['redirectURL'] != "undefined") {
                                            redirectUrl = response['redirectURL'];
                                        }

                                        notifyMessage(response['message'],"Success", 1, notificationTye);
                                        setTimeout(function(){
                                            afterSuccess(actionAfterSuccess, redirectUrl);
                                        }, 1000)

                                    }else{

                                        notifyMessage(response['message'],"Failed", 0, notificationTye);
                                    }

                                    showDomLoading(loadingDom);

                                }, // success
                                error:function(err){
                                    console.log('err');
                                    console.log(err);
                                    notifyMessage('Please try again later',"Failed", 0, notificationTye);
                                    // alert(err)

                                    showDomLoading(loadingDom);
                                }
                            }); // ajax end

                        },
                    }

                }
            });


        }else{

            showDomLoading(loadingDom);

            $.ajax({
                type: 'POST',
                url: dUrl,
                data: {'id': dId, 'singleOperations': dKey},
                dataType: 'json',
                success: function (response) {

                    if(response['result'] == 1){

                        if (typeof response['redirectURL'] != "undefined") {
                            redirectUrl = response['redirectURL'];
                        }

                        notifyMessage(response['message'],"Success", 1, notificationTye);
                        setTimeout(function(){
                            afterSuccess(actionAfterSuccess, redirectUrl);
                        }, 1000)

                    }else{

                        notifyMessage(response['message'],"Failed", 0, notificationTye);
                    }

                    showDomLoading(loadingDom);

                }, // success
                error:function(err){
                    console.log('err');
                    console.log(err);
                    notifyMessage('Please try again later',"Failed", 0, notificationTye);
                    // alert(err)

                    showDomLoading(loadingDom);
                }
            }); // Ajax End



        } // End end



    } //singleOperations



    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    // =============================================================================================
    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------

    // Enter form submit
    if($('.submit_form').length){
        $('.submit_form').parents('form').submit(function(e){
            e.preventDefault();
            // $(this).find('.submit_form').click();
        });
    } // Submit Form Check If End


    if($('.submit_form_no_confirm').length){
        $('.submit_form_no_confirm').parents('form').submit(function(e){
            e.preventDefault();
            // $(this).find('.submit_form_no_confirm').click();
        });
    } //submit_form_no_confirm end




    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    // =============================================================================================
    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
