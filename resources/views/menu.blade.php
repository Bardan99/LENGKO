@extends('main')

@section('title', 'LENGKO - Menu')

@section('content')
  <div class="row mrg-btm-30">
    @foreach ($menus as $key => $value)
      <div class="col-md-4 col-sm-6">
        <div class="menu">
          <img src="files/images/menus/{{ $value->gambar_hidangan }}" alt="{{ $value->nama_hidangan }}" width="100%" height="" />
          <h2 class="menu-title">{{ $value->nama_hidangan }}</h2>
          {{ $menu_obj->num_to_rp($value->harga_hidangan) }}
          <a href="/" class="pull-right"><i class="material-icons">add_shopping_cart</i></a>
          <br />
        </div>
      </div>
    @endforeach

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
