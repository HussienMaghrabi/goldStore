@if(App::getLocale() == 'ar')
  <footer class="main-footer">
    <strong>
      حقوق الملكية &copy; {{\Carbon\Carbon::now()->year}}
      <a>Gold Store</a>.
    </strong>
    جميع الحقوق محفوظة.
  </footer>
@else
  <footer class="main-footer">
    <strong>
      Copyright &copy; {{\Carbon\Carbon::now()->year}}
      <a>Gold Store</a>.
    </strong>
    All rights reserved.
  </footer>
@endif
