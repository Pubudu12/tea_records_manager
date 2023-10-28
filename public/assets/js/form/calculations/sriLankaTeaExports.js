
function currencyReverseFormat(n, decimal = 0) {
    var justOneDot = n.toString().replace(/[.](?=.*?\.)/g, '');//this replaces all but last dot
    return Number(parseFloat(Number(justOneDot.replace(/[^0-9.-]/g,''))).toFixed(decimal)) //parse as float and round to 2dp 
} 

$(".totVPrice").attr("readonly", true)
$(".totValuePrice").attr("readonly", true)
$(".totApproxPrice").attr("readonly", true)


function calculateVPrice(e) { 
    var vPrice = $('.VPrice');
    var total = 0;
    
    vPrice.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });   
    
    $('.totVPrice').val(total);  
}


function calculateValuePrice(params) {
    var valuePrice = $('.valuePrice');

    var total = 0;
    valuePrice.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });

    $('.totValuePrice').val(total);   
}

function calculateApproxPrice(params) {
    var approxPrice = $('.approxPrice');
    var total = 0;

    approxPrice.each(function(){
        total += parseFloat(Number( currencyReverseFormat($(this).val(),2) ));
    });

    $('.totApproxPrice').val(total);   
}

