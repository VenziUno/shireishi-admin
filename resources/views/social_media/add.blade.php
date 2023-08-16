<x-container>
    <h3>Tambah Media Sosial</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-add">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">

                    <x-input-text name="name" id="name" label="Name"
                    value="{{ old('name') }}" type="text" />

                    <x-input-text name="link" id="link" label="Link"
                    value="{{ old('link') }}" type="text" />
                    
                    <div class="form-group">
                        <label class="control-label" for="image">Logo</label>
                        <div class="input-group">
                            <button type="button" onclick="openUpload()"
                                class="btn btn-secondary btn-sm form-control mt-2"><i
                                    class="fas fa-image"></i>
                                Upload
                            </button>
                            <input type="file" name="image" id="image" onchange="uploadimage()" hidden accept="image/*">
                            <input type="hidden" name="logo" id="logo" >
                        </div>
                        <br>
                        <div id="uploadPhotoError"></div>
                        <br>
                        <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>

                        @error("logo")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>
                </div>

            </div>
            <x-button href="#" label="Tambah" type="btn btn-success" target="#" />
        </form>
    </x-paper>
</x-container>

<script>
    function openUpload() {
        $('#image').click();
    }

    function uploadimage() {
        var formData = new FormData(document.getElementById("form-add"));
        $('#uploadPhotoError').addClass('d-none');
        $.ajax({
            url: `/social-media/upload`,
            method: 'POST',
            data: formData,
            beforeSend:function(e){
                $('#overlay').css("display","block");
            },
            success: function(data) {
                var path = data.path;
                var strArray = path.split("/");
                $('#overlay').css("display","none");
                if(strArray[1].includes('jpg') || strArray[1].includes('jpeg') || strArray[1].includes('png') || strArray[1].includes('JPG') || strArray[1].includes('JPEG') || strArray[1].includes('PNG')){
                    $('#Video').remove();
                    $('#photoName').remove();
                    $(
                        '<img src="'+ data.link+'" id="photoName" style="width:300px;">' 
                    ).insertBefore('#uploadPhotoError');
                    $('#logo').val(data.path);
                }
                else{
                    $('#overlay').css("display","none");
                    $('#Video').remove();
                    $('#photoName').remove();
                    $(
                        '<h6 id="Video">File name :'+ data.namepath +'</h6>' 
                    ).insertBefore('#uploadPhotoError');
                    $('#logo').val(data.path);
                }

            },
            error: function(data) {
                $('#overlay').css("display","none");
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

    $('#form-add').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url:"{{route('social-media_add_post')}}",
            type:"POST",
            data: $('#form-add').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Media Sosial berhasil ditambahkan");
                window.location.href = "{{route('social-media_view_index')}}";
            },
            error:function(res) {
                if (res.status != 422)
                    toastr['error']("Something went wrong");
                showError(res.responseJSON.errors);
                $.each(res.responseJSON.errors, function(idx, item) {
                    toastr['error'](idx = item);
                });
            }
        });
        return false;
    })
</script>