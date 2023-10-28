function defaultConfirmDialog(title, message){

    $.confirm({
        title: title,
        theme: 'material',
        content: '<h6>'+message+'</h6>',
        buttons: {

            close: {
                text: 'Close', // With spaces and symbols

            }

        }
    });

} //defaultConfirmDialog


function successConfirmDialog(title, message){
    $.confirm({
        title: title,
        theme: 'material',
        content: '<h6>'+message+'</h6>',
        type: 'green',
        buttons: {

            close: {
                text: 'Close', // With spaces and symbols
            }

        }
    });
} //successConfirmDialog


function errorConfirmDialog(title, message){

    $.confirm({
        title: title,
        theme: 'material',
        content: '<h6>'+message+'</h6>',
        type: 'red',
        icon: 'fa fa-warning',
        buttons: {

            close: {
                text: 'Close', // With spaces and symbols

            }

        }
    });

} //errorConfirmDialog

