function fetchSeacrhDetails() {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    sale_no = $('#sale_no').val();
    year = $('#year').val();
    date = $('#date').val();
    

    $.ajax({
        type: 'GET',
        url: '/searchReport',
        data: {
            'sale_no':sale_no,
            'year':year,
            'date':date,
        },
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (ret) {
            console.log('success',ret);  
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}//fetchSeacrhDetails
