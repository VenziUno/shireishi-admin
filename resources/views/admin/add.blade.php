<?php
    $is_active_options = [['name' => 'Active', 'value' => 1], ['name' => 'Not Active', 'value' => 0]];

    if (count($group) > 0) {
        foreach ($group as $i) {
            $groupadmin_options[] = ['name' => $i->name, 'value' => $i->id];
        }
    }
    else{
        $groupadmin_options = [['name' => 'No Category in the list', 'value' => '']];
    }
?>

<x-container>
    <h3>Tambah Admin</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-add">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">

                    <x-select id="group" name="group"
                        label="Group" :options="$groupadmin_options"
                        value="{{ old('group') }}" />

                    <x-input-text name="name" id="name" label="Full Name"
                        value="{{ old('name') }}" type="text" />
                        
                    <x-input-text name="email" id="email" label="Email"
                        value="{{ old('email') }}" type="text" />

                    <x-input-text name="password" id="password" label="Password"
                        value="{{ old('password') }}" type="password" />

                    <x-select id="status" name="status"
                        label="Status" :options="$is_active_options"
                        value="{{ old('status') }}" />

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
            url:"{{route('admin_add_post')}}",
            type:"POST",
            data: $('#form-add').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Admin berhasil ditambahkan");
                window.location.href = "{{route('admin_view_index')}}";
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
