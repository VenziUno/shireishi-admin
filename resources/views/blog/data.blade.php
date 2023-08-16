<x-table>
    <x-table-header>
        <x-table-row>
            <x-table-head>No</x-table-head>
            <x-table-head>Kategori</x-table-head>
            <x-table-head>Gambar</x-table-head>
            <x-table-head>Judul</x-table-head>
            <x-table-head>Deskripsi</x-table-head>
            <x-table-head>HashTag</x-table-head>
            <x-table-head>Dibuat Oleh</x-table-head>
            <x-table-head>
                <x-setting-column />
            </x-table-head>
        </x-table-row>
    </x-table-header>

    <x-table-body>
        @if (count($blog) == 0)
            <tr>
                <td colspan="8" class="text-center">No Data</td>
            </tr>
        @endif
        @foreach ($blog as $op => $i)
            <x-table-row>
                <x-table-td>{{ $op + $blog->firstitem() }}</x-table-td>
                <x-table-td>{{ $i->Category->name }}</x-table-td>
                <x-table-td>
                    @if(strpos($i->cover_image, 'jpg') == TRUE || strpos($i->cover_image, 'jpeg') == TRUE || strpos($i->cover_image, 'png') == TRUE || strpos($i->cover_image, 'JPG') == TRUE || strpos($i->cover_image, 'JPEG') == TRUE || strpos($i->cover_image, 'PNG') == TRUE)
                        <img src="{{\App\Helper\Helper::serveImage($i->cover_image)}}" style="width:100px">
                    @else
                        @php
                            $explode = explode('/', $i->cover_image);
                        @endphp
                        {{$explode[1]}}
                    @endif
                </x-table-td>
                <x-table-td>{{ $i->title }}</x-table-td>
                <x-table-td>{!! $i->body !!}</x-table-td>
                <x-table-td>
                    <ul>
                        @foreach($i->HasHashtag as $h)
                            <li> {{$h->Hashtag->name}} </li>
                        @endforeach
                    <ul>
                </x-table-td>
                <x-table-td>{{ $i->Admin->fullname }}</x-table-td>
                <x-table-td>
                    <x-button-edit-table href="{{ route('blog_edit', $i->id) }}" />
                    <x-button-delete-table onclick="deleteData({{ $i->id }})" />
                </x-table-td>
            </x-table-row>
        @endforeach
    </x-table-body>
</x-table>
{{ $blog->links() }}
