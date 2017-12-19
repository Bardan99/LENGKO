@extends('layouts.main')

@section('title', 'LENGKO - Pesanan')

@section('content')
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="container">

    @if (count($order) > 0)
    <div class="row">
      <div class="col-md-12">
        <!-- new order from session -->
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
                  {{ $data['method']->num_to_rp($value->harga_menu) }}
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

    <div class="row mrg-b-20 padd-tb-10">
      <div class="col-md-offset-9 col-md-3 padd-lr-10 padd-tb-10">
        <button type="button" name="order-create-button" class="btn-lengko btn-lengko-default pull-right open-tooltip" data-placement="left" data-toggle="tooltip" title="Lanjutkan proses pemesanan..">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Tambah Pesanan
        </button>
      </div>
    </div>
    <!-- new order from session -->
    @else

    <div class="row">
      <div class="col-md-12 col-xs-12 text-center" style="font-size: 24pt;">
        @if (count($data['order-processed']) > 0)

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
      <div class="col-md-9">

        <div id="customer-order" class="note-book">
          @foreach ($data['order-processed'] as $key1 => $value1)
            <h1 class="text-center">Daftar Pesanan <br />{{ $value1->nama_perangkat }}</h1>

            <div class="row padd-lr-15">
              <div class="col-md-6 col-sm-6 col-xs-6">
                <label>Pesanan: </label> #{{ $value1->kode_pesanan }} {{ $value1->pembeli_pesanan }}
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <label>Waktu: </label> {{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <label>Status: </label> {{ $data['method']->rewrite('status', $value1->status_pesanan) }}
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <label>Catatan: </label> <br />{{ $value1->catatan_pesanan }}
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="seperator"></div>
              </div>
            </div>

            @if (count($data[$key1]['order-processed-detail']) > 0)
              @foreach ($data[$key1]['order-processed-detail'] as $key2 => $value2)
                @if ($key2 === 0)
                <div class="row padd-lr-15 desktop-only">
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class=" padd-tb-10">
                      <label class="desktop-only">Menu</label>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class=" padd-tb-10">
                      <label class="desktop-only">Harga</label>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class=" padd-tb-10">
                      <label class="desktop-only">Jumlah</label>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class=" padd-tb-10">
                      <label class="desktop-only">Sub-Total</label>
                    </div>
                  </div>
                  @if ($value1->status_pesanan != 'C')
                  <div class="col-md-3 col-sm-12 col-xs-12 ">
                    <div class=" padd-tb-10">
                      <label class="desktop-only">Status</label>
                    </div>
                  </div>
                  @endif
                </div>
                @endif

                <div class="row padd-lr-15 mrg-t-5">
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="">
                      <label class="not-desktop-only">Menu</label>
                    </div>
                    <div class=" padd-tb-10">
                      {{ $value2->nama_menu }}
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="">
                      <label class="not-desktop-only">Harga</label>
                    </div>
                    <div class=" padd-tb-10">
                      {{ $data['method']->num_to_rp($value2->harga_menu) }}
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="">
                      <label class="not-desktop-only">Jumlah</label>
                    </div>
                    <div class=" padd-tb-10">
                      {{ $value2->jumlah_pesanan_detil }}
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="">
                      <label class="not-desktop-only">Sub-Total</label>
                    </div>
                    <div class=" padd-tb-10">
                      {{ $data['method']->num_to_rp($value2->harga_menu * $value2->jumlah_pesanan_detil) }}
                    </div>
                  </div>
                  @if ($value1->status_pesanan != 'C')
                  <div class="col-md-3 col-sm-12 col-xs-12 ">
                    <div class="">
                      <label class="not-desktop-only">Status</label>
                    </div>
                    <div class="status-{{$value2->status_pesanan_detil}} padd-tb-10 padd-lr-15">
                      {{ $data['method']->rewrite('status', $value2->status_pesanan_detil) }}
                    </div>
                  </div>
                  @endif
                </div>
                <div class="row padd-lr-15">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <hr />
                  </div>
                </div>
              @endforeach
              <div class="row padd-tb-10">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="seperator"></div>
                </div>
              </div>
              <div class="row padd-lr-15">
                <div class="col-md-offset-5 col-md-2 col-sm-6 col-xs-6">
                  <label>Total</label>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 ">
                  <strong>{{ $data['method']->num_to_rp($value1->harga_pesanan) }}</strong>
                </div>
              </div>
              <div class="row padd-tb-10">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="seperator"></div>
                </div>
              </div>
              <!-- all orders already done -->
              @if ($value1->status_pesanan == 'T')
                <div class="row padd-tb-20">
                  <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
                    <button type="button" name="order-finish-button" class="btn-lengko btn-lengko-default pull-right block" onclick="finish_order();">
                      <span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Bayar Sekarang
                    </button>
                  </div>
                </div>
              @endif
              <!-- all orders already done -->
            @endif
          @endforeach

        </div> <!-- end notebookk -->

      </div>
      <div class="col-md-3 desktop-only text-center">
        <a href="{{url('/order')}}"><img src="{{ url('/files/images/unknown-character.png') }}" alt="LENGKO" width="230px" height="350px" /></a>
        <br /><small><b>Ini gambar boleh nyolonqq >_<</b></small>
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
