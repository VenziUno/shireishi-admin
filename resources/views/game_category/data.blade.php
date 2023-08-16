<x-table>
    <x-table-header>
        <x-table-row>
            <x-table-head>No</x-table-head>
            <x-table-head>Nama</x-table-head>
            <x-table-head>
                <x-setting-column />
            </x-table-head>
        </x-table-row>
    </x-table-header>

    <x-table-body>
        @if (count($category) == 0)
            <tr>
                <td colspan="8" class="text-center">No Data</td>
            </tr>
        @endif
        @foreach ($category as $op => $i)
            <x-table-row>
                <x-table-td>{{ $op + $category->firstitem() }}</x-table-td>
                <x-table-td>{{ $i->name }}</x-table-td>
                <x-table-td>
                    <x-button-edit-table href="{{ route('game-category_edit', $i->id) }}" />
                    @if(count($i->HasGame) > 0)
                        <x-button-delete-table onclick="deleteData({{ $i->id }})" />
                    @endif
                </x-table-td>
            </x-table-row>
        @endforeach
    </x-table-body>
</x-table>
{{ $category->links() }}
