<div class="form-group">
  <label for="name" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Name")}}</label>
  <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
    {!!Form::text('name', null, array('required', 'id' => 'name', 'placeholder'=>__('dashboard.Name'), 'class'=>'form-control'))!!}
  </div>
</div>

<div class="form-group">
    <label for="desc" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Description")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('desc', null, array('required', 'id' => 'desc', 'placeholder'=>__('dashboard.Description'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="normal" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.normal")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::number('normal', null, array('required', 'id' => 'normal', 'placeholder'=>__('dashboard.normal'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="pinned" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.num_pinned")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::number('pinned', null, array('required', 'id' => 'pinned', 'placeholder'=>__('dashboard.num_pinned'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="video" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.video")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::number('video', null, array('required', 'id' => 'video', 'placeholder'=>__('dashboard.video'), 'class'=>'form-control'))!!}
    </div>
</div>

<div class="form-group">
    <label for="price" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.price")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::number('price', null, array('required', 'id' => 'price', 'placeholder'=>__('dashboard.price'), 'class'=>'form-control'))!!}
    </div>
</div>


