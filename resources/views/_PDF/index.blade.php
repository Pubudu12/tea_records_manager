
<?php
define('URL_RESOLVER', $type);

function urlResolver($file){

    if(URL_RESOLVER == 'pdf'){
        return public_path($file);
    }else{
        return asset($file);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>

    <link rel="stylesheet" href="{{ urlResolver('assets/pdf/css/pdfMaster.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ urlResolver('assets/pdf/css/pdfGeneral.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ urlResolver('assets/pdf/css/pdfIndex.css') }}" type="text/css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ urlResolver('assets/pdf/css/pdfAuctionHighlights.css') }}" type="text/css">


<body class="bg-image">

    {{-- Welcome Page --}}
    {{-- @include('_PDF._general.welcome', ['saleNo' => '01', 'subText' => '22nd/23rd March']) --}}

    <footer>
        <p>Forbes & Walker Weekly Tea Market Report 22nd/23rd February 2022 </p>
    </footer>

    {{-- Index --}}
    @include('_PDF._general.indexPage')
    <div class="page-break"></div>

    <h1>Hello {{ $data['name'] }} <a href="#hellotest">sfasfs</a> </h1>
    <h2>Hello {{ $data['name'] }} - ---- -- -j </h2>
    <h3>Hello {{ $data['name'] }} Page </h3>

    <script type="text/php">
        if (isset($pdf)) {
            $x = 560;
            $y = 810;
            $text = "{PAGE_NUM}";
            $font = null;
            $size = 14;
            $color = array(214, 225, 238);
            $color = array(255, 0, 0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>


    <div class="page-break"></div>

    @include('_PDF.auctionHighlights.marketDash')


    @include('_PDF.include', ['some' => 'data'])


        {{-- <img id="url" src="{{urlResolver('/charts/charts.jpg')}}"  /> --}}

</body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>


</html>
