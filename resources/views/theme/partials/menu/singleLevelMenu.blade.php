
@if ($menu['category'] == "report")


    @if (Session::has('SelectedSaleCode'))

        <li class="divider"></li>

        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#menu-collapse_{{$key}}" aria-expanded="false">
                {{ $menu['name'] }}
            </button>
            <div class="collapse" id="menu-collapse_{{$key}}">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                @foreach ($menu['sub'] as $subMenus)

                    <li><a href="{{$subMenus['link']}}" id="{{$subMenus['activeID']}}" target="@if (isset($subMenus['target'])) {{$subMenus['target']}} @endif" class="link-dark rounded"> {{$subMenus['name']}} </a></li>

                @endforeach

                </ul>
            </div>
        </li>


    @endif


@else

    <li class="divider"></li>
    <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#menu-collapse_{{$key}}" aria-expanded="false">
            {{ $menu['name'] }}
        </button>
        <div class="collapse" id="menu-collapse_{{$key}}">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

            @foreach ($menu['sub'] as $subMenus)

                <li><a href="{{$subMenus['link']}}" id="{{$subMenus['activeID']}}" target="@if (isset($subMenus['target'])) {{$subMenus['target']}} @endif" class="link-dark rounded"> {{$subMenus['name']}} </a></li>

            @endforeach

            </ul>
        </div>
    </li>


@endif
