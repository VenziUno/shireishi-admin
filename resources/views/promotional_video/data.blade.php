<x-table>
    <x-table-header>
        <x-table-row>
            <x-table-head>No</x-table-head>
            <x-table-head>Video</x-table-head>
            <x-table-head>
                <x-setting-column />
            </x-table-head>
        </x-table-row>
    </x-table-header>

    <x-table-body>
        @if (count($video) == 0)
            <tr>
                <td colspan="8" class="text-center">No Data</td>
            </tr>
        @endif
        @foreach ($video as $op => $i)
            <x-table-row>
                <x-table-td>{{ $op + $video->firstitem() }}</x-table-td>
                <x-table-td>{{ $i->link }}</x-table-td>
                <x-table-td>
                    <x-button-edit-table href="{{ route('promotional-video_edit', $i->id) }}" />
                    <x-button-delete-table onclick="deleteData({{ $i->id }})" />
                </x-table-td>
            </x-table-row>
        @endforeach
    </x-table-body>
</x-table>
{{ $video->links() }}
