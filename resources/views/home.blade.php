@extends('layouts.main')

@section('title', 'LENGKO - Beranda')

@section('content')
  <div class="container">

    <div class="row mrg-b-30">
      <div class="col-md-push-2 col-md-8">
        <h4 id="brand-description" class="brand-description">
          Selamat datang di LENGKO Resto's
          <br />
          Selamat berbelanja..
          <br />
          Eh kok mirip toko sebelah ya (>_<)
        </h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-red" onclick="go_to('menu');">
          <div class="menu-title">
            <a href="{{ url('/menu') }}">Menu</a>
            &nbsp; <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
          </div>
          <div class="menu-description">
            Beragam pilihan hidangan makanan dan minuman khas Indonesia kami sajikan
            secara profesional khusus hanya untuk anda.
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-orange" onclick="go_to('order');">
          <div class="menu-title">
            <a href="{{ url('/order') }}">Pesanan</a>
            &nbsp; <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
          </div>
          <div class="menu-description">
            Lihat dan pantau status pemesanan makanan dan minuman anda
            secara interaktif (<i>realtime</i>).
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-purple" onclick="call_waiter('DEVCODE');">
          <div class="menu-title">
            <a href="#!">Bantuan</a>
            &nbsp; <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
          </div>
          <div class="menu-description">
            Butuh bantuan? Kami siap membantu anda untuk menyelesaikan
            pekerjaan rumah anda; eh salah!
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-blue" onclick="go_to('gallery');">
          <div class="menu-title">
            <a href="{{ url('/gallery') }}">Galeri</a>
            &nbsp; <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
          </div>
          <div class="menu-description">
            Kenyamanan, fasilitas dan harga yang cocok dengan dompet anda;
            kami yakin dan percaya bahwa kepuasan anda adalah prioritas kami.
            Penasaran dengan restoran kami?
          </div>
        </div>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-green" onclick="go_to('reviews');">
          <div class="menu-title">
            <a href="{{ url('/reviews') }}">Apa Kata Mereka?</a>
            &nbsp; <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          </div>
          <div class="menu-description">
            Masih belum yakin mau <i>hangout</i> di sini? Yuk kita lihat apa
            kata mereka yang sudah pernah nyobain ke sini, penasaran kan?
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="main-menu menu-black" onclick="go_to('about');">
          <div class="menu-title">
            <a href="{{ url('/about') }}">Tentang Kami?</a>
            &nbsp; <span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>
          </div>
          <div class="menu-description">
            Pernah dengar meteor garden (F4)? <br />Oh tentu saja!
            Salah satu personilnya ada di sini loh! Iya di <a href="https://id.wikipedia.org/wiki/Meteor_Garden" target="_blank">sini</a>!
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
