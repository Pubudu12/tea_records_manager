function callDelete(values) {

    sale_code = values.getAttribute('data-sale_code')
        
    $.alert({
        theme: 'modern' ,
        type: 'red',
        typeAnimated: true,
        title:'Are you Sure ?',
        content: 'This action cannot be taken back. All the report related data will be deleted. Press submit to proceed!',
        btnClass: 'btn-red',
        buttons:{
            submit: function () {              
                $.confirm({
                    theme: 'modern' ,
                    title: 'Delete!',
                    type: 'red',
                    content: '' +
                    '<form action="" class="formName">' +
                        '<div class="container pt-1">' +
                            '<label>Type DELETE here to proceed.</label>' +
                            '<input type="text" placeholder="DELETE" class="name form-control" required />' +
                        '</div>' +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Delete',
                            btnClass: 'btn-red',
                            action: function () {
                                var deleteText = this.$content.find('.name').val();
                                if(!deleteText){
                                    $.alert({
                                        theme: 'modern' ,
                                        type: 'red',
                                        content: 'provide a valid text!',
                                        btnClass: 'btn-default',
                                    });
                                    return false;
                                }

                                if (deleteText == 'DELETE') {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                            
                                    $.ajax({
                                        type: 'DELETE',
                                        url: '/delete_report/'+sale_code,
                                        data: {
                                            'sale_code':sale_code
                                        },
                                        dataType: 'json',
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        success: function (res) {
                                            console.log('succss')
                                            console.log(res)

                                            if (res.result == 1) {
                                                
                                                    $.toast({
                                                        heading: 'Success',
                                                        text: res.message,
                                                        showHideTransition: 'fade',
                                                        loader: true,
                                                        stack: 10,
                                                        hideAfter: 5000,
                                                        icon: 'success',
                                                        bgColor: '#0f3b59',
                                                        loaderBg: '#081e2d',
                                                        position: 'top-right'
                                                    })
                                                   
                                                setTimeout(function(){
                                                    window.location = window.location.href
                                                }, 2000)

                                            } else {
                                                $.toast({
                                                    heading: 'Danger',
                                                    text: res.message,
                                                    showHideTransition: 'fade',
                                                    icon: 'error',
                                                    stack: 10,
                                                    hideAfter: 5000,
                                                    bgColor: '#f50f38',
                                                    loaderBg: '#c9082b',
                                                    position: 'top-right'
                                                })   
                                            }                                           
                                        },
                                        error:function(err){
                                            console.log('error')   
                                            // console.log(err)       
                                            
                                            $.toast({
                                                heading: 'Danger',
                                                text: 'Error occured!',
                                                showHideTransition: 'fade',
                                                icon: 'error',
                                                stack: 10,
                                                hideAfter: 5000,
                                                bgColor: '#f50f38',
                                                loaderBg: '#c9082b',
                                                position: 'top-right'
                                            })             
                                        }
                                    });
                                }else{
                                    $.alert({
                                        theme: 'modern' ,
                                        type: 'red',
                                        content: 'Type DELETE on the text box!',
                                        btnClass: 'btn-default',
                                    });
                                }                               
                            }
                        },
                        cancel: function () {
                            //close
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            },
            cancel: function () {
                //close
            },
        }
    });
}
