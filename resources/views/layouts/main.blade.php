<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="/assets/slick/slick.css" />
  <link rel="stylesheet" href="/assets/slick/slick-theme.css" />
  <link rel="stylesheet" href="/assets/stacktable/stacktable.css" />
  <link rel="stylesheet" href="/assets/jquerytoast/jquerytoast.css" />
  <link rel="stylesheet" href="/assets/custom/css/general.css" />
  <link rel="stylesheet" href="/assets/custom/css/rewrite.css" />
  <link rel="stylesheet" href="/assets/fontawesome/css/font-awesome.css">
  <link rel="stylesheet" href="/assets/jqueryrating/themes/fontawesome-stars.css">
  <link rel="icon" type="image/x-icon" href="/files/images/lengko-favicon.png" />
  <title>@yield('title')</title>
</head>

<body>

  <?php
    $menu = array(
      (object) array('title' => 'Beranda', 'link' => '/', 'icon' => 'home'),
      (object) array('title' => 'Menu', 'link' => '/menu', 'icon' => 'menu-hamburger'),
      (object) array('title' => 'Pesanan', 'link' => '/order', 'icon' => 'shopping-cart'),
      (object) array('title' => 'Bantuan', 'link' => '#!', 'icon' => 'user'),
      (object) array('title' => 'Galeri', 'link' => '/gallery', 'icon' => 'picture'),
      (object) array('title' => 'Apa Kata Mereka', 'link' => '/reviews', 'icon' => 'search'),
      (object) array('title' => 'Tentang Kami', 'link' => '/about', 'icon' => 'sunglasses')
    );
  ?>
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="/">
          <img class="navbar-brand" src="{{ url('/files/images/lengko-logo-white.png') }}" alt="LENGKO" width="180px" height="80px" />
        </a>
      </div>

      <div class="collapse navbar-collapse" id="main-navbar">
        <ul class="nav navbar-nav navbar-right">
          @foreach ($menu as $key => $value)
            @if ($value->link == '/' . $data['page'] && $value->link != '/order')
            <li @if ($value->link == '#!') {!! 'call_waiter(\' {{$device->kode_perangkat }}\');' !!} @endif class="@if ($value->link == '/'. $data['page']) {{ 'active'}} @endif">
              <a href="{{$value->link}}">
                <span class="glyphicon glyphicon-{{$value->icon}}" aria-hidden="true"></span>
                {{ $value->title }}
              </a>
            </li>
            @endif
          @endforeach
          <li class="@if ($data['page'] == 'order') {{ 'active'}} @endif">
            <a href="{{ url('order') }}">
              <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
              {{ count($order) }} Pesanan
            </a>
          </li>
          @if ($data['page'] != '')
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
              Navigasi <span class="caret" aria-hidden="true"></span>
            </a>
            <ul class="dropdown-menu">
              @foreach ($menu as $key => $value)
                @if ($value->link != '/' . $data['page'] && $value->link != '/order')
                <li @if ($value->link == '#!') onclick="call_waiter('{{$device->kode_perangkat }}');" @endif class="@if ($value->link == '/'. $data['page']) {{ 'active'}} @endif">
                  <a href="{{ url($value->link) }}">
                    <span class="glyphicon glyphicon-{{$value->icon}}" aria-hidden="true"></span>
                    {{ $value->title }}
                  </a>
                </li>
                @endif
              @endforeach
              <li id="logout-form" class="cursor-pointer"><a><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar Perangkat</a></li>
            </ul>
          </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>


  <div class="container-fluid padd-t-20vh">

    <div class="row mrg-b-20 min-height-80">
      <div class="col-md-12">
        @yield('content')
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 padd-lr-0">
        @include('addition')
        <footer class="footer">
          @yield('footer-section')
        </footer>
      </div>
    </div>

  </div>

  @yield('lengko-loading')
  @yield('lengko-logout')

  <script type="text/javascript" data-cfasync="false" src="/assets/jquery/jquery.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/sweetalert/sweetalert.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/slick/slick.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/typeit/typeit.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/stacktable/stacktable.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/jquerytoast/jquerytoast.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/jqueryrating/jquery.barrating.min.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/chartjs/chart-2.7.1.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/chart-data.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/general.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/customer.js"></script>
</body>

</html>
