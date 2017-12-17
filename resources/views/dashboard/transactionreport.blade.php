@extends('layouts.report')

@section('title', 'LENGKO - Laporan Transaksi')

@push('style')
  <style type="text/css" media="print">
    @page {
        size: portrait;
        margin: 0.1cm;
    }
  </style>
@endpush

@section('content')

  <input type="hidden" name="search_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">

          @if (count($data['transaction']) > 0)
          <!-- copied here -->
          <div class="row">
            <div class="col-md-12">

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 padd-lr-30">
                  <h1>LENGKO Resto's</h1>
                  <p>
                    Jl. Sendirian Aja No. 99, Kav. Kawin, Bandung, Jawa Barat <br />
                    Telepon: +(62)222 0000 2017 &nbsp;&nbsp;&nbsp;&nbsp; Fax: +(62)222 1111 2017
                  </p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="seperator"></div>
                </div>
              </div>

              <div id="transaction-card-section" class="padd-tb-10">
                @foreach ($data['transaction'] as $key1 => $value1)
                  <div class="padd-tb-10 padd-lr-15">

                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label>Transaksi</label> #{{ $value1->kode_pesanan }}
                        <br />
                        <label>Pembeli</label> {{ $value1->pembeli_pesanan }}
                        <br />
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label>Perangkat</label> {{ $value1->nama_perangkat }}
                        <br />
                        <label>Waktu</label> {{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}
                        <br />
                      </div>
                    </div>

                  </div>
                  @if (count($data[$key1]['transaction-detail']) > 0)

                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="transaction-{{ $key1 }}" class="mrg-t-20 padd-lr-15">

                          <table class="table table-hover table-striped">
                            <tr>
                              <th>Pesanan</th>
                              <th>Harga</th>
                              <th>Jumlah</th>
                              <th>Sub-Total</th>
                            </tr>
                          @foreach ($data[$key1]['transaction-detail'] as $key2 => $value2)
                            <tr>
                              <td>{{ $value2->nama_menu }}</td>
                              <td>{{ $data['method']->num_to_rp($value2->harga_menu) }}</td>
                              <td>{{ $value2->jumlah_pesanan_detil }}</td>
                              <td>{{ $data['method']->num_to_rp($value2->harga_menu * $value2->jumlah_pesanan_detil) }}</td>
                            </tr>
                          @endforeach
                            <tr>
                              <td colspan="3" class="text-right"><label>Total</label></td>
                              <td>{{ $data['method']->num_to_rp($value1->harga_pesanan) }}</td>
                            </tr>
                            <tr>
                              <td colspan="3" class="text-right"><label>Tunai</label></td>
                              <td width="170px">
                                {{ $data['method']->num_to_rp($value1->tunai_pesanan) }}
                              </td>
                            </tr>
                          </table>

                        </div>
                      </div>
                    </div>
                  @endif
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="seperator"></div>
                    </div>
                  </div>

                  <div class="row mrg-t-20">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      <quote class="parisienne">
                        Hai dear, See you next hunger!
                      </quote>
                    </div>
                  </div>

                @endforeach
                <!-- copied here -->

              @else
                <div class="row">
                  <div class="col-md-8">
                    <div class="alert alert-warning">
                      Transaksi tidak ditemukan
                    </div>
                  </div>
                </div>
              @endif

            </div>
          </div>

        </div>
      </div> <!-- end -->

    </div>
  </div>

@endsection
