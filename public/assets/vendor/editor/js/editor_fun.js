    function editorNotification(status, message){
        
        if(status == 1){
            notifyMessage("Success",message,"success","fa fa-check");
        }else{
            notifyMessage("Failed",message,"danger","fa fa-exclamation");
        }

    } //editorNotification
    
    function storeData(url, data, key, id = 0){

        $.ajax({

            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                'data': data,
                'key' : key,
                'id' : id
            },
            success:function(res) {
                console.log(res);
                if(res.result == 1){
                    editorNotification(1, res.message);
                }else{
                    editorNotification(0, res.message);
                }
            },
            error:function(err) {
                console.error(err);
            }

        });

    } //storeData
    
    function editorInitialized(editorData){

        const editorSaveButton = document.getElementById('editorSaveButton');
        const postURL = editorSaveButton.getAttribute('data-url');
        const postKey = editorSaveButton.getAttribute('data-key');
        const postId = editorSaveButton.getAttribute('data-id');

        var editor = new EditorJS({
            /**
            * Wrapper of Editor
            */
            holder: 'editorjs',
    
            /**
            * Tools list
            */
            tools: {
                /**
                * Each Tool is a Plugin. Pass them via 'class' option with necessary settings {@link docs/tools.md}
                */
                header: {
                    class: Header,
                    inlineToolbar: ['link'],
                    config: {
                        placeholder: 'Header'
                    },
                    shortcut: 'CMD+SHIFT+H'
                },
    
                /**
                * Or pass class directly without any configuration
                */
                image: {
                    class: SimpleImage,
                    inlineToolbar: true
                },

                // personality: {
                //     class: Personality,
                //     config: {
                //         endpoint: 'http://localhost'  // Your backend file uploader endpoint
                //     }
                // },
    
                list: {
                    class: List,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+L'
                },
    
                checklist: {
                    class: Checklist,
                    inlineToolbar: true,
                },
    
                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    config: {
                        quotePlaceholder: 'Enter a quote',
                        captionPlaceholder: 'Quote\'s author',
                    },
                    shortcut: 'CMD+SHIFT+O'
                },
    
                warning: Warning,
    
                marker: {
                    class:  Marker,
                    shortcut: 'CMD+SHIFT+M'
                },
    
                code: {
                    class:  CodeTool,
                    shortcut: 'CMD+SHIFT+C'
                },
    
                delimiter: Delimiter,
    
                inlineCode: {
                    class: InlineCode,
                    shortcut: 'CMD+SHIFT+C'
                },
    
                linkTool: LinkTool,
    
                embed: Embed,
    
                table: {
                    class: Table,
                    inlineToolbar: true,
                    shortcut: 'CMD+ALT+T'
                },
    
            },
    
            /**
            * This Tool will be used as default
            */
            // initialBlock: 'paragraph',
    
            /**
            * Initial Editor data
            */
            data: {
                blocks: editorData
            },
            onReady: function(){
                // editorSaveButton.click();
            },
            onChange: function() {
                // console.log('something changed');
            }
        });

        /**
        * Saving example
        */

        editorSaveButton.addEventListener('click', function () {
            editor.save().then((savedData) => {
                storeData(postURL, savedData, postKey, postId);
                console.log(savedData)
            });
        });

    } //editorInitialized

    function loadEditorData(){
        
        var fieldId = $("#load_editor_data");
        var fetchUrl = fieldId.data('url');
        var loadKey = fieldId.data('load_key');
        var dataId = fieldId.data('id');

        $.ajax({

            type: 'POST',
            url: fetchUrl,
            dataType: 'json',
            data: {
                'editor_loadKey' : loadKey,
                'dataId' : dataId,
            },
            success:function(res){
                editorInitialized(res.data);
            },
            error:function(err){
                console.error(err);
                editorNotification(0, "Failed to load the content");
            }

        });

    } //loadEditorData

    loadEditorData();