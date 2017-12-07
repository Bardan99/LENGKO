@extends('layouts.single')

@section('title', 'LENGKO - Layanan tidak tersedia')

@section('content')
  <div class="row padd-tb-180">
    <div class="col-xs-12 col-sm-push-2 col-sm-8 col-md-push-4 col-md-4">
      <a href="/">
        <img class="img-center" src="{{ url ('/files/images/github-fluidicon.png') }}" alt="" width="120px" height="100px" />
      </a>
      <h1 class="text-center">
        Layanan tidak tersedia
        <br />
        <small>
          Oops layanan yang anda minta tidak tersedia,<br />
          silahkan coba beberapa saat lagi.
        </small>
      </h1>
      <p class="text-center">
        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
        <a href="{{ url()->previous() }}">Kembali ke halaman sebelumnya</a>
      </p>
    </div>
  </div>
@endsection

@section('footer-copyright')

@endsection
