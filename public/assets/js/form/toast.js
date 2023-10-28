(function($) {
    showSuccessToast = function(text) {
      'use strict';
      resetToastPosition();
      $.toast({
        heading: 'Success',
        text: text,
        showHideTransition: 'fade',
        loader: true,
        stack: 10,
        hideAfter: 5000,
        icon: 'success',
        bgColor: '#0f3b59',
        loaderBg: '#081e2d',
        position: 'top-right'
      })
    };
    showInfoToast = function(toastText) {
      'use strict';
      resetToastPosition();
      $.toast({
        heading: 'Info',
        text: toastText,
        textAlign: 'left',
        loader: true,
        stack: 10,
        hideAfter: 5000,
        showHideTransition: 'fade',
        icon: 'info',
        position: 'top-right',
        bgColor: '#439aff',
        loaderBg: '#216da3',
      })
    };
    showWarningToast = function(toastText) {
      'use strict';
      resetToastPosition();
      $.toast({
        heading: 'Warning',
        text: toastText,
        showHideTransition: 'fade',
        loader: true,
        stack: 10,
        hideAfter: 5000,
        icon: 'warning',
        bgColor: '#ffc301',
        loaderBg: '#cd9d00',
        position: 'top-right'
      })
    };
    showDangerToast = function(toastText) {
      'use strict';
      resetToastPosition();
      $.toast({
        heading: 'Danger',
        text: toastText,
        showHideTransition: 'fade',
        icon: 'error',
        stack: 10,
        hideAfter: 5000,
        bgColor: '#f50f38',
        loaderBg: '#c9082b',
        position: 'top-right'
      })
    };
    showToastPosition = function(position) {
      'use strict';
      resetToastPosition();
      $.toast({
        heading: 'Positioning',
        text: 'Specify the custom position object or use one of the predefined ones',
        position: String(position),
        icon: 'info',
        stack: false,
        loaderBg: '#f96868'
      })
    }
    showToastInCustomPosition = function() {
      'use strict';
      resetToastPosition();
      $.toast({
        heading: 'Custom positioning',
        text: 'Specify the custom position object or use one of the predefined ones',
        icon: 'info',
        position: {
          left: 120,
          top: 120
        },
        stack: false,
        loaderBg: '#f96868'
      })
    }
    resetToastPosition = function() {
      $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
      $(".jq-toast-wrap").css({
        "top": "",
        "left": "",
        "bottom": "",
        "right": ""
      }); //to remove previous position style
    }
  })(jQuery);






// function validUrl(url){
//     url_validate = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
//     if(url_validate.test( url )){
//         return true;
//     } else {
//         return false;
//     }
// }
function afterSuccess(key, url){


    switch(key){
        case 'save':
            //No Action
        break;

        case 'refresh':
            //Redirect same page
            window.location = window.location.href;
        break;

        case 'next':

            console.log('url',url)
            window.location = url;

        break;

    }

}
