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
                                <h1 class="header-font1">Tea Grades</h1>
                            </div>
                        </div>

                        <div class="row">
                            <col class="col-md-6"></div>
                            <col class="col-md-6">
                                <a class="next-btn custom-btn-save float-right btn-top" href="/tea-grades/create">Create Tea Grade</a>
                            </div>
                        </div>
                      
                        <div class="comment-first-section mt-4">                            
                            <table class="dataListTable table" id="dataListTable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name</td>
                                        <td>Keyword</td>
                                        <td>Action</td>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    @foreach ($teaGrades as $key => $grade)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$grade->name}}</td>
                                            <td>{{$grade->keyword}}</td>
                                            <td>
                                                <a class="btn btn-sm btn-redirect" href="/tea-grades/update/{{ $grade->id }}"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-sm btn-redirect" href="/delete_tea-grade/{{ $grade->id }}"><i class="fa fa-trash"></i></a>
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