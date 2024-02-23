@if ($type !='hidden')

<div class="form-group col-{{ $colsize }} row  @error($name) has-error @enderror ">
    <label class="col-sm-4 col-form-label">{{ $lebel }}</label>
    <div class="col-sm-8">
        <input class="form-control date" type="text" name="{{$name}}" value="{{ old($name,Carbon\Carbon::parse($value)->format('m/d/Y')) }}" placeholder="Enter {{$lebel}}">
        @error('$name')
        <span class="help-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

    </div>
</div>

@else
    <input type="hidden" name="{{$name}}" value="{{ old($name, $value) }}" @if(isset($is_required) && $is_required) required @endif>
@endif 


