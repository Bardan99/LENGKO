<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="/assets/select2/css/select2.css" />
  <link rel="stylesheet" href="/assets/datepicker/dist/datepicker.css" />
  <link rel="stylesheet" href="/assets/custom/css/general.css" />
  <link rel="icon" type="image/x-icon" href="/files/images/lengko-favicon.png" />
  <title>@yield('title')</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row padd-b-30">
      <div id="navbar" class="col-md-2 mrg-b-20 padd-tb-20">
        @include('layouts.navbar')
      </div>
      <div id="content" class="col-md-10">
        @yield('content')
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 padd-lr-0">
        @include('addition')
        <footer class="footer">
          @yield('footer-quote')
        </footer>
      </div>
    </div>
  </div>

  <script type="text/javascript" data-cfasync="false" src="/assets/jquery/jquery.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/sweetalert/sweetalert.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/select2/js/select2.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/datepicker/dist/datepicker.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/chartjs/chart-2.7.1.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/chart-data.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/general.js"></script>
  <script type="text/javascript" data-cfasync="false" src="/assets/custom/js/dashboard.js"></script>
</body>

</html>
