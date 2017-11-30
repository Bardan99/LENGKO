@extends('layouts.single')

@section('title', 'LENGKO - Halaman tidak ditemukan')

@section('content')
  <div class="row padd-tb-180">
    <div class="col-xs-12 col-sm-push-2 col-sm-8 col-md-push-4 col-md-4">
      <a href="/">
        <img class="img-center" src="{{ url ('/files/images/github-fluidicon.png') }}" alt="" width="120px" height="100px" />
      </a>
      <h1 class="text-center">
        Halaman tidak ditemukan
        <br />
        <small>Oops halaman tidak tersedia.</small>
      </h1>
      <br />
      <p class="text-center">
        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
        <a href="/">Kembali ke halaman utama</a>
      </p>
    </div>
  </div>
@endsection

@section('footer-copyright')

@endsection
