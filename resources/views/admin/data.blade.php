<x-table>
    <x-table-header>
        <x-table-row>
            <x-table-head>No</x-table-head>
            <x-table-head>Nama Lengkap</x-table-head>
            <x-table-head>Grup</x-table-head>
            <x-table-head>Email</x-table-head>
            <x-table-head>Status</x-table-head>
            <x-table-head>
                <x-setting-column />
            </x-table-head>
        </x-table-row>
    </x-table-header>

    <x-table-body>
        @if (count($admin) == 0)
            <tr>
                <td colspan="9" class="text-center">No Data</td>
            </tr>
        @endif
        @foreach ($admin as $op => $i)
            <x-table-row>
                <x-table-td>{{ $op + $admin->firstitem() }}</x-table-td>
                <x-table-td>{{ $i->fullname }}</x-table-td>
                <x-table-td>{{ $i->admingroup->name }}</x-table-td>
                <x-table-td>{{ $i->email }}</x-table-td>
                <x-table-td>
                    @if ($i->is_active == 1)
                        Aktif
                    @elseif($i->is_active == 0)
                        Tidak Aktif
                    @endif
                </x-table-td>
                <x-table-td>
                    {{--@if ($status == 1)

                        @if($i->is_active == 1)--}}
                            <x-button-edit-table href="{{ route('admin_edit', $i->id) }}" />
                            <a href="{{ route('admin_edit_pass', $i->id) }}" class="btn btn-sm btn-secondary">Change Password </a>
                            {{-- <button class="btn btn-sm btn-danger" type="button"
                                onclick="archiveData({{ $i->id }})">Archive</button> --}}
                            @if( Auth::user()->id != $i->id ) 
                                <x-button-delete-table onclick="deleteData({{ $i->id }})" />
                            @endif
                    {{--    @endif
                    @else
                        <button class="btn btn-sm btn-warning" type="button"
                            onclick="unarchiveData({{ $i->id }})">UnArchive</button>
                    @endif--}}
                </x-table-td>
            </x-table-row>
        @endforeach
    </x-table-body>
</x-table>
{{ $admin->links() }}
