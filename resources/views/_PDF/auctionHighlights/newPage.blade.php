<div class="mt-5"></div>
{{-- @include('_PDF.Components.PageTitleComponent', ['title'=>'Highlights']) --}}

<div>
    <div>
        <?php if ($auctionAddNewPageDetails['title'] != NULL) {?>
            <h2><b>{{$auctionAddNewPageDetails['title']}}</b></h2>
            <p><?php print_r($auctionAddNewPageDetails['content'])?></p>
        <?php }
        ?>
    </div>
</div>