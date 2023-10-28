function duplicateForm() {
    //destroy the class
    // $("#link_type").select2('destroy');
    //cline happens here
    var clone = $("#add-link").clone().appendTo("#link_section");
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section');
    clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $('.select2').select2();
}



function addLink() {
    //destroy the class
    $("#link_type").select2('destroy');
    //cline happens here
    var clone = $("#add-link").clone().appendTo("#link_section");
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    // $('.select2').select2();
}


function addWeatherLink() {
    $(".js-example-basic-single").select2("destroy");

    var clone = $("#add-link").clone().appendTo("#link_section");
    var appendTo = $('#link_section');

    clone.find('input').val('');
    clone.find('textarea').val('');
    clone.appendTo(appendTo);

    $(".js-example-basic-single").select2();
}

function addDescriptionLink() {
    //destroy the class
    // $("#link_type").textarea_tinny_1('destroy');
    //cline happens here
    var clone = $("#add-link").clone().appendTo("#link_section");
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);

    // $("#options textarea.tinymce").each(function() {
    //     tinymce.execCommand("mceAddControl", false, $(this).attr("id"));
    // });
    // $('.select2').select2();
}

function addTableTdRow() {
    
    // trLick = document.getElementsByClassName("tr-link-section").removeClass('d-none');

    var clone = $('#region-tbody tr:last-child').clone();
    var appendTo = $('#region-tbody');

    clone.find('input').val('');

    let newRow = appendTo;
    clone.appendTo(newRow);
    // $("#region-tbody").select2();

}

function addLink3() {
    //destroy the class
    // $("#link_type").select2('destroy');
    //cline happens here
    var clone = $("#add-link").clone().appendTo("#link_section");
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section');
    clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $('.select2').select2();
}

function addLink1() {
    //destroy the class
    // $("#link_type").select2('destroy');
    //cline happens here
    var clone = $("#add-link1").clone().appendTo("#link_section1");
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section1');
    clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $('.select2').select2();
}

function addCatalogues() {
    //destroy the class
    // $("#link_type").select2('destroy');
    //cline happens here
    var clone = $("#addCatalogues").clone().appendTo("#addCataloguesSection");
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section1');
    clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $('.select2').select2();
}


function addTimeSlotLink1() {
    
    //destroy the class
    // $("#link_type").select2('destroy');
    //cline happens here
    var clone = $("#day_one_time_slots-1").clone().appendTo("#time_slot_outer1");
    // var clone = $('#time_slot_outer1 .add-link:last-child').clone();
    var appendTo = $('#time_slot_outer1');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $('.select2').select2();
}

function addTimeSlotLink2() {
    
    //destroy the class
    // $("#link_type").select2('destroy');
    //cline happens here
    var clone = $("#day_one_time_slots-2").clone().appendTo("#outer2-time_slot");
    // var clone = $('#outer2-time_slot .add-link:last-child').clone();
    var appendTo = $('#outer2-time_slot');
    
    clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    console.log(appendTo)
    $('.select2').select2();
}

function addWorldTeaProductRow1() {
    //destroy the class
    $(".js-example-basic-single").select2("destroy");
    //cline happens here
    var clone = $("#row-inner-1").clone().appendTo("#outer-tbody-1");
    // var clone = $('#outer-tbody-1 .row-inner-1:last-child').clone();
    var appendTo = $('#outer-tbody-1');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $(".js-example-basic-single").select2();
}

function addWorldTeaProductRow2() {
    //destroy the class
    $(".js-example-basic-single").select2("destroy");
    //cline happens here
    var clone = $("#row-inner-2").clone().appendTo("#outer-tbody-2");
    // var clone = $('#outer-tbody-1 .row-inner-1:last-child').clone();
    var appendTo = $('#outer-tbody-2');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $(".js-example-basic-single").select2();
}

function addWorldTeaProductRow3() {
    //destroy the class
    $(".js-example-basic-single").select2("destroy");
    //cline happens here
    var clone = $("#row-inner-3").clone().appendTo("#outer-tbody-3");
    // var clone = $('#outer-tbody-3 .row-inner-3:last-child').clone();
    var appendTo = $('#outer-tbody-3');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $(".js-example-basic-single").select2();
}

function addTopPriceMark() {
    //destroy the class
    // const element = document.getElementById("link_section")
    // let html = element.lastElementChild;
    // var numberOfRows = $('#link_section #add-link').length;
    // console.log(html)
    
    var clone = $("#add-link").clone().appendTo("#link_section");
    
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    // $('.select2').select2();
}

function addMajorImportRow() {
    //destroy the class
    $(".js-example-basic-single").select2("destroy");
    //cline happens here
    var clone = $("#row-inner").clone().appendTo("#outer-table");
    // var clone = $('#outer-table .row-inner:last-child').clone();
    var appendTo = $('#outer-table');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $(".js-example-basic-single").select2();
}

function addTopPriceDataRow(mainkey) {
    //clone happens here
    $(".js-example-basic-single").select2("destroy");
    var clone = $("#add-link_"+mainkey).clone().appendTo("#link_section_"+mainkey);
    
    var appendTo = $('#link_section_'+mainkey);
    
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $(".js-example-basic-single").select2();
    // console.log(e)
}

function addLink() {
    //destroy the class
    $("#link_type").select2('destroy');
    //cline happens here
    var clone = $("#add-link").clone().appendTo("#link_section");
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section');
    // clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    // $('.select2').select2();
}