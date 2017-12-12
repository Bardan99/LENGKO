@extends('layouts.main')

@section('title', 'LENGKO - Menu')

@section('content')

  <div class="container-fluid">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if (count($data['menu']) > 0)
    <div class="row mrg-b-30">
      <div class="col-md-3 mrg-t-20">

      </div>
      <div class="col-md-6 mrg-t-20">
        <div class="input-group">
          <input type="text" name="menu-search-query" class="form-control input-lengko-default block" placeholder="Cari menu.." style="height:45px;" />
          <span class="input-group-btn">
            <button type="button" name="menu-search-button" class="btn btn-default pull-right" style="height:45px;">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </button>
          </span>
        </div>
      </div>
      <div class="col-md-3 mrg-t-20">
        <select name="menu-search-type" class="select-lengko-default block">
          <option value="A">Semua Menu</option>
          <option value="F">Makanan</option>
          <option value="D">Minuman</option>
        </select>
      </div>
    </div>
    <div id="menu-card-section" class="row">
      @foreach ($data['menu'] as $keymenu => $value)

        @php ($res = false)
        @php ($i = 0)
        @foreach ($data[$keymenu]['menu-status'] as $key2 => $value2)
          @php ($i++)
          @if ($value2->stok_bahan_baku > 0)
            @php ($res = true)
          @else
            @php ($res = false)
            @break
          @endif
        @endforeach
        @if ($i == count($data[$keymenu]['menu-status']))
          @if ($res)
            @php ($status = 'Tersedia')
          @else
            @php ($status = 'Tidak tersedia')
          @endif
        @else
          @php ($status = 'Tidak tersedia')
        @endif

        <div class="col-md-4 col-sm-6" onclick="show_obj('menu-{{$value->kode_menu}}');">
          <div class="menu">
            <img src="/files/images/menus/@if($value->gambar_menu){{$value->gambar_menu}}@else{{'not-available.png'}}@endif" alt="{{ $value->nama_menu }}" width="100%" height="150px" />
            <h2 class="menu-title">{{ $value->nama_menu }} <small>({{$status}})</small></h2>
            {{ $data['menu_obj']->num_to_rp($value->harga_menu) }}
            <a href="#!" class="pull-right"><i class="material-icons">add_shopping_cart</i></a>
            <br />
          </div>
        </div>


        <div id="menu-{{$value->kode_menu}}" class="menu-overlay">
          <div class="row menu-overlay-content">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-offset-11 col-md-1" style="font-size:20pt;">
                  <span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj('menu-{{$value->kode_menu}}');"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <img src="/files/images/menus/@if($value->gambar_menu){{$value->gambar_menu}}@else{{'not-available.png'}}@endif" alt="{{ $value->nama_menu }}" width="200px" height="200px" />
                </div>
                <div class="col-md-9">
                  <h2 class="menu-title">{{ $value->nama_menu }} <small>({{$status}})</small></h2>
                  <p>
                    {{$value->deskripsi_menu}}
                  </p>
                  {{ $data['menu_obj']->num_to_rp($value->harga_menu) }}
                </div>
              </div>
              @if ($status == 'Tersedia')
              <div class="row">
                <div class="col-md-offset-9 col-md-3">
                  <div class="input-group">
                    <input type="hidden" name="order-add-name-{{$value->kode_menu}}" value="{{ $value->nama_menu }}">
                    <input type="number" name="order-add-count-{{$value->kode_menu}}" class="form-control input-lengko-default" placeholder="Jumlah" value="1" min="1" step="1">
                    <div class="input-group-addon" style="background-color: #2c3e50; color: #ecf0f1" onclick="add_menu('{{$value->kode_menu}}')"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
                  </div>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>

      @endforeach
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-push-4 col-md-4">
        <nav aria-label="Page navigation" class="text-center">
          <ul class="pagination pagination-lg">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li>
              <a href="#">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
              </a>
            </li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  @else
    <div class="row mrg-b-30">
      <div class="col-md-12 col-xs-12 text-center" style="font-size: 24pt;">
        <h1>Oops, sepertinya terjadi sesuatu</h1>
        <br />
        <a href="{{url('/about/')}}"><img src="{{ url('/files/images/dino-walking.png') }}" alt="LENGKO" width="180px" height="120px" /></a>
        <br />
        <br />
        <a href="{{ url('/about/') }}">
          Dinosaurus jahat sudah memakan semua menunya! <br />
          Kami butuh bantuan kamu untuk menghentikannya
        </a>
      </div>
    </div>
  @endif
  </div>

@endsection

@section('footer-section')
  @include('addition')
  @yield('footer-copyright')
@endsection
