<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col" width="40%">Menu</th>
            @foreach ($type as $i)
                <th scope="col" width="15%">{{ ucwords($i->name) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($menu as $m)
            <tr>
                <td class="text-center">{{ $m->name }}</td>
                @foreach ($type as $i)
                    <td>
                        <input class="toast-top-center" type="checkbox" name="menu_tipe[]"
                            value="{{ $m->id . '_' . $i->id }}" @foreach ($authorization as $j)  @if ($j->menus_id . '_' .
                            $j->authorization_types_id==$m->id . '_' . $i->id) 
                    checked @else @endif
                @endforeach >
                </td>
        @endforeach
        @endforeach
        </tr>
    </tbody>
</table>
