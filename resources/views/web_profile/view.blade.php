<x-action-bar>
    <x-action-bar-filter>
        <h1 class="h3 text-gray-800">{{ __('lang.' . Helper::changeRouteName()['name']) }}</h1>
    </x-action-bar-filter>

</x-action-bar>
<div id="data">
    <div class="px-3">
        <style>
            .name{
                pointer-events: none;
            }
        </style>
        <x-paper>
            <h1></h1>
            <form id="form-edit">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="content">About Us</label>
                            <textarea name="about" id="about" class="form-control" cols="30" rows="10">@if($web){!! $web->about_us !!} @endif</textarea>
                            @error("about")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="contact">Contact Us</label>
                            <input type="text" name="contact" id="contact" class="form-control" @if($web) value="{{ $web->contact_us }}" @endif>
                            
                            @error("contact")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="twitter">Embbeded Twitter</label>
                            <input type="text" name="twitter" id="twitter" class="form-control" @if($web) value="{{ $web->embedded_twitter }}" @endif>
                        </div>

                        {{--<div class="form-group">
                            <label for="content">Embbeded Twitter</label>
                            <textarea name="twitter" id="twitter" class="form-control" cols="30" rows="10">@if($web) {{ $web->embedded_twitter }} @endif</textarea>

                            @error("twitter")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>--}}
                    </div>
    
                </div>
                <x-button href="#" label="Edit" type="btn btn-success mt-3" target="#" />
            </form>
        </x-paper>
    </div>
</div>

<script>

    CKEDITOR.replace('about', {
        filebrowserUploadUrl: "{{route('web-profile_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    function uploadimage() {
        var formData = new FormData(document.getElementById("form-edit"));
        $('#uploadPhotoError').addClass('d-none');
        $.ajax({
            url: `/web-profile/upload`,
            method: 'POST',
            data: formData,
            success: function(data) {
                $('#photoName').remove();
                $(
                    '<img src="'+ data.link+'" id="photoName" style="width:300px;">' 
                ).insertBefore('#uploadPhotoError');
                $(
                    '<p>OK</p>' 
                ).insertBefore('#image');
                $('#image').val(data.path);
                $(
                    '<small class="form-text text-muted smalltext" id="photoName">' + truncate(data
                        .name, 23) + '</small>'
                ).insertBefore('#uploadPhotoError');
            },
            error: function(data) {
                var errors = data.responseJSON;
                if ($.isEmptyObject(errors) == false) {
                    $.each(errors.errors, function(key, value) {
                        var ErrorId = '#uploadPhotoError';
                        $(ErrorId).removeClass('d-none');
                        $(ErrorId).text(value)
                    })
                }
            },
            processData: false,
            contentType: false,
        })
    }

    $('#form-edit').submit(function(e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            url:"{{route('web-profile_add_post')}}",
            type:"POST",
            data: $('#form-edit').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Profile Successfully Edit");
                window.location.href = "{{route('web-profile_view_index')}}";
            },
            error:function(res) {
                if (res.status != 422)
                    toastr['error']("Something went wrong");
                showError(res.responseJSON.errors, "#form-edit");
                $.each(res.responseJSON.errors, function(idx, item) {
                    toastr['error'](idx = item);
                });
            }
        });
        return false;
    }) 
</script>


