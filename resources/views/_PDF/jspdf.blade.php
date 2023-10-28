<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>PDF</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        .chartJs{
            width: 300px;
            height: 200px;
        }
        </style>
</head>
<body>


      <canvas id="canvas" class="chartJs"></canvas>

        <img id="url" />

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    var lineChartData = {
                labels : ["January","February","March","April","May","June","July"],
                datasets : [
                    {
                        fillColor : "rgba(220, 20, 60,0.5)",
                        strokeColor : "rgba(220, 20, 60,1)",
                        pointColor : "rgba(220, 20, 60,1)",
                        pointStrokeColor : "#000",
                        data : [65,59,90,81,56,55,40],
                        bezierCurve : true,
                        borderColor: "#000",
                    }
                ]

            }

    function done(e){
        // console.log('e', e.chart);
        // alert("haha");
        var url=e.chart.toBase64Image();
        document.getElementById("url").src=url;


        $.ajax({
            type: 'POST',
            url: 'http://localhost:8000/saveImg',
            data: {'image_name': 'image_name', 'file': url},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('response', response)
            },
            error:function(error){
                console.error('error', error)
            }
    })


    }
    var options = {
        bezierCurve : false,
        animation: {
            onComplete: done
        }
    };


    var myLine = new Chart(document.getElementById("canvas").getContext("2d"),{
        data:lineChartData,
        type:"line",
        options:options
    });



  </script>


</html>
