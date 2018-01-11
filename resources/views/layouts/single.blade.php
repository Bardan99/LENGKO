<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="/assets/slick/slick.css" />
  <link rel="stylesheet" href="/assets/slick/slick-theme.css" />
  <link rel="stylesheet" href="/assets/custom/css/general.css" />
  <link rel="icon" type="image/x-icon" href="/files/images/lengko-favicon.png" />
  <title>@yield('title')</title>
</head>

<body>
  <div class="container-fluid wrapper">

    <div class="row min-height-100">
      <div class="col-md-12 min-padd-15">
        @yield('content')
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 padd-lr-0">
        @include('addition')
        <footer class="footer">
          @yield('footer-copyright')
        </footer>
      </div>
    </div>

  </div>
  @yield('lengko-loading')
  <script type="text/javascript" data-cfasync="false" src="/assets/jquery/jquery.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/slick/slick.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/general.js"></script>
</body>

</html>
