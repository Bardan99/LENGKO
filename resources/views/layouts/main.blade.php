<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="/assets/slick/slick.css" />
  <link rel="stylesheet" href="/assets/slick/slick-theme.css" />
  <link rel="stylesheet" href="/assets/custom/css/general.css" />
  <link rel="icon" type="image/x-icon" href="/files/images/lengko-favicon.png" />
  <title>@yield('title')</title>
</head>

<body>
  <div class="container-fluid">

    <div class="row mrg-t-20">
      <div class="col-md-push-4 col-md-4">
        <a href="/">
          <img class="img-center" src="/files/images/logo.png" alt="LENGKO" width="180px" height="80px" />
        </a>
        <hr class="dashed" />
      </div>
    </div>

    <div class="row mrg-b-20">
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

  <script type="text/javascript" src="/assets/jquery/jquery.js"></script>
  <script type="text/javascript" src="/assets/custom/js/general.js"></script>
  <script type="text/javascript" src="/assets/custom/js/alert.js"></script>
  <script type="text/javascript" src="/assets/sweetalert/sweetalert.js"></script>
  <script type="text/javascript" src="/assets/slick/slick.js"></script>
  <script type="text/javascript" src="/assets/typeit/typeit.js"></script>
  <script type="text/javascript" src="/assets/bootstrap/js/bootstrap.js"></script>
</body>

</html>
