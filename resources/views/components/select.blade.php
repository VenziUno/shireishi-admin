<div class="form-group">
    <label class="control-label" for="{{$id ?? ''}}}">{{$label ?? ''}}</label>
    <select name="{{$name}}" id="{{$id ?? ''}}" class="form-control">
        @foreach($options ?? [] as $row)
        <option value="{{$row['value']}}" @if ($row["value"]==$value) selected @endif>{{$row['name']}}</option>
        @endforeach
    </select>

    @error("$name")
    <div class="d-block invalid-feedback">{{ $message }} </div>
    @enderror
</div>