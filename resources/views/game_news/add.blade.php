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
    <h3>Tambah Berita Permainan</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-add">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">

                    <x-select id="category" name="category"
                        label="Kategori" :options="$group_options"
                        value="{{ old('category') }}" />

                    <x-select id="games_id" name="games_id"
                        label="Permainan" :options="$game_options"
                        value="{{ old('games_id') }}" />

                    <x-input-text name="title" id="title" label="Judul"
                        value="{{ old('title') }}" type="text" />
                        
                    <div class="form-group">
                        <label for="content">Deskripsi</label>
                        <textarea name="body" id="body" class="form-control" cols="30" rows="10"> {{ old('body') }} </textarea>

                        @error("body")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>

                </div>
                <div class="col-sm-6">
                    <x-select id="admin" name="admin"
                        label="Dibuat Oleh" :options="$admin_options"
                        value="{{ old('admin') }}" />

                    <div class="form-group">
                        <label class="control-label" for="image">Gambar</label>
                        <button type="button" onclick="openUpload()"
                            class="btn btn-secondary btn-sm form-control mt-2"><i
                                class="fas fa-image"></i>
                            Upload
                        </button>
                        <div class="input-group">
                            <input type="file" name="image" id="image" onchange="uploadimage()" hidden accept="video/*,image/*">
                            <input type="hidden" name="picture" id="picture" value="">
                        </div>
                        <br>
                        <div id="uploadPhotoError"></div>
                        <br>
                        <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>

                        @error("picture")
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

    CKEDITOR.replace('body', {
        filebrowserUploadUrl: "{{route('game-news_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    function openUpload() {
        $('#image').click();
    }

    function uploadimage() {
        var formData = new FormData(document.getElementById("form-add"));
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
    
    $('#form-add').submit(function(e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            url:"{{route('game-news_add_post')}}",
            type:"POST",
            data: $('#form-add').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Berita Permainan sudah berhasil ditambahkan");
                window.location.href = "{{route('game-news_view_index')}}";
            },
            error:function(res) {
                if (res.status != 422)
                    toastr['error']("Something went wrong");
                showError(res.responseJSON.errors, "#form-add");
                $.each(res.responseJSON.errors, function(idx, item) {
                    toastr['error'](idx = item);
                });
            }
        });
        return false;
    })
</script>
