@extends('layouts.dashboard')

@section('title', 'LENGKO - Transaksi')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">
          <input type="hidden" name="search_token" value="{{ csrf_token() }}">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Transaksi</div>
            <div class="panel-body">
              @if (count($data['transaction']) > 0)

              <div class="row">
                <div class="col-md-offset-8 col-md-4">
                  <div class="input-group padd-tb-10">
                    <input type="text" name="transaction-search-query" class="form-control" placeholder="Cari Transaksi" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" name="transaction-search-button" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div id="transaction-card-section" class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>Transaksi</th>
                        <th>Waktu</th>
                        <th>Pembeli</th>
                        <th>Perangkat</th>
                      </tr>
                    @foreach ($data['transaction'] as $key1 => $value1)
                      <tr onclick="show_obj('transaction-{{ $key1 }}');" class="cursor-pointer">
                        <td>#{{ $value1->kode_pesanan }}</td>
                        <td>{{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}</td>
                        <td>{{ $value1->pembeli_pesanan }}</td>
                        <td>{{ $value1->nama_perangkat }}</td>
                      </tr>
                      @if (count($data[$key1]['transaction-detail']) > 0)
                      <tr id="transaction-{{ $key1 }}" style="display:none; visibility: none;">
                        <td></td>
                        <td colspan="5">
                          <div class="table-responsive">
                            <table class="table table-hover table-striped">
                            <tr>
                              <th>Menu</th>
                              <th>Harga</th>
                              <th>Jumlah</th>
                              <th>Sub-Total</th>
                            </tr>
                            @foreach ($data[$key1]['transaction-detail'] as $key2 => $value2)
                              <tr>
                                <td>{{ $value2->nama_menu }}</td>
                                <td>{{ $data['menu_obj']->num_to_rp($value2->harga_menu) }}</td>
                                <td>{{ $value2->jumlah_pesanan_detil }}</td>
                                <td>{{ $data['menu_obj']->num_to_rp($value2->harga_menu * $value2->jumlah_pesanan_detil) }}</td>
                              </tr>
                            @endforeach
                            <tr>
                              <td colspan="3" class="text-right"><label>Total</label></td>
                              <td>{{ $data['menu_obj']->num_to_rp($value1->harga_pesanan) }}</td>
                            </tr>
                            <tr>
                              <td colspan="3" class="text-right"><label>Tunai</label></td>
                              <td width="170px">
                                <input type="number" id="transaction-cash-{{$value1->kode_pesanan}}" name="transaction-cash-{{$value1->kode_pesanan}}" min="{{$value1->harga_pesanan}}" step="5000" class="input-lengko-default block" placeholder="0" value="{{ $value1->harga_pesanan }}" onchange="cash_back('transaction-cash-{{$value1->kode_pesanan}}', 'transaction-cash-back-{{$value1->kode_pesanan}}', {{ $value1->harga_pesanan }}, 'Rp');" />
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" class="text-right"><label>Kembali</label></td>
                              <td>
                                <input type="text" id="transaction-cash-back-{{$value1->kode_pesanan}}" class="input-lengko-default block" value="0" disabled="disabled" disabled />
                              </td>
                            </tr>
                            </table>
                            <hr />
                            <button type="button" class="btn-lengko btn-lengko-warning pull-left">
                              <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak
                            </button>
                            <button type="button" class="btn-lengko btn-lengko-default pull-right" onclick="done_transaction({{ $value1->kode_pesanan }});">
                              <span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Bayar
                            </button>
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

            </div>
          </div>

        </div>
      </div> <!-- end -->

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Catatan Transaksi</div>
            <div class="panel-body">
              @if (count($data['transaction-history']) > 0)

              <div class="row">
                <div class="col-md-offset-8 col-md-4">
                  <div class="input-group padd-tb-10">
                    <input type="text" name="transaction-history-search-query" class="form-control" placeholder="Cari Catatan Transaksi" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" name="transaction-history-search-button" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div id="transaction-history-card-section" class="table-responsive">
                <table class="table">
                  <tr>
                    <th>Transaksi</th>
                    <th>Waktu</th>
                    <th>Pembeli</th>
                    <th>Perangkat</th>
                  </tr>
                @foreach ($data['transaction-history'] as $key1 => $value1)
                  <tr onclick="show_obj('transaction-history-{{ $key1 }}');" class="cursor-pointer">
                    <td>#{{ $value1->kode_pesanan }}</td>
                    <td>{{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}</td>
                    <td>{{ $value1->pembeli_pesanan }}</td>
                    <td>{{ $value1->nama_perangkat }}</td>
                  </tr>
                  @if (count($data[$key1]['transaction-history-detail']) > 0)
                  <tr id="transaction-history-{{ $key1 }}" style="display:none; visibility: none;">
                    <td></td>
                    <td colspan="5">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                        <tr>
                          <th>Menu</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Sub-Total</th>
                        </tr>
                        @foreach ($data[$key1]['transaction-history-detail'] as $key2 => $value2)
                          <tr>
                            <td>{{ $value2->nama_menu }}</td>
                            <td>{{ $data['menu_obj']->num_to_rp($value2->harga_menu) }}</td>
                            <td>{{ $value2->jumlah_pesanan_detil }}</td>
                            <td>{{ $data['menu_obj']->num_to_rp($value2->harga_menu * $value2->jumlah_pesanan_detil) }}</td>
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="3" class="text-right"><label>Total</label></td>
                          <td>{{ $data['menu_obj']->num_to_rp($value1->harga_pesanan) }}</td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right"><label>Tunai</label></td>
                          <td>{{ $data['menu_obj']->num_to_rp($value1->tunai_pesanan) }}</td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right"><label>Kembali</label></td>
                          <td>{{ $data['menu_obj']->num_to_rp($value1->tunai_pesanan - $value1->harga_pesanan) }}</td>
                        </tr>
                        </table>
                      </div>
                      <button type="button" class="btn-lengko btn-lengko-warning pull-right">
                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak
                      </button>
                    </td>
                  </tr>
                  @endif
                @endforeach
                </table>
              </div>
              @endif

            </div>
          </div>

        </div>
      </div> <!-- end -->

    </div>
  </div>

@endsection
