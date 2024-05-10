<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js"></script>

<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('assets/js/app.min.js')}}"></script>



<script>
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*ckeditor*/
     $('.editors').each(function(){
        CKEDITOR.replace($(this).attr('id'), {
            filebrowserUploadUrl: '{{ route('upload',['_token' => csrf_token() ]) }}',
            filebrowserUploadMethod: 'form'
        });
    });

    $('.select2').select2({
        placeholder: "Select Index"
    });


    $(".pagination .page-link").click(function(event){
        if($('#form_custom').length) {
            event.preventDefault();
            var link = $(this).attr('href');
            $("#form_custom").attr('action',link);
            $("#form_custom").submit();
        }

    })

});

/*Preview  multi or single image*/
var imagesPreview = function (input, placeToInsertImagePreview, single = true) {
    if (input.files) {
        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function (event) {
                if (single) {
                    $(placeToInsertImagePreview).empty();
                    $($.parseHTML('<img class="single-image">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                } else {
                    $($.parseHTML('<img class="single-image">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
            };
            reader.readAsDataURL(input.files[i]);
        }
    }

};



</script>

@yield('script-bottom')
