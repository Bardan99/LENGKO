@extends('layouts.main')

@section('title', 'LENGKO - Beranda')

@section('content')
  <div class="container">

    <div class="row mrg-b-30">
      <div class="col-md-push-2 col-md-8">
        <h4 id="brand-description" class="brand-description">
          Love of Beauty is taste <br>The creation of Beauty is Art <small>~Ralph W.E</small>
        </h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-red open-popover" onclick="go_to('menu');" data-placement="bottom" data-toggle="popover" data-content="Perut yang lapar akan keroncongan :'(">
          <div class="menu-icon">
            <i class="material-icons md-72">restaurant_menu</i>
            <br />
            <a href="{{ url('/menu') }}">Menu</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-orange" onclick="go_to('order');" data-placement="bottom" data-toggle="tooltip" title="Lihat dan pantau status pemesanan makanan dan minuman kamu secara interaktif (<i>realtime</i>).">
          <div class="menu-icon">
            <i class="material-icons md-72">shopping_cart</i>
            <br />
            <a href="{{ url('/order') }}">Pesanan</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-purple" onclick="call_waiter('DEVCODE');" data-placement="bottom" data-toggle="tooltip" title="Butuh bantuan? Kami siap membantu kamu untuk menyelesaikan pekerjaan rumah kamu; eh salah!">
          <div class="menu-icon">
            <i class="material-icons md-72">help_outline</i>
            <br />
            <a href="#!">Bantuan</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-blue" onclick="go_to('gallery');" data-placement="top" data-toggle="tooltip" title="Kenyamanan, fasilitas dan harga yang cocok dengan dompet kamu; kami yakin dan percaya bahwa kepuasan kamu adalah prioritas kami. Penasaran dengan restoran kami?">
          <div class="menu-icon">
            <i class="material-icons md-72">perm_media</i>
            <br />
            <a href="{{ url('/gallery') }}">Galeri</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-green" onclick="go_to('reviews');" data-placement="top" data-toggle="tooltip" title="Masih belum yakin mau <i>hangout</i> di sini? Yuk kita lihat apa kata mereka yang sudah pernah nyobain ke sini, penasaran kan?">
          <div class="menu-icon">
            <i class="material-icons md-72">insert_emoticon</i>
            <br />
            <a href="{{ url('/reviews') }}">Kata Mereka</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-black" onclick="go_to('about');" data-placement="top" data-toggle="tooltip" title="Pernah dengar meteor garden (F4)? <br />Oh tentu saja! Salah satu personilnya ada di sini loh!">
          <div class="menu-icon">
            <i class="material-icons md-72">people</i>
            <br />
            <a href="{{ url('/about') }}">Tentang Kami</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('footer-section')
  @include('addition')
  @yield('footer-copyright')
  @yield('shopping-cart')
@endsection
