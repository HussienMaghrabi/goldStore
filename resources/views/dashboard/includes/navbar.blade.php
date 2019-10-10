@php
if(Route::currentRouteName() == 'home'){
  $lang_url = route('admin.home', App::getLocale() == 'ar' ? 'en' : 'ar');
}else {
    if (App::getLocale() == 'ar') {
      $lang_url = url( str_replace('ar/', 'en/', request()->path()) );
    }else{
      $lang_url = url( str_replace('en/', 'ar/', request()->path() ));
    }
}
@endphp
<header class="main-header">
  <!-- Logo -->
  <a href="{{ route('admin.home', App::getLocale() ) }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>{{ __('dashboard.APP_Name') }}</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>{{__('dashboard.APP_Name')}}</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu" style="{{App::getLocale() == 'ar' ? 'float:right' : ''}}">
          <a href="{{ route('admin.admins.edit', ['lang' => App::getLocale(), 'id' => Auth::guard('admin')->user()->id]) }}" class="dropdown-toggle" >
            <span class="hidden-xs">{{ Auth::guard('admin')->user()->name }}</span>
          </a>

        </li>
         <li>
          <a href="{{ $lang_url }}">
            <strong>
              {{ App::getLocale() == 'ar' ? 'En' : 'ع' }}
            </strong>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.logout', App::getLocale()) }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>
          </a>
          <form id="logout-form" action="{{ route('admin.logout', App::getLocale()) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ Auth::guard('admin')->user()->id }}">
          </form>
        </li>
      </ul>
    </div>
  </nav>
</header>
