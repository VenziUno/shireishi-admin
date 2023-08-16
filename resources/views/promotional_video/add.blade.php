<x-container>
    <h3>Tambah Video Promosi</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-add">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">

                    <x-input-text name="link" id="link" label="Link Video Promosi"
                        value="{{ old('link') }}" type="text" />
                </div>
            </div>
            <x-button href="#" label="Tambah" type="btn btn-success" target="#" />
        </form>
    </x-paper>
</x-container>

<script>

    $('#form-add').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url:"{{route('promotional-video_add_post')}}",
            type:"POST",
            data: $('#form-add').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Video Promosi sudah berhasil ditambahkan");
                window.location.href = "{{route('promotional-video_view_index')}}";
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
