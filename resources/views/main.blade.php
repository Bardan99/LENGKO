<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet" />
  <link href="assets/custom/css/general.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <title>@yield('title')</title>
</head>
<body>
  <header>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#head-navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"></span>
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
          </button>
          <a class="navbar-brand" href="/">LENGKO</a>
        </div>

        <div id="head-navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#">Beranda</a></li>
            <li><a href="#">Tentang Kami</a></li>
          </ul>
        </div>

      </div>
    </nav>
  </header>

  <div class="container">
    @yield('content')
  </div>

  <footer class="footer">
    <div class="footer-content">
      <div class="container">
        <div class="row">
          <div class="col-md-4 tb-padding-20">
            <div class="footer-brand">
              <h3>LENGKO</h3>
            </div>
            <hr class="content" />
            We break the limits!
          </div>
          <div class="col-md-4 tb-padding-20">
            <h3>Laman</h3>
            <hr class="content" />
            <ul class="li-unstyled">
              <li><a href="#">Beranda</a></li>
              <li><a href="#">Tentang Kami</a></li>
            </ul>
          </div>
          <div class="col-md-4 tb-padding-20">
            <h3>Kontributor</h3>
            <hr class="content" />
            <ul class="li-unstyled">
              <li>[10115253] <a href="https://github.com/Gurisa" target="_blank">Raka Suryaardi Widjaja</a></li>
              <li>[10115169] <a href="https://github.com/AzmiYudista" target="_blank">Azmi Yudista</a></li>
              <li>[10114200] <a href="https://github.com/gumilarfajardarajat" target="_blank">Gumilar Fajar Darajat</a></li>
              <li>[10114337] <a href="https://github.com/h4fif" target="_blank">Hafif Imammuddyn</a></li>
              <li>[10115143] <a href="https://github.com/binsarbernandus" target="_blank">Binsar Bernandus Silalahi</a></li>
              <li>[10114545] <a href="https://github.com/ridhaakmal" target="_blank">Ridha Akmal Putra</a></li>
            </ul>
          </div>
        </div>

      </div> <!-- container -->
    </div>

    <div class="footer-copyright">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <p class="text-center">
              Copyright &copy; LENGKO 2017 all right reserved<br />
              Developed with &#x2661; in Bandung by LENGKO Team
            </p>
          </div>
        </div>
      </div><!-- container -->
    </div>

  </footer>
  <script src="assets/jquery/jquery.js" type="text/javascript"></script>
  <script src="assets/bootstrap/js/bootstrap.js" type="text/javascript"></script>
</body>
</html>
