<?php
    $is_active_options = [['name' => 'Active', 'value' => 1], ['name' => 'Not Active', 'value' => 0]];

    if (count($category) > 0) {
        $group_options[] = ['name' => 'Pilih Kategori', 'value' => ''];
        foreach ($category as $i) {
            $group_options[] = ['name' => $i->name, 'value' => $i->id];
        }
    }
    else{
        $group_options = [['name' => 'Tidak Ada Kategori', 'value' => '']];
    }

    if (count($game) > 0) {
        $game_options[] = ['name' => 'Pilih Permainan', 'value' => ''];
        foreach ($game as $i) {
            $game_options[] = ['name' => $i->name, 'value' => $i->id];
        }
    }
    else{
        $game_options = [['name' => 'Tidak Ada Permainan', 'value' => '']];
    }

    if (count($admin) > 0) {
        $admin_options[] = ['name' => 'Pilih Admin', 'value' => ''];
        foreach ($admin as $i) {
            $admin_options[] = ['name' => $i->fullname, 'value' => $i->id];
        }
    }
    else{
        $admin_options = [['name' => 'Tidak Ada Admin', 'value' => '']];
    }
?>

<x-container>
    <h3>Edit Berita Permainan</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-edit">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">

                    <x-select id="category" name="category"
                        label="Kategori" :options="$group_options"
                        value="{{ $news->game_news_categories_id }}" />

                    <x-select id="games_id" name="games_id"
                        label="Permainan" :options="$game_options"
                        value="{{ $news->games_id }}" />

                    <x-input-text name="title" id="title" label="Judul"
                        value="{{ $news->title }}" type="text" />
                        
                    <div class="form-group">
                        <label for="content">Deskripsi</label>
                        <textarea name="body" id="body" class="form-control" cols="30" rows="10"> {!! $news->body !!} </textarea>

                        @error("body")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>

                </div>
                <div class="col-sm-6">
                    <x-select id="admin" name="admin"
                        label="Dibuat Oleh" :options="$admin_options"
                        value="{{$news->admins_id}}" />

                    <div class="form-group">
                        <label class="control-label" for="image">Gambar</label>
                        <button type="button" onclick="openUpload()"
                            class="btn btn-secondary btn-sm form-control mt-2"><i
                                class="fas fa-image"></i>
                            Upload
                        </button>
                        <div class="input-group">
                            <input type="file" name="image" id="image" onchange="uploadimage()" hidden accept="video/*,image/*">
                            <input type="hidden" name="picture" id="picture" value="{{$news->cover_image}}">
                        </div>
                        <br>
                        @if(strpos($news->cover_image, 'jpg') == TRUE || strpos($news->cover_image, 'jpeg') == TRUE || strpos($news->cover_image, 'png') == TRUE || strpos($news->cover_image, 'JPG') == TRUE || strpos($news->cover_image, 'JPEG') == TRUE || strpos($news->cover_image, 'PNG') == TRUE)
                            <img src="{{\App\Helper\Helper::serveImage($news->cover_image)}}" id="photoName" style="width:300px;">'
                        @else   
                           <video width="300px" controls id="Video">
                                <source src="{{\App\Helper\Helper::staticPath($news->cover_image)}}" type="video/mp4">
                            </video>
                        @endif
                        <div id="uploadPhotoError"></div>
                        <br>
                        <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>

                        @error("picture")
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

    CKEDITOR.replace('body', {
        filebrowserUploadUrl: "{{route('game-news_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    function openUpload() {
        $('#image').click();
    }

    function uploadimage() {
        var formData = new FormData(document.getElementById("form-edit"));
        $('#uploadPhotoError').addClass('d-none');
        $.ajax({
            url: `/game-news/upload`,
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
            url:"{{route('game-news_edit_patch', $news->id)}}",
            type:"PATCH",
            data: $('#form-edit').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Berita Permainan berhasil diedit");
                window.location.href = "{{route('game-news_view_index')}}";
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
