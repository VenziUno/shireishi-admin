<x-container>
    <h3>Tambah Banner</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-add">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="content">Permainan</label>
                        <select class="form-control" name="game" id="game">
                            <option value="">Pilih Permainan</option>
                            @foreach($game as $g)
                                <option value="{{$g->id}}">{{$g->name}}</option>
                            @endforeach
                        </select>

                        @error("game")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Judul</label>
                        <textarea name="title" id="title" class="form-control" cols="30" rows="10"> </textarea>
                    </div>

                    <div class="form-group">
                        <label for="content">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                    </div>

                    <x-input-text name="order" id="order" label="Urutan"
                        value="{{ $order }}" type="text" />
                    
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="image">Gambar/Video</label>
                        <div class="input-group">
                            <button type="button" onclick="openUpload(1)"
                                class="btn btn-secondary btn-sm form-control mt-2"><i
                                    class="fas fa-image"></i>
                                Upload
                            </button>
                            <input type="file" name="image" id="image" onchange="uploadimage(1)" accept="video/*,image/*" hidden>
                            <input type="hidden" name="picture" id="picture">
                        </div>
                        <br>
                        <div id="uploadPhotoError"></div>
                        <br>
                        <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>
    
                        @error("picture")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="thumbnail">Thumbnail</label>
                        <div class="input-group">
                            <button type="button" onclick="openUpload(2)"
                                class="btn btn-secondary btn-sm form-control mt-2"><i
                                    class="fas fa-image"></i>
                                Upload
                            </button>
                            <input type="file" name="thumbnail" id="thumbnail" onchange="uploadimage(2)" accept="video/*,image/*" hidden>
                            <input type="hidden" name="thumbnail_link" id="thumbnail_link">
                        </div>
                        <br>
                        <div id="uploadThumbnailError"></div>
                        <br>
                        <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>
                        
                        @error("thumbnail")
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
    function openUpload(type) {
        if(type == 1){
            $('#image').click();
        }
        if(type == 2){
            $('#thumbnail').click();
        }
    }

    CKEDITOR.replace('title', {
        filebrowserUploadUrl: "{{route('banner_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    CKEDITOR.replace('description', {
        filebrowserUploadUrl: "{{route('banner_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    function uploadimage(type) {
        var formData = new FormData(document.getElementById("form-add"));
        $('#uploadThumbnailError').addClass('d-none');
        $('#uploadPhotoError').addClass('d-none');
        $.ajax({
            url: `/banner/upload/${type}`,
            method: 'POST',
            data: formData,
            beforeSend:function(e){
                $('#overlay').css("display","block");
            },
            success: function(data) {
                var path = data.path;
                var strArray = path.split("/");
                $('#overlay').css("display","none");
                if(type == 1){
                    if(strArray[1].includes('jpg') || strArray[1].includes('jpeg') || strArray[1].includes('png') || strArray[1].includes('JPG') || strArray[1].includes('JPEG') || strArray[1].includes('PNG')){
                        $('#Video').remove();
                        $('#photoName').remove();
                        $(
                            '<img src="'+ data.link+'" id="photoName" style="width:300px;">' 
                        ).insertBefore('#uploadPhotoError');
                        $('#picture').val(data.path);
                    }
                    else{
                        $('#overlay').css("display","none");
                        $('#Video').remove();
                        $('#photoName').remove();
                        $(
                            `   <video width="300px" controls id="Video">
                                    <source src="`+data.link+`" type="video/mp4">
                                </video>`
                        ).insertBefore('#uploadPhotoError');
                        $('#picture').val(data.path);
                    }
                }
                else{
                    if(strArray[1].includes('jpg') || strArray[1].includes('jpeg') || strArray[1].includes('png') || strArray[1].includes('JPG') || strArray[1].includes('JPEG') || strArray[1].includes('PNG')){
                        $('#thumbnail_Video').remove();
                        $('#thumbnail_photoName').remove();
                        $(
                            '<img src="'+ data.link+'" id="thumbnail_photoName" style="width:300px;">' 
                        ).insertBefore('#uploadThumbnailError');
                        $('#thumbnail_link').val(data.path);
                    }
                    else{
                        $('#overlay').css("display","none");
                        $('#thumbnail_Video').remove();
                        $('#thumbnail_photoName').remove();
                        $(
                            `   <video width="300px" controls id="thumbnail_Video">
                                    <source src="`+data.link+`" type="video/mp4">
                                </video>`
                        ).insertBefore('#uploadThumbnailError');
                        $('#thumbnail_link').val(data.path);
                    }
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
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            url:"{{route('banner_add_post')}}",
            type:"POST",
            data: $('#form-add').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Banner Berhasil ditambahkan");
                window.location.href = "{{route('banner_view_index')}}";
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