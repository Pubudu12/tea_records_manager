function removeMarkWithDBdata(input) {

   console.log(input)
    var dId = $(input).data('id');
    var redirectUrl = $(input).data('refresh');
    var dUrl = $(input).data('url');
    console.log(dUrl)
    var dKey = $(input).data('key');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'DELETE',
        url: dUrl,
        data: {'id': dId, 'delete': dKey},
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            console.log('succss')
            console.log(res)

            if (res.result == 1) {               
                    
                    showSuccessToast(res.message);

                    setTimeout(function(){
                        window.location = window.location.href;
                    }, 2000)                   

            } else {
                showDangerToast(res.message);
            }                                           
        },
        error:function(err){
            console.log('error')   
            console.log(err)       
            
            showDangerToast('Error Occurred!');
          
        }
    });
}//removeMarkWithDBdata


function removeMark(params) {
    var numberOfRows = $('#link_section #add-link').length;
    if( Number(numberOfRows) > 1 ){
        $(params).parent().parent().remove();
    }
}