
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicons/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>Error - Unauthorized</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/general/style-new.css') }}">
</head>

<body class="error-bg">  

  <div class="container error-pt">

    <div class="row text-center">

          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="row">
              <div>
                <img style="width: 25%" src="{{ asset('assets/img/error/risk.png') }}"/>
              </div>
              <div class="d-flex justify-content-center flex-column align-items-center">
                <h1 class="error-h1">401</h1>
                
                <h5>{{$error['error']}}</h5>

                <a class="btn btn-secondary mt-2" href="/">Login Again</a>
              </div>
              {{-- <div class="col-md-1"></div>
              <div class="col-md-5">
                <div>
                  <img style="width: 100%" src="{{ asset('assets/img/error/risk.png') }}"/>
                </div>
              </div>
              <div class="col-md-5 d-flex justify-content-center flex-column align-items-center">
                <h1 class="error-h1">401</h1>
                
                <h6>{{$error['error']}}</h6>

                <a class="btn btn-secondary mt-1" href="/">Login Again</a>
              </div>
              <div class="col-md-1"></div> --}}
            </div>

          </div>
          <div class="col-md-2"></div>
    </div>
  </div>   

</body>

</html>