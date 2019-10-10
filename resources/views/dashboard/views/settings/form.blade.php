
<div class="form-group">
    <label for="image" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Image')}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::file('image', array('id' => 'image', 'class'=>'form-control'))!!}
        <img src="{{ $item->image }}" width="100" height="100">
    </div>
</div>

<div class="form-group">
    <label for="about_ar" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.About_ar")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::textarea('about_ar', null, array('required', 'id' => 'about_ar', 'placeholder'=>__('dashboard.About_ar'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="about_en" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.About_en")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::textarea('about_en', null, array('required', 'id' => 'about_en', 'placeholder'=>__('dashboard.About_en'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="term_ar" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Term_ar")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::textarea('term_ar', null, array('required', 'id' => 'term_ar', 'placeholder'=>__('dashboard.Term_ar'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="term_en" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Term_en")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::textarea('term_en', null, array('required', 'id' => 'term_en', 'placeholder'=>__('dashboard.Term_en'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="free_ads" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.FreeAds")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('free_ads', null, array('required', 'id' => 'free_ad', 'placeholder'=>__('dashboard.FreeAds'), 'class'=>'form-control'))!!}
    </div>
</div>
