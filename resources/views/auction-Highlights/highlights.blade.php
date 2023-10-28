@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->

        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h1 class="header-font1">Auction Descriptions</h1>
                        </div>
                    </div>
                    <form id="reportForm1" data-action-after=2 data-validate=true method="POST" action="/manipulateAucSmallDescription">
                        @csrf
                            <div class="crop-we-section">

                                <?php $highlightAvailability = 0;?>                                
                                @foreach ($auctionDescriptions as $singleDesc)
                                    @if ($singleDesc->type == 'HIGHLIGHT')
                                        <?php $highlightAvailability = 1;?>
                                    
                                        <div class="row">
                                            <div class="col-md-12 comment-page-topic-section">
                                                <input class="form-control input-text1 header-font1" name="highlight_name" value="{{$singleDesc->description_title}}" placeholder="Highlights">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <textarea class="form-control" name="highlight_desc" placeholder="Hello, World!">{{$singleDesc->description}}</textarea>
                                            <small class="text-danger">Use not more than <b>60</b> words</small>     
                                        </div>                                            
                                    @endif
                                @endforeach
                                
                                @if ($highlightAvailability == 0)                                    
                                    <div class="row">
                                        <div class="col-md-12 comment-page-topic-section">
                                            <input class="form-control input-text1 header-font1" name="highlight_name" value="Highlights" placeholder="Highlights">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <textarea class="form-control" name="highlight_desc" placeholder="Hello, World!"></textarea>  
                                        <small class="text-danger">Use not more than <b>60</b> words</small>     
                                    </div>
                                @endif

                                @include('_GeneralComponents.formDefaultSubmitButton')
                            </div>
                    </form>

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateAucLongDescriptions">
                        @csrf
                        <?php $count = 0;?>
                        @if (count($auctionDescriptions) != 0)
                            <div class="crop-we-section">
                                <small>Click on the <img src="{{ asset('assets/img/save.png') }}"> icon in the editor to save your data.</small>

                                <div class="row details-add-row-mt">
                                    {{-- <div class="col-md-12">
                                        <button type="button" class="btn sm-add" onclick="addDescriptionLink()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                    </div> --}}
                                </div>
                                <?php $numberOfDescriptions = count($auctionDescriptions);?>
                                @foreach ($auctionDescriptions as $singleDesc)
                                    @if ($singleDesc->type == 'DESCRIPTION')
                                        <?php $count++;?>

                                        <div class="row" id="link_section">
                                            <div class="col-md-12 link_section">
                                                <div class="add-link mb-40 pb-25" id="add-link">
                                                    <div class="comment-page-topic-section">
                                                        <input class="form-control input-text1 header-font1" name="auction_desc_title[]" value="{{$singleDesc->description_title}}" placeholder="Title">
                                                    </div>
                                                    <textarea class="textarea_tinny_1" id="desc_test" name="auction_desc[]" placeholder="Hello, World!">{{$singleDesc->description}}</textarea>

                                                    {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="deleteLink(this)"><i class="fa fa-trash"></i></button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @if ($count == 1)
                                    <div class="row" id="link_section">
                                        <div class="col-md-12 link_section">
                                            <div class="add-link mb-40 pb-25" id="add-link">
                                                <div class="comment-page-topic-section">
                                                    <input class="form-control input-text1 header-font1" name="auction_desc_title[]" value="" placeholder="Title">
                                                </div>
                                                <textarea class="textarea_tinny_1" id="desc_test" name="auction_desc[]" placeholder="Hello, World!"></textarea>

                                                {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="deleteLink(this)"><i class="fa fa-trash"></i></button> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif


                        <?php if ($count == 0) {?>
                            <div class="crop-we-section">
                                <small>Click on the <img src="{{ asset('assets/img/save.png') }}"> icon in the editor to save your data.</small>

                                <div class="row details-add-row-mt">
                                    {{-- <div class="col-md-12">
                                        <button type="button" class="btn sm-add" onclick="addDescriptionLink()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                    </div> --}}
                                </div>
                                <div class="row" id="link_section">
                                    <div class="col-md-12 link_section">
                                        <div class="add-link mb-40 pb-25" id="add-link">
                                            <div class="comment-page-topic-section">
                                                <input class="form-control input-text1 header-font1" name="auction_desc_title[]" value="" placeholder="Title">
                                            </div>
                                            <textarea class="textarea_tinny_1" id="desc_test" name="auction_desc[]" placeholder="Hello, World!"></textarea>

                                            {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="deleteLink(this)"><i class="fa fa-trash"></i></button> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="link_section">
                                    <div class="col-md-12 link_section">
                                        <div class="add-link mb-40 pb-25" id="add-link">
                                            <div class="comment-page-topic-section">
                                                <input class="form-control input-text1 header-font1" name="auction_desc_title[]" value="" placeholder="Title">
                                            </div>
                                            <textarea class="textarea_tinny_1" id="desc_test" name="auction_desc[]" placeholder="Hello, World!"></textarea>

                                            {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="deleteLink(this)"><i class="fa fa-trash"></i></button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>

                        @include('_GeneralComponents.formBottomNextPrevOnly', ['previous'=>'/overall-market', 'next'=> '/order-of-sales'])
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection

@section('page-js')
    {{-- <script src="{{ asset('assets/js/validations/auction-highlights/descriptions.js') }}"></script> --}}
@endsection
