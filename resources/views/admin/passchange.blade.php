<x-container>
    <h3>Ubah Password</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-pass">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">

                    <x-input-text name="password" id="password" label="Password"
                            value="{{ old('password') }}" type="password" />

                </div>
            </div>
            <x-button href="#" label="Edit" type="btn btn-success" target="#" />
        </form>
    </x-paper>
</x-container>

<script>
    $('#form-pass').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url:"{{route('admin_edit_pass', $admin->id)}}",
            type:"PATCH",
            data: $('#form-pass').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Password berhasil diubah");
                window.location.href = "{{route('admin_view_index')}}";
            },
            error:function(res) {
                if (res.status != 422)
                    toastr['error']("Something went wrong");
                showError(res.responseJSON.errors, "#form-pass");
                $.each(res.responseJSON.errors, function(idx, item) {
                    toastr['error'](idx = item);
                });
            }
        });
        return false;
    })
</script>