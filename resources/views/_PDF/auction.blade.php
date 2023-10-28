<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auction Highlights</title>
    
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/pdfMaster.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/pdfGeneral.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/pdfIndex.css') }}" type="text/css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/pdfAuctionHighlights.css') }}" type="text/css">

</head>
<body>

    <a class="{{$pdfButton}}" href="{{ URL::previous() }}">Back</a>

    <div style="font-size: 36px;font-weight: 600;margin-top:20px">Sale Number  :  <span>{{$currentSaleCode}}</span></div> 

    @include('_PDF.auctionHighlights.auctionMain')
</body>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.3/js/fontawesome.min.js"></script> --}}
</html>