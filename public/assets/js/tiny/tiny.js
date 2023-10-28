
tinymce.init({
    // entity_encoding : "raw",
    selector: '.textarea_tinny_1',
    font_family_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; AkrutiKndPadmini=Akpdmi-n',
    font_size_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt',
    line_height_formats: '1 1.2 1.4 1.6 2',
    height: 500,
    menubar : false,
    statusbar:true,
    plugins: [
      'save',
      'lists link image preview',
      'fullscreen',
      'table imagetools'
    ],

    // remove paste from plugins because table styles were affected with it

    toolbar: 'undo redo | styleselect | bold italic lineheight | fontfamily | fontsize | alignleft aligncenter alignright alignjustify | link image | table | save',
    formats: {
      alignleft: {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
      aligncenter: {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
      alignright: {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
      alignjustify: {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
      bold: {inline : 'span', 'classes' : 'bold'},
      italic: {inline : 'span', 'classes' : 'italic'},
      underline: {inline : 'span', 'classes' : 'underline', exact : true},
      strikethrough: {inline : 'del'},
      forecolor: {inline : 'span', classes : 'forecolor', styles : {color : '%value'}},
      hilitecolor: {inline : 'span', classes : 'hilitecolor', styles : {backgroundColor : '%value'}},
      custom_format: {block : 'h1', attributes : {title : 'Header'}, styles : {color : 'red'}}
    },
    // plugins: [

    //   'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',

    //   'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',

    //   'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'

    // ],

    // toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +

    //   'alignleft aligncenter alignright alignjustify | ' +

    //   'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help',


    image_title: true,
  /* enable automatic uploads of images represented by blob or data URIs*/
  automatic_uploads: true,
  /*
    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
    images_upload_url: 'postAcceptor.php',
    here we add custom filepicker only to Image dialog
  */
  file_picker_types: 'image',
  /* and here's our custom image picker*/
  file_picker_callback: function (cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');

    /*
      Note: In modern browsers input[type="file"] is functional without
      even adding it to the DOM, but that might not be the case in some older
      or quirky browsers like IE, so you might want to add it to the DOM
      just in case, and visually hide it. And do not forget do remove it
      once you do not need it anymore.
    */

    input.onchange = function () {
      var file = this.files[0];

      var reader = new FileReader();
      reader.onload = function () {
        /*
          Note: Now we need to register the blob in TinyMCEs image blob
          registry. In the next release this part hopefully won't be
          necessary, as we are looking to handle it internally.
        */
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);

        /* call the callback and populate the Title field with the file name */
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
    };

    input.click();
  },
   
    
  // on save ajax call
    save_onsavecallback: function () { 
    
      let myForm = document.getElementById('reportForm');
      let newf = new FormData(myForm);

      console.log(myForm)
      console.log(myForm.action)
      console.log(myForm.type)
      
        var content = tinymce.activeEditor.getContent();
        // console.log(content);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });        

        $.ajax({
            type: myForm.method,
            url: myForm.action,
            data: newf,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (res) {

                if(res.result == 1){
                  console.log('succs')
                  console.log(res)
                  showSuccessToast(res.message);
                  
                }else{
                  
                  console.log(res)
                  showDangerToast(res.message);
                }
                // hideDomLoading(form)
            },
            error:function(err){
              showDangerToast(err);
              console.log(err)
            }
        });
    

     },
     save_oncancelcallback: function () { 
       
        showDangerToast('Error');
      }
  });