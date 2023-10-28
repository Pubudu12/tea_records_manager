
function currencyReverseFormat(n, decimal = 0) {
    var justOneDot = n.toString().replace(/[.](?=.*?\.)/g, '');//this replaces all but last dot
    return Number(parseFloat(Number(justOneDot.replace(/[^0-9.-]/g,''))).toFixed(decimal)) //parse as float and round to 2dp 
} 

$(".totctc").attr("readonly", true)
$(".totctc_ch_act").attr("readonly", true)
$(".totctc_ch_perc").attr("readonly", true)
$(".tot_orth").attr("readonly", true)
$(".tot_orth_ch_act").attr("readonly", true)
$(".tot_orth_ch_perc").attr("readonly", true)


function calculateCTCTotal(e) {
 
    var ctc_value = $('.ctc-value');
   
    // console.log(ctc_value)
    var total = 0;
    
    ctc_value.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });
    
   
    // return currencyFormat(total);
    // console.log((total))
    
    $('.totctc').val(total);  
    // $(".totctc").attr("readonly", true)    
}


function calculateCTCActutalTotal(params) {
    var ctc_ch_act_value = $('.ctc_ch_act_value');

    var total = 0;
    ctc_ch_act_value.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });

    $('.totctc_ch_act').val(total);   
}

function calculateCTCPercentTotal(params) {
    var ctc_ch_perc_value = $('.ctc_ch_perc_value');
    var total = 0;

    ctc_ch_perc_value.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });

    $('.totctc_ch_perc').val(total);   
}

function calculateOrthTotal(params) {
    var orth_value = $('.orth_value');
    var total = 0;

    orth_value.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });
    $('.tot_orth').val(total);   
}

function calculateOrthActualTotal(params) {
    var orth_ch_act_value = $('.orth_ch_act_value');
    var total = 0;

    orth_ch_act_value.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });
    $('.tot_orth_ch_act').val(total);   
}

function calculateOrthPercentTotal(params) {
        
    var orth_ch_perc_value = $('.orth_ch_perc_value');
    var total = 0;
    
    orth_ch_perc_value.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });

    $('.tot_orth_ch_perc').val(total);   
}
