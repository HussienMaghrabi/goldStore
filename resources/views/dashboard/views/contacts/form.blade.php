
<div class="form-group">
    <label for="name" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Name')}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('name', NULL, array('id' => 'name', 'placeholder' => __('dashboard.Name'), 'class'=>'form-control', 'readonly'))!!}
    </div>
</div>

<div class="form-group">
    <label for="content" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Content')}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('content', NULL, array('id' => 'content', 'placeholder' => __('dashboard.Content'),'class'=>'form-control', 'required'))!!}
    </div>
</div>

{{--<div class="form-group">--}}
    {{--<label for="image" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Image')}}</label>--}}
    {{--<div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">--}}
        {{--{!!Form::file('image', array('id' => 'image', 'class'=>'form-control', isset($item) ? '' : 'required'))!!}--}}
    {{--</div>--}}
{{--</div>--}}
