@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                    <form action="" method="" id="commentForm">                        
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <h1 class="header-font1">Elevations</h1>
                                <p>Elevations are used for "Top Prices" section.</p>
                            </div>
                        </div>

                        {{-- @include('comments.include.forms.overallSaleForm') --}}
                        {{-- <div class="row">
                            <col class="col-md-6"></div>
                            <col class="col-md-6">
                                <a class="next-btn custom-btn-save float-right btn-top" href="/topPriceRegions/create">Create Mark</a>
                            </div>
                        </div> --}}
                      
                        <div class="comment-first-section mt-4">                            
                            <table class="dataListTable table" id="dataListTable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name</td>
                                        {{-- <td>Keyword</td> --}}
                                        <td>Action</td>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    @foreach ($regions as $key => $region)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$region->name}}</td>
                                            {{-- <td>{{$region->order}}</td> --}}
                                            <td>
                                                <a class="btn btn-sm btn-redirect" href="/topPriceRegions/update/{{ $region->id }}">Manage Mark</a>
                                                {{-- <a class="btn btn-sm btn-redirect" href="/delete_top_region/{{ $region->id }}"><i class="fa fa-trash"></i></a> <i class="fa fa-edit"></i>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection