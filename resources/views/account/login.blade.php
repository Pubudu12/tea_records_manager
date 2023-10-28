<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicons/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Sign In - Forbes & Walker</title>

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <!-- font-family: 'Source Sans Pro', sans-serif; -->

    <!-- vendors css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/default/signin.css') }}">

    {{-- Toast --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"/>


  </head>
  <body class="text-center">

<main class="form-signin">
    <form
        id="loginForm"
        data-validate=true
        method="POST"
        action="/login">
        @csrf
    <img class="mb-4" src="{{ asset('assets/img/Logo_1.png') }}" alt="" width="auto" height="87">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
      <input type="email" class="form-control" name="email" placeholder="Email">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password"  placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <br><br>

    <a href="/dashboard" class="btn btn-outline-primary form-btn-next hidden" style="display: none" >NEXT</a>
    <button class="w-100 btn btn-lg btn-primary form-btn-submit" type="submit" data-submitAfter="next">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; {{ Date("Y") }}</p>
  </form>
</main>


<!-- vendor js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/vendors/popper.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/fontawesome.min.js" integrity="sha512-txsWtB+FOLDRFFsBL75QF7cPI4rqSjVH7Q+jKuaLrEI+uPPfvNfX66+pHF/4pU4pgQS3ptJ25xOvC8Erm+P+rA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Select2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Jquery Confirm -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('assets/js/form/confirmDialogBox.js') }}"></script>

{{-- Toast --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script src="{{ asset('assets/js/form/toast.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

{{-- loading --}}
<script src="{{ asset('assets/js/form/waitme/waitMe.min.js') }}"></script>
<script src="{{ asset('assets/js/form/waitme/waitMeCustom.js') }}"></script>

{{-- AJAX FORM --}}
<script src="{{ asset('assets/js/form/ajax.js') }}"></script>

{{-- Validation --}}
<script src="{{ asset('assets/js/validations/loginForm.js') }}"></script>



  </body>
</html>
