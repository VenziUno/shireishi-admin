<x-table>
    <x-table-header>
        <x-table-row>
            <x-table-head>No</x-table-head>
            <x-table-head>Name</x-table-head>
            <x-table-head>Logo</x-table-head>
            <x-table-head>Link</x-table-head>
            <x-table-head>
                <x-setting-column />
            </x-table-head>
        </x-table-row>
    </x-table-header>

    <x-table-body>
        @if (count($media) == 0)
            <tr>
                <td colspan="5" class="text-center">No Data</td>
            </tr>
        @endif
        @foreach ($media as $op => $i)
            <x-table-row>
                <x-table-td>{{ $op + $media->firstitem() }}</x-table-td>
                <x-table-td>{{ $i->name }}</x-table-td>
                <x-table-td>                    
                    @if(strpos($i->logo, 'jpg') == TRUE || strpos($i->logo, 'jpeg') == TRUE || strpos($i->logo, 'png') == TRUE || strpos($i->logo, 'JPG') == TRUE || strpos($i->logo, 'JPEG') == TRUE || strpos($i->logo, 'PNG') == TRUE)
                        <img src="{{\App\Helper\Helper::serveImage($i->logo)}}" style="width:100px">
                    @else
                        @php
                            $explode = explode('/', $i->logo);
                        @endphp
                        {{$explode[1]}}
                    @endif
                </x-table-td>
                <x-table-td>{{ $i->link }}</x-table-td>
                <x-table-td>
                    <x-button-edit-table href="{{ route('social-media_edit', $i->id) }}" />
                    <x-button-delete-table onclick="deleteData({{ $i->id }})" />
                </x-table-td>
            </x-table-row>
        @endforeach
    </x-table-body>
</x-table>
{{ $media->links() }}
