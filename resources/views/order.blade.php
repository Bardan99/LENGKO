@extends('layouts.main')

@section('title', 'LENGKO - Pesanan')

@section('content')

  <div class="container">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if (count($order) > 0)
    <div class="row">
      <div class="col-md-12">

        <div class="row">
          <div class="col-md-5 col-xs-3 text-center">
            <h3 class="mrg-b-10">Menu</h3>
          </div>
          <div class="col-md-2 col-xs-3 text-center">
            <h3 class="mrg-b-10">Harga</h3>
          </div>
          <div class="col-md-3 col-xs-3 text-center">
            <h3 class="mrg-b-10">Jumlah</h3>
          </div>
          <div class="col-md-2 col-xs-3 text-center">
            <h3 class="mrg-b-10">Sub-Total</h3>
          </div>
        </div>
        @foreach ($order as $key => $value)

        <div class="row">
          <div class="col-md-5 col-xs-3">
            <div class="row">
              <div class="col-md-12 padd-lr-10 text-left" style="font-size: 16pt;">
                <button type="button" class="btn-lengko btn-lengko-danger btn-lengko-circle pull-left" onclick="remove_menu('{{ $value->kode_menu }}', '{{ $value->nama_menu }}');">
                  <i class="material-icons md-24">remove_circle_outline</i>
                </button>
                {{ $value->nama_menu }}
              </div>
            </div>
          </div>
          <div class="col-md-2 col-xs-3 text-center">
            <div class="row">
              <div class="col-md-12">
                <div style="padding-top: 4vh; padding-bottom: 4vh;" >
                  {{ $data['menu_obj']->num_to_rp($value->harga_menu) }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-xs-3 text-center">
            <div class="row">
              <div class="col-md-12">
                <div style="padding-top: 2vh; padding-bottom: 2vh;" >
                  <input type="number" id="order-qty-{{ $value->kode_menu }}" name="" min="1" step="1" class="input-lengko-default" placeholder="Jumlah" value="{{ $value->jumlah_pesanan_detil }}" onchange="multiply_val('order-qty-{{ $value->kode_menu }}', 'order-count-{{ $value->kode_menu }}', {{ $value->harga_menu }}, 'Rp'); change_menu('{{ $value->kode_menu }}', this.value);" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-xs-3 text-center">
            <div class="row">
              <div class="col-md-12">
                <div style="padding-top: 2vh; padding-bottom: 2vh;" >
                  <input type="text" id="order-count-{{ $value->kode_menu }}" name="" class="input-lengko-default block" placeholder="Jumlah" value="{{ 'Rp' . $value->harga_menu * $value->jumlah_pesanan_detil }}" style="padding: 10px; height: 42px;" disabled="disabled" />
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <div class="row mrg-b-20">
          <div class="col-md-12 col-xs-12" style="font-size: 16pt;">
            <div class="row">
              <div class="col-md-12 padd-lr-10 text-left" style="font-size: 16pt;">
                <button type="submit" class="btn-lengko btn-lengko-danger btn-lengko-circle pull-left" onclick="go_to('menu');">
                  <i class="material-icons md-24">add_circle_outline</i>
                </button>
                <a href="{{ url('/menu/') }}">"Kamu mau tambah lagi gk?" (<i>ciee perhatian nihh..</i>)</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <label>Nama Pembeli</label>
        <input type="text" name="order-create-name" class="input-lengko-default block" placeholder="(Kosongkan jika tidak ingin famous >_<)" value="" />
      </div>
      <div class="col-md-6">
        <label>Keterangan Tambahan</label>
        <textarea name="order-create-addition" class="textarea-lengko-default block" rows="5" placeholder="(Kosongkan jika tidak ada keterangan tambahan pemesanan)"></textarea>
      </div>
    </div>
    <div class="row mrg-b-20">
      <div class="col-md-12 padd-lr-10 padd-tb-10">
        <button type="button" name="order-create-button" class="btn-lengko btn-lengko-default pull-right">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Lanjutkan
        </button>
      </div>
    </div>
    @else
      <div class="row">
        <div class="col-md-12 col-xs-12 text-center" style="font-size: 24pt;">
          @if (count($data['order-processed']) > 0)
            <a href="{{url('/menu/')}}"><img src="{{ url('/files/images/lengko-favicon.png') }}" alt="LENGKO" width="180px" height="120px" /></a>
            <br />
            <a href="{{url('/menu/')}}"><h1>Sambil menunggu, yuk lihat-lihat lagi.</h1></a>
          @else
            <h1>Lho, kok belum pesan?</h1>
            <br />
            <a href="{{url('/menu/')}}"><img src="{{ url('/files/images/lengko-favicon.png') }}" alt="LENGKO" width="180px" height="120px" /></a>
            <br />
            <br />
            <a href="{{ url('/menu/') }}">
              Ayo jangan malu-malu;<br />
              Biasanya juga malu-maluin.<br />
            </a>
          @endif
        </div>
      </div>
    @endif

    <!-- cuted here -->
    @if (count($data['order-processed']) > 0)
    <div class="row mrg-t-20">
      <div class="col-md-12">

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th># ({{ $data['order-processed'][0]->nama_perangkat }})</th>
              <th width="400px">Catatan</th>
              <th>Waktu</th>
              <th>Status</th>
            </tr>
          @foreach ($data['order-processed'] as $key1 => $value1)
            <tr onclick="show_obj('review-{{ $key1 }}');" class="cursor-pointer">
              <td>#{{ $value1->kode_pesanan }} {{ $value1->pembeli_pesanan }}</td>
              <td width="400px">{{ $value1->catatan_pesanan }}</td>
              <td>{{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}</td>
              <td class="status-{{$value1->status_pesanan}}">{{ $data['menu_obj']->rewrite('status', $value1->status_pesanan) }}</td>
            </tr>
            @if (count($data[$key1]['order-processed-detail']) > 0)
            <tr id="review-{{ $key1 }}" style="display:none; visibility: none;">
              <td></td>
              <td colspan="5">
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                  <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Sub-Total</th>
                    @if ($value1->status_pesanan != 'C')
                    <th>Status</th>
                    @endif
                  </tr>
                  @foreach ($data[$key1]['order-processed-detail'] as $key2 => $value2)
                    <tr>
                      <td>{{ $value2->nama_menu }}</td>
                      <td>{{ $data['menu_obj']->num_to_rp($value2->harga_menu) }}</td>
                      <td>{{ $value2->jumlah_pesanan_detil }}</td>
                      <td>{{ $data['menu_obj']->num_to_rp($value2->harga_menu * $value2->jumlah_pesanan_detil) }}</td>
                      @if ($value1->status_pesanan != 'C')
                        <td class="status-{{$value2->status_pesanan_detil}}">{{ $data['menu_obj']->rewrite('status', $value2->status_pesanan_detil) }}</td>
                      @endif
                    </tr>
                  @endforeach
                  <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <td colspan="2">{{ $data['menu_obj']->num_to_rp($value1->harga_pesanan) }}</td>
                  </tr>
                  </table>
                </div>
              </td>
            </tr>
            @endif
          @endforeach
          </table>
        </div>

      </div>
      </div>
      @endif
    <!-- here -->

  </div> <!-- end container -->

@endsection

@section('footer-section')
  @include('addition')
  @yield('footer-copyright')
@endsection
