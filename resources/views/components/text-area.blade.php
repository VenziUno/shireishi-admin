
<div class="form-group">
    <label class="control-label" for="{{$id}}">{{$label}}</label>
    <textarea type="{{$type}}" name="{{$name}}" id="{{$id}}" class="form-control" value="{{$value}}">{{ $value }}</textarea>

    @error("$name")
    <div class="d-block invalid-feedback">{{ $message }} </div>
    @enderror
</div>