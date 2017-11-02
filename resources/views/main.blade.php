<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/slick/slick.css" />
  <link rel="stylesheet" href="assets/slick/slick-theme.css" />
  <link rel="stylesheet" href="assets/custom/css/general.css" />
  <link rel="icon" type="image/x-icon" href="files/images/lengko-favicon.png" />
  <title>@yield('title')</title>
</head>

<body>
  <div class="container-fluid">

    <div class="row padd-b-30">
      <div id="navbar" class="col-md-2">
        <img class="img-center" src="files/images/logo.png" alt="" width="140px" height="80px" />
        <!-- <h1 class="brand-text">LENGKO</h1> -->
        <hr class="dashed" />
        <ul class="left-navbar">
          <li class="text-left">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;
            <a class="navbar-link" href="/">Home</a>
          </li>
          <li class="text-left">
            <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>&nbsp;
            <a class="navbar-link" href="/gallery/">Gallery</a>
          </li>
          <li class="text-left">
            <span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>&nbsp;
            <a class="navbar-link" href="/about/">About</a>
          </li>
        </ul>
      </div>
      <div id="content" class="col-md-10">
        @yield('content')
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 padd-lr-0">

        <footer class="footer">
          <div class="footer-content">
            <div class="container-fluid">

              <div class="row padd-tb-20 padd-lr-10">
                <div class="col-md-4">
                  <div class="footer-brand">
                    <h3>LENGKO</h3>
                  </div>
                  <hr class="content" /> Lokasi:
                  <br /> Jl. Sendirian Aja No. 99, Kav. Kapan Kawin, Bandung, Jawa Barat
                  <br />
                  <br /> Telepon: +(62)222 0000 2017
                  <br /> Fax: +(62)222 1111 2017
                </div>
                <div class="col-md-4">
                  <h3>Laman</h3>
                  <hr class="content" />
                  <ul class="li-unstyled">
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                  </ul>
                </div>
                <div class="col-md-4">
                  <h3>Kontributor</h3>
                  <hr class="content" />
                  <ul class="li-unstyled">
                    <li>
                      [10115253] Raka Suryaardi Widjaja
                      <a href="https://github.com/Gurisa" target="_blank">
                        <img src="files/images/github-fluidicon.png" alt="[G]" width="20px" height="20px" />
                      </a>
                      <a href="https://trello.com/rakasw" target="_blank">
                        <img src="files/images/trello-icon.png" alt="[T]" width="20px" height="20px" />
                      </a>
                    </li>
                    <li>
                      [10115169] Azmi Yudista
                      <a href="https://github.com/AzmiYudista" target="_blank">
                        <img src="files/images/github-fluidicon.png" alt="[G]" width="20px" height="20px" />
                      </a>
                      <a href="https://trello.com/azmiyudista" target="_blank">
                        <img src="files/images/trello-icon.png" alt="[T]" width="20px" height="20px" />
                      </a>
                    </li>
                    <li>
                      [10115143] Binsar Bernandus Silalahi
                      <a href="https://github.com/binsarbernandus" target="_blank">
                        <img src="files/images/github-fluidicon.png" alt="[G]" width="20px" height="20px" />
                      </a>
                      <a href="https://trello.com/binsarbernandus" target="_blank">
                        <img src="files/images/trello-icon.png" alt="[T]" width="20px" height="20px" />
                      </a>
                    </li>
                    <li>
                      [10115218] Raka Muhamad Pratama
                      <a href="https://github.com/raka1" target="_blank">
                        <img src="files/images/github-fluidicon.png" alt="[G]" width="20px" height="20px" />
                      </a>
                      <a href="https://trello.com/rakamuhamadpratama" target="_blank">
                        <img src="files/images/trello-icon.png" alt="[T]" width="20px" height="20px" />
                      </a>
                    </li>
                    <li>
                      [10115148] Muhammad Zaki
                      <a href="https://github.com/mhdzakii" target="_blank">
                        <img src="files/images/github-fluidicon.png" alt="[G]" width="20px" height="20px" />
                      </a>
                      <a href="https://trello.com/muhammadzaki2" target="_blank">
                        <img src="files/images/trello-icon.png" alt="[T]" width="20px" height="20px" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>

            </div>
            <!-- container -->
          </div>

          <div id="footer-copyright" class="footer-copyright">
            <div class="row">
              <div class="col-md-12">
                <p class="text-center">
                  <quote class="parisienne mrg-b-20">To be a winner all we need is to give all we have</quote>
                  <br />
                  <br /> Copyright &copy; LENGKO 2017 all right reserved
                  <br /> Developed with &#x2661; in Bandung by LENGKO Team
                </p>
              </div>
            </div>
          </div>
        </footer>

      </div>
    </div>

  </div>

  <script type="text/javascript" src="assets/jquery/jquery.js"></script>
  <script type="text/javascript" src="assets/custom/js/general.js"></script>
  <script type="text/javascript" src="assets/slick/slick.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</body>

</html>
