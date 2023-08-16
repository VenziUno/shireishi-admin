<x-container>
    <h3>Tambah Games</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-add">
            @csrf
                <h4><b><u>Detail Permainan</u></b></h4>
                <hr style="border: 1px black solid">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="content">Kategori Permainan</label>
                            <select class="js-example-basic-multiple form-control" name="category[]" id="category" multiple="multiple">
                                @foreach($category as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>

                            @error("category")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>
                        <x-input-text name="name" id="name" label="Nama Games"
                        value="{{ old('name') }}" type="text" />

                        <div class="form-group">
                            <label for="content">Deskripsi</label>
                            <textarea name="desc" id="desc" class="form-control" cols="30" rows="10"> {{ old('desc') }} </textarea>

                            @error("desc")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <label class="control-label" for="redirect_link">Link Tujuan</label>
                            <input type="text" name="redirect_link" id="redirect_link" class="form-control" value="{{ old('redirect_link') }}">
                            <small>Kosongkan jika tidak menginginkan banner memiliki link tujuan</small>
    
                            @error("redirect_link")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>
    
                        <x-input-text name="order" id="order" label="Urutan"
                            value="{{ $order }}" type="text" />
    
                        <div class="form-group">
                            <label class="control-label" for="color">Warna Latar Belakang</label>
                            <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}">
    
                            @error("color")
                            <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="image">Icon</label>
                            <button type="button" onclick="openUpload(1)"
                                class="btn btn-secondary btn-sm form-control mt-2"><i
                                    class="fas fa-image"></i>
                                Upload
                            </button>
                            <div class="input-group">
                                <input type="file" name="ico" id="ico" onchange="uploadimage(1)" hidden accept="image/*">
                                <input type="hidden" name="icon" id="icon" value="">
                            </div>
                            <br>
                            <div id="uploadIconPhotoError"></div>
                            <br>
                            <small>Maks. 20MB </small>

                            @error("icon")
                                <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="image">Gambar Sampul</label>
                            <button type="button" onclick="openUpload(2)"
                                class="btn btn-secondary btn-sm form-control mt-2"><i
                                    class="fas fa-image"></i>
                                Upload
                            </button>
                            <div class="input-group">
                                <input type="file" name="image" id="image" onchange="uploadimage(2)" hidden accept="image/*">
                                <input type="hidden" name="picture" id="picture" value="">
                            </div>
                            <br>
                            <div id="uploadPicturePhotoError"></div>
                            <br>
                            <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>

                            @error("picture")
                                <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="image">Gambar Latar Belakang</label>
                            <button type="button" onclick="openUpload(3)"
                                class="btn btn-secondary btn-sm form-control mt-2"><i
                                    class="fas fa-image"></i>
                                Upload
                            </button>
                            <div class="input-group">
                                <input type="file" name="web_image" id="web_image" onchange="uploadimage(3)" hidden accept="image/*">
                                <input type="hidden" name="web" id="web" value="">
                            </div>
                            <br>
                            <div id="uploadWebPhotoError"></div>
                            <br>
                            <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>

                            @error("web")
                                <div class="d-block invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr style="border: 1px black solid">
                <h4><b><u>Sub-Foto Permainan</u></b></h4>
                <hr style="border: 1px black solid">
                <div class="form-group">
                    <label class="control-label" for="image">Gambar Latar Belakang</label>
                    <button type="button" onclick="openUpload(4)"
                        class="btn btn-secondary btn-sm form-control mt-2"><i
                            class="fas fa-image"></i>
                        Upload
                    </button>
                    <div class="input-group">
                        <input type="file" name="sub_pho" id="sub_pho" onchange="uploadimage(4)" hidden accept="video/*,image/*"> 
                    </div>
                    <br>
                    <div class="photo-content row">

                    </div>
                    <div id="uploadSubPhotoError"></div>
                    <br>
                    <small>Rekomendasi Resolusi : 1440 x 642 px, Maks. 20MB </small>

                    @error("sub_photo")
                        <div class="d-block invalid-feedback">{{ $message }} </div>
                    @enderror
                </div>

                <hr style="border: 1px black solid">
                <h4><b><u>Link Download</u></b></h4>
                <hr style="border: 1px black solid">
                <div class="row">
                    <div class="col-sm-5">
                        <h4>Nama</h4>
                    </div>
                    <div class="col-sm-6">
                        <h4>Link</h4>
                    </div>
                    <div class="col-sm-1">
                        <a href="javascript:void(0)" onclick="addNewLinkDownload()" class="btn btn-sm btn-primary">+</a>
                    </div>
                </div>
                <div class="link-content">
                    <div class="content row mt-3">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="link_name[]" id="link_name[]">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="link[]" id="link[]">
                        </div>
                        <div class="col-sm-1">
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="removeRow">X</a>
                        </div>
                    </div>
                </div>

                <hr style="border: 1px black solid">
                <h4><b><u>Persyaratan Spesifikasi Permainan</u></b></h4>
                <hr style="border: 1px black solid">
                <div class="row">
                    <div class="col-sm-6">
                        <h4> Minimum Spesifikasi </h4>
                        <x-input-text name="min_os" id="min_os" label="OS"
                            value="{{ old('min_os') }}" type="text" />
                        <x-input-text name="min_processor" id="min_processor" label="Prosesor"
                            value="{{ old('min_processor') }}" type="text" />
                        <x-input-text name="min_memory" id="min_memory" label="Memori"
                            value="{{ old('min_memory') }}" type="text" />
                        <x-input-text name="min_graphics" id="min_graphics" label="Grafik"
                            value="{{ old('min_graphics') }}" type="text" />
                        <x-input-text name="min_storage" id="min_storage" label="Kapasitas"
                            value="{{ old('min_storage') }}" type="text" />
                    </div>
                    <div class="col-sm-6">
                        <h4> Rekomendasi Spesifikasi </h4>
                        <x-input-text name="rec_os" id="rec_os" label="OS"
                            value="{{ old('rec_os') }}" type="text" />
                        <x-input-text name="rec_processor" id="rec_processor" label="Prosesor"
                            value="{{ old('rec_processor') }}" type="text" />
                        <x-input-text name="rec_memory" id="rec_memory" label="Memori"
                            value="{{ old('rec_memory') }}" type="text" />
                        <x-input-text name="rec_graphics" id="rec_graphics" label="Grafik"
                            value="{{ old('rec_graphics') }}" type="text" />
                        <x-input-text name="rec_storage" id="rec_storage" label="Kapasitas"
                            value="{{ old('rec_storage') }}" type="text" />
                    </div>
                </div>
            <x-button href="#" label="Tambah" type="btn btn-success" target="#" />
        </form>
    </x-paper>
