<div class="form-group">
    <label class="control-label" for="{{ $id }}">{{$label}}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" class="form-control" value="{{ $value }}">

    @error("$name")
    <div class="d-block invalid-feedback">{{ $message }} </div>
    @enderror
</div>