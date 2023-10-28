$('.form-btn-submit').on('click', function(e){

    let CanISubmitForm = false;

    e.preventDefault();

    var clickedBtn = $(this);
    var form = clickedBtn.parents('form');
    var formId = form.attr('id');

    var doValidation = form.data('validate');

    if(doValidation){

        let validation = $("#"+formId).valid();

        console.log('doValidation', doValidation)
        console.log('validation', validation)

        if(validation){
            // Validation Pass
            CanISubmitForm = true;
        }else{
            // Validation Failed
            return false;
        }
    }else{
        // No Validation - Straight Submit
        CanISubmitForm = true;
    }


    if(CanISubmitForm){
        //validation pass
        // Process to submit

        showDomLoading(form)

        var actionAfterSuccess = clickedBtn.attr('data-submitAfter');
        var redirectUrl = form.find('.form-btn-next').attr('href');
        
        // Custom refresh
        if ($('#refresh').val()) {
            actionAfterSuccess = 'refresh';            
            redirectUrl = $('#refresh').val();            
        }
        
        // Ajax Form
        var formData = new FormData(form[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        let url = form.attr('action')
        console.log('form.attr() - url', url)

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (res) {

                // console.log('Submit '+formId+' Form Response', res)

                if(res.result == 1){
                    showSuccessToast(res.message);

                    setTimeout(function(){
                        afterSuccess(actionAfterSuccess, redirectUrl);
                    }, 1000)
                }else{
                    showDangerToast(res.message);
                }

                hideDomLoading(form)


            },
            error:function(err){

                console.error('Submit '+formId+' Form Error', err)
                showDangerToast(err.message)
                hideDomLoading(form)

            }
        });


    } // CanISubmitForm END


});



// delete
function deleteItem(e){

    var dId = $(e).data('id');
    var redirectUrl = $(e).data('refresh');
    var dUrl = $(e).data('url');
    var dKey = $(e).data('key');

    var actionAfterSuccess = $(e).data('submitAfter');
    
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

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Ajax Start
                    $.ajax({
                        type: 'GET',
                        url: dUrl,
                        data: {'id': dId, 'delete': dKey},
                        dataType: 'json',
                        success: function (response) {                            

                            if(response['result'] == 1){
                                console.log(response['redirect']);
                                
                                showSuccessToast(response.message);
                                
                                setTimeout(function () {
                                    location.reload()
                                }, 1000);
                                // console.log(redirectUrl)

                            }else{
                                showDangerToast(response.message);
                            }

                            hideFullPageLoading()

                        }, // success
                        error:function(err){
                            console.log('err');
                            console.log(err);
                            showDangerToast('Error');
                            // alert(err)
                            hideFullPageLoading()
                        }
                    }); // ajax end

                },
            }

        }
    });


} //deleteItem