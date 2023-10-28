@extends('theme.partials.home')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">           
                    <div class="row">
                        <div class="col-md-12 mb-40">
                            <h1 class="header-font1">Create Mark</h1>
                        </div>
                    </div>

                    <form data-action-after=2 data-redirect-url="" method="POST"
                        action="/createTopPriceRegion">
                            @csrf
                        <div class="comment-first-section">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label for="">Mark Name</label>
                                    <input class="form-control input-text1" name="name" id="">

                                    <label class="mt-4" for="">Order</label>
                                    <input class="form-control input-text1" name="order" id="">

                                    <label class="mt-4" for="">Tea Grade</label>
                                    <select class="form-control" name="tea_grade" id="">
                                        <option value="0" disabled>Select Tea Grade</option>
                                        @foreach ($teagrades as $teaGrade)
                                            <option value="{{$teaGrade->id}}">{{$teaGrade->keyword}}</option>
                                        @endforeach
                                    </select>

                                    <div class="d-flex justify-content-between">
                                        <label class="check-container mt-4">
                                            <span class="sub-txt ml-3">Sub Category</span>
                                            <input type="checkbox" name="is_subcategory" onchange='handleChange(this);'>
                                            <span class="checkmark"></span>
                                        </label>    
    
                                        <div id="parent" class="d-none mt-4">
                                            <label class="" for="">Parent Category</label>
                                            <select name="parent_category" class="form-control">
                                                <option value="0" disabled>Select Parent Category</option>
                                                @foreach ($parentCategories as $parentCategory)
                                                    <option value="{{$parentCategory->id}}">{{$parentCategory->region_name}}</option>
                                                @endforeach
                                            </select> 
                                        </div>                                         
                                    </div> 

                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"></div>

                                <div class="col-md-6">
                                    <button class="reference_up_btn next-btn custom-btn-save btn-submit float-right"> SAVE </button>
                                </div>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script>
        function handleChange(checkbox) {            
            if(checkbox.checked == true){
                document.getElementById("parent").classList.remove("d-none");
            }else{
                document.getElementById("parent").classList.add("d-none");  
            }
        }
    </script>
@endsection