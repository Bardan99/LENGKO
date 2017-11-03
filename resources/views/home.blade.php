@extends('layouts.main')

@section('title', 'LENGKO - Beranda')

@section('content')

  @if (count($menus) > 1)
  <div class="row mrg-b-30">
    <div class="col-md-push-1 col-md-10 slider-for">
      @foreach ($menus as $key => $value)
      <div class="slider-description">
        <h3>{{ $value->nama_hidangan }}</h3>
        <p>{{ $value->deskripsi_hidangan }}</p>
      </div>
      @endforeach
    </div>

  </div>
  <div class="row mrg-b-30">
    <div class="col-md-push-1 col-md-10 col-xs-push-1 col-xs-10">
      <div class="slider-nav">
        @foreach ($menus as $key => $value)
        <div class="slider-item">
          <a href="/menu/">
            <img src="files/images/menus/{{ $value->gambar_hidangan }}" alt="" width="250px" height="250px">
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @else
    <div class="row mrg-b-30">
      <div class="col-md-push-1 col-md-10 col-xs-push-1 col-xs-10">

      </div>
    </div>
  @endif
@endsection
