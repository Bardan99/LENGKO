@extends('main')

@section('title', 'LENGKO - Beranda')

@section('content')
  <div class="row mrg-btm-30">
    <div class="col-md-4 col-sm-6">
      <div class="menu">
        <img src="files/images//menus/img4-nasi-tutug-oncom-tasikmalaya.jpg" onclick="get_menu('menu-1')" alt="Nasi Tutug Oncom Bandung" width="100%" height="" />
        <h2 class="menu-title">Nasi Tutug Oncom Tasikmalaya</h2>
        <a href="#menu-1" onclick="get_menu('menu-1');" class="pull-right"><i class="material-icons">more_horiz</i></a>
        <br />
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="menu">
        <img src="files/images//menus/img1-lengko-cirebon.jpg" onclick="get_menu('menu-2')" alt="Nasi Lengko Cirebon" width="100%" height="" />
        <h2 class="menu-title">Nasi Lengko Cirebon</h2>
        <a href="#menu-2" onclick="get_menu('menu-2')" class="pull-right"><i class="material-icons">more_horiz</i></a>
        <br />
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="menu">
        <img src="files/images//menus/img2-rendang-padang.jpg" onclick="get_menu('menu-3')" alt="Nasi Lengko Cirebon" width="100%" height="" />
        <h2 class="menu-title">Rendang Padang</h2>
        <a href="#menu-3" onclick="get_menu('menu-3')" class="pull-right"><i class="material-icons">more_horiz</i></a>
        <br />
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="menu">
        <img src="files/images//menus/img3-gudeg-yogyakarta.jpg" onclick="get_menu('menu-4')" alt="Nasi Lengko Cirebon" width="100%" height="" />
        <h2 class="menu-title">Gudeg Yogyakarta</h2>
        <a href="#menu-4" onclick="get_menu('menu-4')" class="pull-right"><i class="material-icons">more_horiz</i></a>
        <br />
      </div>
    </div>
  </div>

  <div class="row mrg-btm-30">
    <div class="col-sm-12 col-md-push-4 col-md-4">
      <nav aria-label="Page navigation">
        <ul class="pagination pagination-lg obj-center">
          <li>
            <a href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li><a href="#">1</a></li>
          <li>
            <a href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
@endsection
