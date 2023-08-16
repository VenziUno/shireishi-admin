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
    <h3>Edit Blog</h3>
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
                        value="{{ $blog->blog_categories_id }}" />

                    <x-input-text name="title" id="title" label="Judul"
                        value="{{ $blog->title }}" type="text" />
                        
                    <div class="form-group">
                        <label for="content">Deskripsi Singkat</label>
                        <textarea name="short_description" id="short_description" class="form-control" cols="30" rows="10"> {!! $blog->short_description !!} </textarea>

                        @error("short_description")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Deskripsi</label>
                        <textarea name="body" id="body" class="form-control" cols="30" rows="10"> {!! $blog->body !!} </textarea>

                        @error("body")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Hashtag</label>
                        <select class="js-example-basic-multiple form-control" name="hashtag[]" id="hashtag" multiple="multiple">
                            @foreach($hashtag as $h)
                                <option value="{{$h->id}}">{{$h->name}}</option>
                            @endforeach
                        </select>
                        @foreach($hashtag_array as $arr)
                            <input type="hidden" value="{{$arr}}" name="has[]">
                        @endforeach

                        @error("hashtag")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>

                </div>
                <div class="col-sm-6">
                    <x-select id="admin" name="admin"
                        label="Dibuat Oleh" :options="$admin_options"
                        value="{{$blog->admins_id}}" />

                    <div class="form-group">
                        <label class="control-label" for="image">Gambar</label>
                        <button type="button" onclick="openUpload(1)"
                            class="btn btn-secondary btn-sm form-control mt-2"><i
                                class="fas fa-image"></i>
                            Upload
                        </button>
                        <div class="input-group">
                            <input type="file" name="image" id="image" onchange="uploadimage(1)" hidden accept="video/*,image/*">
                            <input type="hidden" name="picture" id="picture" value="{{$blog->cover_image}}">
                        </div>
                        <br>
                        @if(strpos($blog->cover_image, 'jpg') == TRUE || strpos($blog->cover_image, 'jpeg') == TRUE || strpos($blog->cover_image, 'png') == TRUE || strpos($blog->cover_image, 'JPG') == TRUE || strpos($blog->cover_image, 'JPEG') == TRUE || strpos($blog->cover_image, 'PNG') == TRUE)
                            <img src="{{\App\Helper\Helper::serveImage($blog->cover_image)}}" id="photoName" style="width:300px;">'
                        @else   
                            <video width="300px" controls id="Video">
                                <source src="{{\App\Helper\Helper::staticPath($blog->cover_image)}}" type="video/mp4">
                            </video>
                        @endif
                        <div id="uploadPhotoError"></div>
                        <br>
                        <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>

                        @error("picture")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="image">Sub Gambar</label>
                        <button type="button" onclick="openUpload(2)"
                            class="btn btn-secondary btn-sm form-control mt-2"><i
                                class="fas fa-image"></i>
                            Upload
                        </button>
                        <div class="input-group">
                            <input type="file" name="sub-image" id="sub-image" onchange="uploadimage(2)" hidden accept="video/*,image/*">
                        </div>
                        <br>
                        <br>
                        <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>
                        <div class="photo-content">
                            @if(count($blog->Image) > 0)
                                @foreach($blog->Image as $img)
                                    <div class="col-12">
                                        <div class="content mt-3 text-center d-flex align-items-center row">
                                            <input type="hidden" name="sub_photo[]" id="sub_photo[]" value="{{$img->image_link}}">
                                            <div class="col-4 p-0">
                                                @if(strpos($img->image_link, 'jpg') == TRUE || strpos($img->image_link, 'jpeg') == TRUE || strpos($img->image_link, 'png') == TRUE || strpos($img->image_link, 'JPG') == TRUE || strpos($img->image_link, 'JPEG') == TRUE || strpos($img->image_link, 'PNG') == TRUE)
                                                    <img src="{{\App\Helper\Helper::serveImage($img->image_link)}}" style="width:200px;">
                                                @else   
                                                    <video width="200px" controls id="Video">
                                                        <source src="{{\App\Helper\Helper::staticPath($img->image_link)}}" type="video/mp4">
                                                    </video>
                                                @endif
                                            </div>
                                                    
                                            <div class="col-7 p-0">
                                                <input type="texr" class="form-control" name="caption[]" id="caption" value="{{$img->caption}}"/>
                                            </div>
                                            <div class="col-1 p-0">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger text-white ml-2 d-flex align-items-center w-75" id="removeRow">X</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @error("sub-image")
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

    $(document).ready(function(e) {
        var selectedValuesTest = [];            
        $('input[name^=has]').each(function(){
            selectedValuesTest.push($(this).val());
        });
        console.log(selectedValuesTest);
        $('#hashtag').select2();
        $('#hashtag').val(selectedValuesTest).trigger('change');
    })

    CKEDITOR.replace('short_description', {
        filebrowserUploadUrl: "{{route('blog_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    CKEDITOR.replace('body', {
        filebrowserUploadUrl: "{{route('blog_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    function openUpload(type) {
        if(type == 1){
            $('#image').click();
        }
        if(type == 2){
            $('#sub-image').click();
        }
    }

    $(document).on('click', '#removeRow', function () {
        $(this).closest('.content').remove();
    });

    function uploadimage(type) {
        var formData = new FormData(document.getElementById("form-edit"));
        $('#uploadPhotoError').addClass('d-none');
        $.ajax({
            url: `/blog/upload?type=${type}`,
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
                        $(".photo-content").append(`
                            <div class="col-12">
                                <div class="content mt-3 text-center d-flex align-items-center row">
                                    <div class="col-4 p-0">
                                        <input type="hidden" name="sub_photo[]" id="sub_photo[]" value="`+ data.path+`">
                                        <img src="`+ data.link+`" style="width:200px;">
                                    </div>
                                    
                                    <div class="col-7 p-0">
                                        <input type="texr" class="form-control" name="caption[]" id="caption" />
                                    </div>
                                    <div class="col-1 p-0">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger text-white ml-2 d-flex align-items-center w-75" id="removeRow">X</a>
                                    </div>
                                </div>
                            </div>`);
                    }
                    else{
                        $(".photo-content").append(`
                            <div class="col-12">
                                <div class="content mt-3 text-center d-flex align-items-center row">
                                    <div class="col-4 p-0">
                                        <input type="hidden" name="sub_photo[]" id="sub_photo[]" value="`+ data.path+`">
                                        <video width="200px" controls>
                                            <source src="`+data.link+`" type="video/mp4">
                                            `+data.namepath+`
                                        </video>
                                    </div>

                                    <div class="col-7 p-0">
                                        <input type="texr" class="form-control" name="caption[]" id="caption" />
                                    </div>
                                    <div class="col-1 p-0">
                                        <a href="javascript:void(0)" class="ml-2 btn btn-sm btn-danger text-white d-flex align-items-center w-75" id="removeRow">X</a>
                                    </div>
                                </div>
                            </div>`);
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
            url:"{{route('blog_edit_patch', $blog->id)}}",
            type:"PATCH",
            data: $('#form-edit').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Blog berhasil diedit");
                window.location.href = "{{route('blog_view_index')}}";
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
