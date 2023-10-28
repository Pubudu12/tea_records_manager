function removeRow(input) {
    var numberOfRows = $('#link_section #add-link').length;
    if( Number(numberOfRows) > 1 ){
        $(input).parent().parent().remove();
    }
}

function removeRow1(input) {
    var numberOfRows = $('#link_section #add-link').length;
    if( Number(numberOfRows) > 1 ){
        $(input).parent().parent().remove();
    }
}

function removeCrop(input) {
    var numberOfRows = $('#link_section #add-link').length;
    if( Number(numberOfRows) > 1 ){
        $(input).parent().parent().remove();
    }
}

function deleteLink(input) {
    var numberOfRows = $('#link_section #add-link').length;
    if( Number(numberOfRows) > 1 ){
        $(input).parent().remove();
    }
}

function removeTimeSlots1(input) {
    console.log(input)
    var numberOfRows = $('#time_slot_outer1 #day_one_time_slots-1').length;
    if( Number(numberOfRows) > 1 ){
        $(input).parent().parent().remove();
    }
}

function removeTimeSlots_2(input) {
    alert('called')
    console.log(input)
    var numberOfRows = $('#outer2-time_slot #day_one_time_slots-2').length;
    if( Number(numberOfRows) > 1 ){
        $(input).parent().remove();
    }
}

function removeTableTdRow(input) {
    numberOfRows = $('table #link_section').length;

    if( Number(numberOfRows) > 1 ){
        $(input).closest("tr").remove();
    }    


    numberofLinks = $('table #select-link_section').length;

    if( Number(numberofLinks) > 1 ){
        $(input).closest("tr").remove();
    }   
    
}


function deleteWorldTeaProdRow1(input) {
    numberOfRows = $('#outer-tbody-1 #row-inner-1').length;

    if( Number(numberOfRows) > 1 ){
        $(input).closest("tr").remove();
    }    
}

function deleteWorldTeaProdRow2(input) {
    numberOfRows = $('#outer-tbody-2 #row-inner-2').length;

    if( Number(numberOfRows) > 1 ){
        $(input).closest("tr").remove();
    }    
  
}

function deleteWorldTeaProdRow3(input) {
    numberOfRows = $('#outer-tbody-3 #row-inner-3').length;

    if( Number(numberOfRows) > 1 ){
        $(input).closest("tr").remove();
    }    
  
}


function deleteMajorImportRow(input) {
    numberOfRows = $('#outer-table #row-inner').length;

    if( Number(numberOfRows) > 1 ){
        $(input).closest("tr").remove();
    }    
}

function deleteTopPriceDetail(input,mainKey) {
    
    outer = document.getElementById("link_section_"+mainKey);
    inner = document.getElementById("add-link_"+mainKey);

    console.log(outer)
    numberOfRows =(outer+inner).length;

    if( Number(numberOfRows) > 10 ){
        $(input).closest("tr").remove();
    }
}

