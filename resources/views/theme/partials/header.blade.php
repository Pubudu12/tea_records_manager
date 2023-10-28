<div class="page-main-header">
    <div class="main-header-right row">
        <div class="main-header-left d-lg-none">
            <div class="logo-wrapper"><a href="/dashboard"><img class="" src="{{ asset('assets/img/Logo_1.png') }}" alt="logo"></a></div>
        </div>
        <div class="nav-right col">
            <ul class="nav-menus">

                    @if (Session::has('SelectedSaleCode'))

                        <?php
                            $value = session()->get('SelectedSaleCode');
                            if($value != NULL){
                                $pieces = str_split($value,4);
                                $no = str_split($pieces[1],1);
                            }
                        ?>

                        <li class="mt-2">
                            <div class="menu-slae-circle">
                                <h6>Sale No </h6>
                                <h4>{{$no[1].$no[2]}} </h4>
                                <p>{{$pieces[0]}}</p>
                            </div>
                        </li>

                    @endif

                <li>
                    <a class="logout" href="/logout">Logout </a><!--<i class="fa fa-sign-out-alt"></i>-->
                </li>


            </ul>
            <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
        </div>
    </div>
</div>
<!-- Page Header Ends -->
