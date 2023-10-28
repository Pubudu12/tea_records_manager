
function summerNoteCall(element){

    element.summernote({
        placeholder: 'write here...',
        height: 800,
        minHeight: null,
        maxHeight: null,
        focus: true,
        airMode: false,
        styleTags: [
            'p',
                { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
            ],
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
            
            ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture', 'video']],
            ['table', ['table']],
            ['view', ['fullscreen']],
          ]
      });

} //summerNoteCall

function addNewSec(){

    var fetchURL = ROOT_URL+'products/ajax/controller/viewProductController.php';

    $.ajax({

        type: 'POST',
        url: fetchURL,
        data: {
            'addNewSec' : 'addNewSec'
        },
        dataType: 'json',
        success:function(res){

            $("#section_area").append(res.file);

        }, // success
        error:function(err){

        } // Error

    });

} //addNewLine


function editSections(e){

    var parentBox = $(e).parents('.sec-textBox');
    var contentBox = parentBox.find('.sec-content');

    summerNoteCall(contentBox);

} //editSections

function saveSections(e){

    var productId = $("#product_id").val();

    var parentBox = $(e).parents('.sec-textBox');
    var rowId = parentBox.find('.sec-row_id').val();
    var title = parentBox.find('.sec-title').val();
    var order = parentBox.find('.sec-order').val();

    var contentBox = parentBox.find('.sec-content');
    var summerNoteContent = contentBox.summernote('code');


    var fetchURL = ROOT_URL+'products/ajax/controller/updateProductController.php';

    showDomLoading(parentBox);

    var formDataPost = new FormData();
    formDataPost.append('productId', productId);
    formDataPost.append('rowId', rowId);
    formDataPost.append('title', title);
    formDataPost.append('order', order);
    formDataPost.append('summerNoteContent', summerNoteContent);
    formDataPost.append('addSection', 'yes');

    $.ajax({

        type: 'POST',
        url: fetchURL,
        data: formDataPost,
        dataType: 'json',
        cache : false,
        contentType : false,
        processType : false,
        processData: false,
        success:function(res){

            parentBox.find('.sec-row_id').val(res.id);
            hideDomLoading(parentBox);
        }, // success
        error:function(err){
            console.error(err);

            hideDomLoading(parentBox);
        } // Error

    });


    // Destory Summer Note
    contentBox.summernote('destroy');


} //saveSections

function deleteSection(e){

    var parentBox = $(e).parents('.sec-textBox');
    var rowId = parentBox.find('.sec-row_id').val();
    var deleteURL = ROOT_URL+'products/ajax/controller/deleteProductController.php';

    var productId = $("#product_id").val();

    var formDataPost = new FormData();
    formDataPost.append('productId', productId);
    formDataPost.append('rowId', rowId);
    formDataPost.append('deleteSec', 'yes');


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
                    showDomLoading(parentBox)
                    // Ajax Start
                    $.ajax({
                        type: 'POST',
                        url: deleteURL,
                        data: formDataPost,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (response) {

                            if(response['result'] == 1){
                                parentBox.remove()
                            }else{
                                console.error(response);
                            }

                            hideDomLoading(parentBox)
                        }, // success
                        error:function(err){
                            hideDomLoading(parentBox)
                        }
                    }); // ajax end 

                },
            }
            
        }
    });

} //deleteSection