<div class="col-12 mt-5">

    <div class="row">
        <div class="col-md-6">
            <a href="/dashboard" class="btn btn-outline-danger form-btn-exit"> EXIT </a>
            <a href="{{$previous}}" class="btn btn-outline-primary form-btn-pervious"> PREVIOUS </a>
        </div>

        <div class="col-md-6 d-flex justify-content-end">
            <a href="{{$next}}" class="btn btn-outline-primary form-btn-next"> NEXT </a>
            @if (isset($export))
                <a href="{{$export}}" class="btn btn-dark"> EXPORT </a>
            @endif
            <button class="btn btn-success form-btn-submit" data-submitAfter="save"> SAVE </button>
            <button class="btn btn-success form-btn-submit" data-submitAfter="next"> SAVE & NEXT </button>
        </div>
    </div>
</div> 