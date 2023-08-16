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
    <h3>Edit Admin</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <x-paper>
        <h1></h1>
        <form id="form-edit">
            @csrf

            <div class="row mb-3">
                <div class="col-sm-6">

                    <x-select id="group" name="group"
                        label="Group" :options="$groupadmin_options"
                        value="{{ $admin->admin_groups_id }}" />

                    <x-input-text name="name" id="name" label="Full Name"
                        value="{{ $admin->fullname }}" type="text" />
                        
                    <x-input-text name="email" id="email" label="Email"
                        value="{{ $admin->email }}" type="text" />

                    <x-select id="status" name="status"
                        label="Status" :options="$is_active_options"
                        value="{{ $admin->is_active }}" />

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
            url:"{{route('admin_edit_patch', $admin->id)}}",
            type:"PATCH",
            data: $('#form-edit').serialize(),
            success:function(res) {
                // console.log(res);
                toastr['success']("Admin berhasil diedit");
                window.location.href = "{{route('admin_view_index')}}";
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