</x-container>

<script>
    CKEDITOR.replace('desc', {
        filebrowserUploadUrl: "{{route('game_add_upload_content', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    $(document).ready(function(e) {
        $('#category').select2();
    })

    function openUpload(type) {
        if(type == 1){
            $('#ico').click();
        }
        if(type == 2){
            $('#image').click();
        }
        if(type == 3){
            $('#web_image').click();
        }
        if(type == 4){
            $('#sub_pho').click();
        }
    }

    function addNewLinkDownload(){
        $(".link-content").append(`
            <div class="content row  mt-3">
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="link_name[]" id="link_name[]">
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="link[]" id="link[]">
                </div>
                <div class="col-sm-1">
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger text-white" id="removeRow">X</a>
                </div>
            </div>`);
    }

    $(document).on('click', '#removeRow', function () {
        $(this).closest('.content').remove();
    });

    function uploadimage(type) {
        var formData = new FormData(document.getElementById("form-add"));
        $('#uploadIconPhotoError').addClass('d-none');
        $('#uploadPicturePhotoError').addClass('d-none');
        $('#uploadWebPhotoError').addClass('d-none');
        $('#uploadSubPhotoError').addClass('d-none');
        $.ajax({
            url: `/game/upload/${type}`,
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
                        $('#VideoIcon').remove();
                        $('#photoNameIcon').remove();
                        $(
                            '<img src="'+ data.link+'" id="photoNameIcon" style="width:300px;">' 
                        ).insertBefore('#uploadIconPhotoError');
                        $('#icon').val(data.path);
                    }
                    else{
                        $('#VideoIcon').remove();
                        $('#photoNameIcon').remove();
                        $(
                            `   <video width="300px" controls id="VideoIcon">
                                    <source src="`+data.link+`" type="video/mp4">
                                    `+data.namepath+`
                                </video>`
                        ).insertBefore('#uploadIconPhotoError');
                        $('#icon').val(data.path);
                    }
                }
                if(type == 2){
                    if(strArray[1].includes('jpg') || strArray[1].includes('jpeg') || strArray[1].includes('png') || strArray[1].includes('JPG') || strArray[1].includes('JPEG') || strArray[1].includes('PNG')){
                        $('#VideoPicture').remove();
                        $('#photoNamePicture').remove();
                        $(
                            '<img src="'+ data.link+'" id="photoNamePicture" style="width:300px;">' 
                        ).insertBefore('#uploadPicturePhotoError');
                        $('#picture').val(data.path);
                    }
                    else{
                        $('#VideoPicture').remove();
                        $('#photoNamePicture').remove();
                        $(
                            `   <video width="300px" controls id="VideoPicture">
                                    <source src="`+data.link+`" type="video/mp4">
                                    `+data.namepath+`
                                </video>`
                        ).insertBefore('#uploadPicturePhotoError');
                        $('#picture').val(data.path);
                    }
                }
                if(type == 3){
                    if(strArray[1].includes('jpg') || strArray[1].includes('jpeg') || strArray[1].includes('png') || strArray[1].includes('JPG') || strArray[1].includes('JPEG') || strArray[1].includes('PNG')){
                        $('#VideoWeb').remove();
                        $('#photoNameWeb').remove();
                        $(
                            '<img src="'+ data.link+'" id="photoNameWeb" style="width:300px;">' 
                        ).insertBefore('#uploadWebPhotoError');
                        $('#web').val(data.path);
                    }
                    else{
                        $('#VideoWeb').remove();
                        $('#photoNameWeb').remove();
                        $(
                            `   <video width="300px" controls id="VideoWeb">
                                    <source src="`+data.link+`" type="video/mp4">
                                    `+data.namepath+`
                                </video>`
                        ).insertBefore('#uploadWebPhotoError');
                        $('#web').val(data.path);
                    }
                }
                if(type == 4){
                    if(strArray[1].includes('jpg') || strArray[1].includes('jpeg') || strArray[1].includes('png') || strArray[1].includes('JPG') || strArray[1].includes('JPEG') || strArray[1].includes('PNG')){
                        $(".photo-content").append(`
                            <div class="content mt-3 col-3 text-center d-flex align-items-center">
                                <input type="hidden" name="sub_photo[]" id="sub_photo[]" value="`+ data.path+`">
                                <img src="`+ data.link+`" style="width:300px;">
                                
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger text-white ml-2 d-flex align-items-center" id="removeRow">X</a>
                            </div>`);
                    }
                    else{
                        $(".photo-content").append(`
                            <div class="content mt-3 col-3 text-center d-flex align-items-center">
                                <input type="hidden" name="sub_photo[]" id="sub_photo[]" value="`+ data.path+`">
                                <video width="300px" controls>
                                    <source src="`+data.link+`" type="video/mp4">
                                    `+data.namepath+`
                                </video>
                                
                                <a href="javascript:void(0)" class="ml-2 btn btn-sm btn-danger text-white d-flex align-items-center" id="removeRow">X</a>
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

    $('#form-add').submit(function(e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            url:"{{route('game_add_post')}}",
            type:"POST",
            data: $('#form-add').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Games Berhasil ditambahkan");
                window.location.href = "{{route('game_view_index')}}";
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