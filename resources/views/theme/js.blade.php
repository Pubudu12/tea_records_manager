<!-- vendor js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/vendors/popper.min.js') }}"></script>


{{-- Select  --}}
<script src="{{ asset('assets/js/vendors/liquidmetal.js') }}"></script>
<script src="{{ asset('assets/js/vendors/jquery.flexselect.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/fontawesome.min.js" integrity="sha512-txsWtB+FOLDRFFsBL75QF7cPI4rqSjVH7Q+jKuaLrEI+uPPfvNfX66+pHF/4pU4pgQS3ptJ25xOvC8Erm+P+rA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Select2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Jquery Confirm -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('assets/js/form/confirmDialogBox.js') }}"></script>
<script src="{{ asset('assets/js/form/delete.js') }}"></script>

{{-- Toast --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script src="{{ asset('assets/js/form/toast.js') }}"></script>

{{-- loading --}}
<script src="{{ asset('assets/js/form/waitme/waitMe.min.js') }}"></script>
<script src="{{ asset('assets/js/form/waitme/waitMeCustom.js') }}"></script>

{{-- AJAX FORM --}}
<script src="{{ asset('assets/js/form/ajax.js') }}"></script>

{{-- sidebar-menu --}}
<script src="{{ asset('assets/js/general/sidebar-menu.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>


{{-- Data Tables --}}
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


{{-- TInyMCE --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/jquery.tinymce.min.js" integrity="sha512-0+DXihLxnogmlHWg1hVntlqMiGthwA02YWrzGnOi+yNyoD3IA4yDBzxvm+EwTCZeUM4zNy3deF9CbQqQBQx2Yg==" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/tiny/tiny.js') }}"></script>


<script src="{{ asset('assets/js/general/duplicateForm.js') }}"></script>
<!-- table row remve -->
<script src="{{ asset('assets/js/general/removeRow.js') }}"></script>


{{-- Main JS --}}
<script src="{{ asset('assets/js/general/main.js') }}"></script>


<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    jQuery(document).ready(function() {
        $("select.flexselect").flexselect();
    });
</script>