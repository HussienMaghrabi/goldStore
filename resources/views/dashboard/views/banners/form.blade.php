@if(isset($item))
    <div class="form-group">
        <label for="image" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Image')}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::file('image', array('id' => 'image', 'class'=>'form-control'))!!}
        </div>
    </div>
@else
    <div class="form-group">
        <label for="images" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Images')}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::file('images[]', array('id' => 'images', 'class'=>'form-control', 'required', 'multiple'))!!}
        </div>
    </div>
@endif
