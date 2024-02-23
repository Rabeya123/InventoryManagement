
<div class="form-group col-md-{{ $colsize }} row  @error($name) has-error @enderror">
    <label class="col-sm-4 col-form-label">{{ $lebel }}@if( isset($is_required) && $is_required == true)<span class="text-danger">*</span>@endif</label>
    <div class="col-sm-8 pt-2">
        <label class="ui-radio ui-radio-inline">
            <input type="radio" name="{{$name}}" @if($selected_value == 1) checked="true" @endif value="{{$values[0]}}">
            <span class="input-span"></span>{{$options[0]}}</label>
            <label class="ui-radio ui-radio-inline">
            <input type="radio" name="{{$name}}" @if($selected_value == 0) checked="true" @endif value="{{$values[1]}}">
            <span class="input-span"></span>{{$options[1]}}</label>
            @error($name)
                <span class="help-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </div>
</div>
