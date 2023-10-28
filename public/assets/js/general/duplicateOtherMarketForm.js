function duplicatetherMarketSectionForm() {
    //destroy the class
    // $("#link_type").select2('destroy'); 
    //cline happens here
    var clone = $("#add-link").clone().appendTo("#otherMarketSection");
    // var clone = $('#link_section .add-link:last-child').clone();
    var appendTo = $('#link_section');
    clone.find('#link_type :selected').text('');
    clone.find('input').val('');
    clone.appendTo(appendTo);
    $('.select2').select2();
}