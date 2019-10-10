<div class="form-group">
  <label for="name_ar" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Name_ar")}}</label>
  <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
    {!!Form::text('name_ar', null, array('required', 'id' => 'name_ar', 'placeholder'=>__('dashboard.Name_ar'), 'class'=>'form-control'))!!}
  </div>
</div>

<div class="form-group">
    <label for="name_en" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Name_en")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('name_en', null, array('required', 'id' => 'name_en', 'placeholder'=>__('dashboard.Name_en'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="category_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Category")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::select('category_id', $categories, null, array('required', 'id' => 'Category_id', 'placeholder'=>__('dashboard.Category'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="image" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Image')}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::file('image', array('id' => 'image', 'multiple'=> 'multiple', 'class'=>'form-control', isset($item) ? '' : 'required'))!!}
    </div>
</div>

<div class="form-group">
    <label for="sort" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Sort")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::number('sort', null, array('required', 'id' => 'sort', 'placeholder'=>__('dashboard.Sort'), 'class'=>'form-control'))!!}
    </div>
</div>

{{--<div class="form-group">--}}
{{--<label for="desc_ar" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Description_ar")}}</label>--}}
{{--<div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">--}}
{{--{!!Form::textarea('desc_ar', null, array('required', 'id' => 'desc_ar', 'placeholder'=>__('dashboard.Description_ar'), 'class'=>'form-control'))!!}--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--<label for="desc_en" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Description_en")}}</label>--}}
{{--<div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">--}}
{{--{!!Form::textarea('desc_en', null, array('required', 'id' => 'desc_en', 'placeholder'=>__('dashboard.Description_en'), 'class'=>'form-control'))!!}--}}
{{--</div>--}}
{{--</div>--}}
