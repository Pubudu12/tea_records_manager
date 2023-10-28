  <!-- Page Sidebar Start-->
  <div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper"><a class="text-center" href="/dashboard"><img class="blur-up lazyloaded" src="{{ asset('assets/img/Logo_1.png') }}" alt="Forbes and Warlker"></a></div>
    </div>

    <div class="sidebar custom-scrollbar">
        @if (Session::has('userId'))
            <div>
                <h4 class="text-center"><b>{{session()->get('userName')}}</b></h4>
                <p class="text-center">({{session()->get('userRole')}})</p>
            </div>
        @endif

        <ul class="list-unstyled menu-main-list ps-0">

            @if (count($globalMenuArr) > 0)
                @foreach ($globalMenuArr as $key => $singleMainMenu)

                    @if (isset($singleMainMenu['sub']))
                        @include('theme.partials.menu.singleLevelMenu', ['key'=>$key, 'menu' => $singleMainMenu])
                    @else
                        @include('theme.partials.menu.singleMenu', ['menu'=>$singleMainMenu])
                    @endif
                @endforeach
            @endif
          </ul>

    </div>
</div>
