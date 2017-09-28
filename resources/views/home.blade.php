@extends('main')

@section('title', 'LENGKO - Beranda')

@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="list-group">
        <a href="#" class="list-group-item active">
          <h4 class="list-group-item-heading">Menu</h4>
          <p class="list-group-item-text">Menu</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Services</h4>
          <p class="list-group-item-text">Pelayanan</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Contact</h4>
          <p class="list-group-item-text">Kontak</p>
        </a>
      </div>
    </div> <!-- end col -->

    <div class="col-md-8">
      <div id="current-product" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#current-product" data-slide-to="0" class="active"></li>
          <li data-target="#current-product" data-slide-to="1"></li>
          <li data-target="#current-product" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img src="/files/images/img1-lengko-cirebon.jpg" alt="" width="100%" height="250px">
            <div class="carousel-caption">
              <h3>Nasi Lengko Cirebon</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p>
            </div>
          </div>
          <div class="item">
            <img src="/files/images/img2-rendang-padang.jpg" alt="" width="100%" height="250px">
            <div class="carousel-caption">
              <h3>Rendang Padang</h3>
              <p> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
            </div>
          </div>
          <div class="item">
            <img src="/files/images/img3-gudeg-yogyakarta.jpg" alt="" width="100%" height="250px">
            <div class="carousel-caption">
              <h3>Gudeg Yogyakarta</h3>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
            </div>
          </div>

        </div>

        <a class="left carousel-control" href="#current-product" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">&previous;</span>
        </a>
        <a class="right carousel-control" href="#current-product" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">&next;</span>
        </a>
      </div><!-- end carousel -->
    </div><!-- end col -->
  </div><!-- end row -->

  <div class="row">
    <div class="col-md-12">
      <div class="seperator"></div>
    </div>
  </div>
@endsection
