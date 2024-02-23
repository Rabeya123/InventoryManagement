@if ($type != 'hidden')
    <div class="form-group col-md-{{ $colsize }} row  @error($name) has-error @enderror ">
        <label class="col-sm-4 col-form-label">{{ $lebel }}@if($is_required==true) <span class="text-danger">*</span>@endif</label>
        <div class="col-sm-8">
            <input class="form-control" type="text" name="{{$name}}" value="{{ old($name, $value) }}" @if(isset($is_read_only) && $is_read_only) readonly @endif  @if(isset($is_required) && $is_required) required @endif  placeholder="Enter {{$lebel}}" >
            @error($name)
                <span class="help-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@else
    <input type="hidden" name="{{$name}}" value="{{ old($name, $value) }}"  @if(isset($is_required) && $is_required) required @endif >
@endif

