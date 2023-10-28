
function ajaxDataTableLoad(idName, url, data){

    let tableIdName = idName;
    let $tableIdName = $("#"+tableIdName);

    // Destory If Build Already
    if ($.fn.DataTable.isDataTable('#'+tableIdName)) {
    
        $tableIdName.DataTable().destroy();

    }

    $(document).ready(function() {
        
        let postData = data;
        let actionUrl = url;

        $tableIdName.DataTable( {
                "pageLength": 50,
                "processing": true,
                "serverSide": true,
                "ajax":{
                        url : actionUrl,
                        data: postData,
                        type: "POST",  // method  , by default get
                        error: function(err){  // error handling
                            console.log(err);
                            $("."+tableIdName+"-error").html("");
                            $tableIdName.append('<tbody class="bill_list_table-error"><tr><th colspan="3">No Data Available </th></tr></tbody>');
                            $("#"+tableIdName+"_processing").css("display","none");
                        } // ERROR FUNCTION 
                } // ajax end
                
        });

        $("#sort").click();
        $("#sort").click();

    }); // document end

} // ajaxDataTableLoad
