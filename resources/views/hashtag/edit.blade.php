<x-container>
    <h3>Edit Hashtag</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-edit">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">

                    <x-input-text name="name" id="name" label="Nama Hashtag"
                        value="{{ $hashtag->name }}" type="text" />
                </div>
            </div>
            <x-button href="#" label="Update" type="btn btn-success" target="#" />
        </form>
    </x-paper>
</x-container>

<script>
    $('#form-edit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url:"{{route('hashtag_edit_patch', $hashtag->id)}}",
            type:"PATCH",
            data: $('#form-edit').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Hashtag berhasil diedit");
                window.location.href = "{{route('hashtag_view_index')}}";
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
