<x-container>
    <h3>Edit Banner</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-edit">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="content">Permainan</label>
                        <select class="form-control" name="game" id="game" value="{{$banner->games_id}}">
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
                        <textarea name="title" id="title" class="form-control" cols="30" rows="10">{!! $banner->title !!} </textarea>
                        
                        @error("title")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="10">{!! $banner->description !!} </textarea>
                        
                        @error("description")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>

                    <x-input-text name="order" id="order" label="Urutan"
                        value="{{ $banner->order }}" type="text" />

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
                            <input type="file" name="image" id="image" onchange="uploadimage(1)" hidden accept="video/*,image/*">
                            <input type="hidden" name="picture" id="picture" value="{{ $banner->cover_image_path }}" >
                        </div>
                        <br>
                        @php
                            $explode = explode('/', $banner->cover_image_path);
                        @endphp
                        @if(strpos($banner->cover_image_path, 'jpg') == TRUE || strpos($banner->cover_image_path, 'jpeg') == TRUE || strpos($banner->cover_image_path, 'png') == TRUE || strpos($banner->cover_image_path, 'JPG') == TRUE || strpos($banner->cover_image_path, 'JPEG') == TRUE || strpos($banner->cover_image_path, 'PNG') == TRUE)
                            <img src="{{\App\Helper\Helper::serveImage($banner->cover_image_path)}}" style="width:300px" id="photoName">
                        @else
                            <video width="300px" controls id="Video">
                                <source src="{{\App\Helper\Helper::staticPath($banner->cover_image_path)}}" type="video/mp4">
                            </video>
                        @endif
    
                        <div id="uploadPhotoError">
                        </div>
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
                            <input type="file" name="thumbnail" id="thumbnail" onchange="uploadimage(2)" hidden accept="video/*,image/*">
                            <input type="hidden" name="thumbnail_link" id="thumbnail_link" value="{{ $banner->thumbnail_image_path }}">
                        </div>
                        <br>
                        @php
                            $explode = explode('/', $banner->thumbnail_image_path);
                        @endphp
                        @if(strpos($banner->thumbnail_image_path, 'jpg') == TRUE || strpos($banner->thumbnail_image_path, 'jpeg') == TRUE || strpos($banner->thumbnail_image_path, 'png') == TRUE || strpos($banner->thumbnail_image_path, 'JPG') == TRUE || strpos($banner->thumbnail_image_path, 'JPEG') == TRUE || strpos($banner->thumbnail_image_path, 'PNG') == TRUE)
                            <img src="{{\App\Helper\Helper::serveImage($banner->thumbnail_image_path)}}" style="width:300px" id="thumbnail_photoName">
                        @else
                            <video width="300px" controls id="thumbnail_Video">
                                <source src="{{\App\Helper\Helper::staticPath($banner->thumbnail_image_path)}}" type="video/mp4">
                            </video>
                        @endif
    
                        <div id="uploadThumbnailError">
                        </div>
                        <br>
                        <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>
    
                        @error("thumbnail_link")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>
                </div>

            </div>
            <x-button href="#" label="Update" type="btn btn-success" target="#" />
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

    CKEDITOR.replace('description', {
        filebrowserUploadUrl: "{{route('banner_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    CKEDITOR.replace('title', {
        filebrowserUploadUrl: "{{route('banner_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    function uploadimage(type) {
        var formData = new FormData(document.getElementById("form-edit"));
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

    $('#form-edit').submit(function(e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            url:"{{route('banner_edit_patch', $banner->id)}}",
            type:"PATCH",
            data: $('#form-edit').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Banner Berhasil diedit");
                window.location.href = "{{route('banner_view_index')}}";
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
