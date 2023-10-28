


// Auto Ajax Loading Call
// $(document).ajaxStart(function(){
//     $.LoadingOverlay("show");
// });
// $(document).ajaxStop(function(){
//     $.LoadingOverlay("hide");
// });
// End
    

// Full Page Loading
function showFullPageLoading(){
    $('body').waitMe({
        effect : 'stretch',
    });
} //showFullPageLoading

function hideFullPageLoading(){
    $('body').waitMe("hide");
} //hideFullPageLoading




// DOM Element Loading
function showDomLoading(e){

    if($(e).is(':visible')){
            
        if (e.length) {

            e.waitMe({
                effect : 'stretch',
            });
    
        }
    } // Visible Check

} //showDomLoading

function hideDomLoading(e){
    if (e.length) {
        e.waitMe("hide");
    }
    
} //hideDomLoading



// let body = $('body');
// showDomLoading(body);
// showFullPageLoading()
// hideDomLoading(body);
