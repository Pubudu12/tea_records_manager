@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateTeaMarketDesc">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h1 class="header-font1">Tea Markets Around The World</h1>
                                <small>Click on the <img src="{{ asset('assets/img/save.png') }}"> icon in the editor to save your data.</small>
                            </div>
                        </div>

                        <?php $count = 0;
                              $descCount = count($marketDescriptions);
                              $remain = 7 - $descCount;
                        ?>
                        @if (count($marketDescriptions) != 0)

                            <div class="crop-we-section">  
                                <div class="row details-add-row-mt">
                                    {{-- <div class="col-md-12">
                                        <button type="button" class="btn sm-add" onclick="addLink()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                    </div> --}}
                                </div>          
                                @foreach ($marketDescriptions as $singleDesc)
                                    <?php $count++;?>            
                                    <div class="row">
                                        <div class="col-md-12 link_section" id="link_section">
                                            <div class="add-link mb-40 pb-25" id="add-link">                                        
                                                <div class="comment-page-topic-section d-flex justify-content-between">
                                                    <input class="form-control col-md-8 input-text1 header-font1" name="title[]" value="{{$singleDesc->title}}" placeholder="Auction Name">
                                                    <div class="">
                                                        <p>If description is not available, toggle on this button</p>
                                                        <label class="toggle-two float-right">
                                                            <input type="checkbox" name="is_forbes[]" value="">
                                                            <span class="toggle-tw-slider round"></span>
                                                        </label>
                                                    </div>   
                                                </div>

                                                <textarea class="textarea_tinny_1" name="desc[]" placeholder="Hello, World!">{{$singleDesc->description}}</textarea>    
                                                    
                                                {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="deleteLink(this)"><i class="fa fa-trash"></i></button> --}}
                                            </div>
                                        </div>                            
                                    </div>    
                                @endforeach     
                                
                                @if (($descCount < 7) & ($remain != 0))
                                    @for ($i = 1; $i <= $remain; $i++)
                                        <div class="row">
                                            <div class="col-md-12 link_section" id="link_section">
                                                <div class="add-link mb-40 pb-25" id="add-link">                                        
                                                    <div class="comment-page-topic-section d-flex justify-content-between">
                                                        <input class="form-control col-md-8 input-text1 header-font1" name="title[]" value="" placeholder="Auction Name">
                                                        <div class="">
                                                            <p>If description is not available, toggle on this button</p>
                                                            <label class="toggle-two float-right">
                                                                <input type="checkbox" name="is_forbes[]" value="">
                                                                <span class="toggle-tw-slider round"></span>
                                                            </label>
                                                        </div>   
                                                    </div>

                                                    <textarea class="textarea_tinny_1" name="desc[]" placeholder="Hello, World!"></textarea>    
                                                        
                                                    {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="deleteLink(this)"><i class="fa fa-trash"></i></button> --}}
                                                </div>
                                            </div>                            
                                        </div> 
                                    @endfor    
                                @endif
                                
                            </div> 
                        @endif

                        <?php if ($count == 0) {?>
                            <?php //$name = 'Balgladesh Auction';?>
                            @for ($i = 1; $i <= 7; $i++)
                            {{-- @switch($i)
                                @case(1)
                                    <?php //$name = 'Balgladesh Auction';?>
                                    @break
                                @case(2)
                                    <?php //$name = 'Malawi Auction';?>
                                    @break
                                @case(3)
                                    <?php //$name = 'Kolkata Auction';?>
                                    @break
                                @case(4)
                                    <?php //$name = 'Guwahati Auction';?>
                                    @break
                                @case(5)
                                    <?php //$name = 'Jakarta / Cochin Auction';?>
                                    @break
                                @default
                                    <?php //$name = 'Auction Name';?> --}}
                                    
                            {{-- @endswitch --}}
                                <div class="crop-we-section">  
                                    <div class="row details-add-row-mt">
                                        {{-- <div class="col-md-12">
                                            <button type="button" class="btn sm-add" onclick="addLink()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                        </div> --}}
                                    </div>                      
                                    <div class="row">
                                        <div class="col-md-12 link_section" id="link_section">
                                            <div class="add-link mb-40 pb-25" id="add-link">                                        
                                                <div class="comment-page-topic-section d-flex justify-content-between">
                                                    <input class="form-control input-text1 header-font1" name="title[]" value="" placeholder="Auction Name">
                                                    {{-- <div class="">
                                                        <p>If description is not available, toggle on this button</p>
                                                        <label class="toggle-two float-right">
                                                            <input type="checkbox" name="check[]" value="" id="check_{{$i}}" onchange="changeText({{$i}})">
                                                            <span class="toggle-tw-slider round"></span>
                                                        </label>
                                                    </div>                                                    --}}
                                                </div>

                                                <textarea class="textarea_tinny_1" name="desc[]" id="desc_{{$i}}" placeholder="Hello, World!"></textarea> 
                                                {{-- <div id="desc_{{$i}}"></div> --}}
                                                    
                                                {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="deleteLink(this)"><i class="fa fa-trash"></i></button> --}}
                                            </div>
                                        </div>                            
                                    </div>                            
                                </div>
                            @endfor                            
                        <?php }?>

                        @include('_GeneralComponents.formBottomNextPrevOnly', ['previous'=>'/awaitingSales2', 'next'=> '/suppliments'])

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script>
          function changeText(desc_index) {
            tinymce.init({
                selector: '#desc_'+desc_index,
                inline: true
            });
            tinymce.activeEditor.setContent("<p>The above market report details were not available at the time of printing this publication.</p>");
            // for (let index = 1; index <= 7; index++) {
            //     alert(desc_index)
            //     if (document.getElementById('check_'+index).checked) {
            //         // alert('checked_ '+index)
            //         var textarea = document.getElementById('desc_'+index)
            //         // "The above market report details were not available at the time of printing this publication.";
                    
            //         // tinymce.get('#desc_'+index).setContent('bcduvtc6udstycd usgcydu gyu')
            //         tinymce.init({
            //             selector: '#desc_'+desc_index
            //         })

                    
            //         console.log(tinymce.activeEditor)
            //     } else {
            //         // alert('not checked = '+index)
            //         tinymce.activeEditor.setContent("<p>Hello World!</p>");
            //     }
            // }
        }
    </script>
@endsection


