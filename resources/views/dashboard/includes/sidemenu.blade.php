@php

    $items = [
          [
            'route' => 'admin.home',
            'icon'  => 'tachometer',
            'title' => __('dashboard.DASHBOARD')
          ],
          [
            'route' => 'admin.admins.index',
            'icon'  => 'user-secret',
            'title' => __('dashboard.ADMINS')
          ],
          [
            'route' => 'admin.users.index',
            'icon'  => 'users',
            'title' => __('dashboard.USERS')
          ],
          [
            'route' => 'admin.banners.index',
            'icon'  => 'buysellads',
            'title' => __('dashboard.BANNERS')
          ],
          [
            'route' => 'admin.categories.index',
            'icon'  => 'bookmark',
            'title' => __('dashboard.CATEGORIES')
          ],
          [
            'route' => 'admin.subcategories.index',
            'icon'  => 'bookmark',
            'title' => __('dashboard.SUBCATEGORIES')
          ],
          [
            'route' => 'admin.product.index',
            'icon'  => 'shopping-bag',
            'title' => __('dashboard.Ads')
          ],
          //[
            //'route' => 'admin.requestProducts.index',
            //'icon'  => 'check-square-o',
            //'title' => __('dashboard.PRODUCTS_VENDOR')
          //],
          [
            'route' => 'admin.complaints.index',
            'icon'  => 'comments',
            'title' => __('dashboard.COMPLAINTS')
          ],
          [
            'route' => 'admin.bouquets.index',
            'icon'  => 'shopping-cart',
            'title' => __('dashboard.BOUQUETS')
          ],
          [
            'route' => 'admin.notifications.index',
            'icon'  => 'rss',
            'title' => __('dashboard.NOTIFICATIONS')
          ],
          [
            'route' => 'admin.settings.index',
            'icon'  => 'cogs',
            'title' => __('dashboard.SETTINGS')
          ],


        ];

@endphp
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="height:100vh;overflow-y:scroll">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">

      @foreach ($items as $item)
        <li>
          <a href=" {{ $item['route'] == NULL ? '#' : route($item['route'], App::getLocale()) }} ">
            <i class="fa fa-{{$item['icon']}}"></i>
            <span>{{ $item['title'] }}</span>
          </a>
        </li>
      @endforeach

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
