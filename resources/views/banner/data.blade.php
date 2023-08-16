<x-table>
    <x-table-header>
        <x-table-row>
            <x-table-head>No</x-table-head>
            <x-table-head>Permainan</x-table-head>
            <x-table-head>Nama Banner</x-table-head>
            <x-table-head>Urutan</x-table-head>
            <x-table-head>Cover</x-table-head>
            <x-table-head>Link Tujuan</x-table-head>
            <x-table-head>Status</x-table-head>
            <x-table-head>
                <x-setting-column />
            </x-table-head>
        </x-table-row>
    </x-table-header>

    <x-table-body>
        @if (count($banner) == 0)
            <tr>
                <td colspan="7" class="text-center">No Data</td>
            </tr>
        @endif
        @foreach ($banner as $op => $i)
            <x-table-row>
                <x-table-td>{{ $op + $banner->firstitem() }}</x-table-td>
                <x-table-td>
                    @if($i->Game)
                        {{ $i->Game->name}}
                    @else
                        -
                    @endif
                </x-table-td>
                <x-table-td>{!! $i->title !!}</x-table-td>
                <x-table-td>{{ $i->order }}</x-table-td>
                <x-table-td>
                    @if(strpos($i->cover_image_path, 'jpg') == TRUE || strpos($i->cover_image_path, 'jpeg') == TRUE || strpos($i->cover_image_path, 'png') == TRUE || strpos($i->cover_image_path, 'JPG') == TRUE || strpos($i->cover_image_path, 'JPEG') == TRUE || strpos($i->cover_image_path, 'PNG') == TRUE)
                        <img src="{{\App\Helper\Helper::serveImage($i->cover_image_path)}}" style="width:100px">
                    @else
                        @php
                            $explode = explode('/', $i->cover_image_path);
                        @endphp
                        {{$explode[1]}}
                    @endif
                </x-table-td>
                <x-table-td>
                    @if($i->redirect_link)
                        {{ $i->redirect_link }}
                    @else
                        -
                    @endif
                </x-table-td>
                <x-table-td>
                    @if ($i->status == 1)
                        Aktif
                    @elseif($i->status == 0)
                        Tidak Aktif
                    @endif
                </x-table-td>
                <x-table-td>
                    @if ($i->status == 1)
                        <x-button-edit-table href="{{ route('banner_edit', $i->id) }}" />
                        <x-button-delete-table onclick="deleteData({{ $i->id }})" />
                        <button class="btn btn-sm btn-danger" type="button"
                            onclick="changeStatus({{ $i->id }}, 0)">Arsip</button> 
                    @else
                    <button class="btn btn-sm btn-warning" type="button"
                        onclick="changeStatus({{ $i->id }}, 1)">Aktif</button>
                    @endif
                </x-table-td>
            </x-table-row>
        @endforeach
    </x-table-body>
</x-table>
{{ $banner->links() }}
