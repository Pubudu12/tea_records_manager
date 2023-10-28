<div class="mt-5 pt-5"></div>
{{-- @include('_PDF.Components.PageTitleComponent', ['title'=>'Highlights']) --}}

<div>
    <?php foreach ($auctionDescriptions['descriptions'] as $key => $singleDesc) {
        if ($singleDesc->type == 'HIGHLIGHT') {?>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="text-center highlights-box">
                    <h3><b>{{$singleDesc->description_title}}</b></h3>
                    <p>{{$singleDesc->description}}</p>
                </div>
            </div>
        <?php }
    }?>
        

    <div class="mt-5">
        <?php foreach ($auctionDescriptions['descriptions'] as $key => $singleDesc) {
            if ($singleDesc->type == 'DESCRIPTION') {?>
                <h2><b>{{$singleDesc->description_title}}</b></h2>
                <p><?php print_r($singleDesc->description)?> </p>
            <?php }
        }?>
    </div>
</div>