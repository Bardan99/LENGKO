@extends('layouts.main')

@section('title', 'LENGKO - Galeri')

@section('content')

  <div class="row mrg-b-30">
    <div class="col-md-push-1 col-md-10 slider-for">
      @foreach ($data['gallery'] as $key => $value)
        <div class="slider-description">
          <div class="row">
            <div class="col-md-6">
              <a href="#!">
                <img src="{{ url('/files/images/gallery/') . '/' . $value->path }}" class="img-center" alt="" width="100%" height="100%">
              </a>
            </div>
            <div class="col-md-6">
              <h3>{{ $value->title }}</h3>
              <p>{{ $value->desc }}</p>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>

  <div class="row mrg-b-30">
    <div class="col-md-push-1 col-md-10 col-sm-12 col-xs-12">
      <div class="slider-nav">

        @foreach ($data['gallery'] as $key => $value)
        <div class="slider-item">
          <a href="#!">
            <img src="{{ url('/files/images/gallery/') . '/' . $value->path }}" alt="" width="250px" height="250px">
          </a>
        </div>
        @endforeach

      </div>
    </div>
  </div>

@endsection


@section('footer-section')
  @include('addition')
  @yield('footer-copyright')
@endsection
