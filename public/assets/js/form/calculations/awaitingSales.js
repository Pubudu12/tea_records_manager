
function currencyReverseFormat(n, decimal = 0) {
    var justOneDot = n.toString().replace(/[.](?=.*?\.)/g, '');//this replaces all but last dot
    return Number(parseFloat(Number(justOneDot.replace(/[^0-9.-]/g,''))).toFixed(decimal)) //parse as float and round to 2dp 
} 


$(".totLotsVal").attr("readonly", true)
$(".totQtyVal").attr("readonly", true)


function calculateLots(e) { 
    var lotsVal = $('.lotsVal');
    var total = 0;
    
    lotsVal.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });   
    
    $('.totLotsVal').val(total);  
}


function calculateQty(params) {
    var qtyVal = $('.qtyVal');

    var total = 0;
    qtyVal.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });

    $('.totQtyVal').val(total);   
}
