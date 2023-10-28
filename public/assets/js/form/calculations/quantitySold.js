
function currencyReverseFormat(n, decimal = 0) {
    var justOneDot = n.toString().replace(/[.](?=.*?\.)/g, '');//this replaces all but last dot
    return Number(parseFloat(Number(justOneDot.replace(/[^0-9.-]/g,''))).toFixed(decimal)) //parse as float and round to 2dp 
} 

function calculateTotal(e) {
 
    var td_value = $('.td-value');
    console.log(td_value)
    var total = 0;
    
    td_value.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });
    // return currencyFormat(total);
    // console.log((total))
    
    $('#totalValue').val(total);      
}

function calculateTodateTotal(e) {
 
    var td_value = $('.td-todate-value');
    console.log(td_value)
    var total = 0;
    
    td_value.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });
    // return currencyFormat(total);
    // console.log((total))
    
    $('#totalTodateValue').val(total);      
}
