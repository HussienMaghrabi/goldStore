{{--<div class="form-group">--}}
    {{--<label for="image_status" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Images")}}</label>--}}
    {{--<div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">--}}
        {{--<select id="image_status" name="image_status" class="form-control">--}}
            {{--<option value="1"> {{__("dashboard.Admin image")}}</option>--}}
            {{--<option value="2"> {{__("dashboard.Vendor image")}}</option>--}}
        {{--</select>--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--<label for="price_status" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.price")}}</label>--}}
    {{--<div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">--}}
        {{--<select id="price_status" name="price_status" class="form-control">--}}
            {{--<option value="1"> {{__("dashboard.Admin Price")}}</option>--}}
            {{--<option value="2"> {{__("dashboard.Vendor Price")}}</option>--}}
        {{--</select>--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group">
    <label for="status" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Status")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        <select id="status" name="status" class="form-control">
            <option value="1"> {{__("dashboard.Not_Active")}}</option>
            <option value="2"> {{__("dashboard.Active")}}</option>
        </select>
    </div>
</div>