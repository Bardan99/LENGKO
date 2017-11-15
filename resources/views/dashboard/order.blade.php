@extends('layouts.dashboard')

@section('title', 'LENGKO - Pesanan')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Konfirmasi Pesanan</div>
            <div class="panel-body">
              @if (count($data['order-confirmation']) > 0)

              <div class="row">
                <div class="col-md-4">
                  <nav aria-label="Page navigation" class="mrg-lr-5">
                    <ul class="pagination pagination-md mrg-tb-0">
                      <li>
                        <a href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>
                      <li>
                        <span>&nbsp;</span>
                      </li>
                      <li>
                        <a href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
                </div>
                <div class="col-md-offset-4 col-md-4">
                  <div class="input-group">
                    <input type="text" name="" class="form-control" placeholder="Cari Pesanan" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th>Transaksi</th>
                    <th>Waktu</th>
                    <th>Pembeli</th>
                    <th>Perangkat</th>
                    <th>Konfirmasi</th>
                  </tr>
                @foreach ($data['order-confirmation'] as $key1 => $value1)
                  <tr onclick="show_obj('order-confirmation-{{ $key1 }}');" class="cursor-pointer">
                    <td>#{{ $value1->kode_pesanan }}</td>
                    <td>{{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}</td>
                    <td>{{ $value1->pembeli_pesanan }}</td>
                    <td>{{ $value1->nama_perangkat }}</td>
                    <td>
                      <button type="button" class="btn-lengko btn-lengko-warning" width="80px">
                        <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                      </button>
                    </td>
                  </tr>
                  @if (count($data[$key1]['order-confirmation-detail']) > 0)
                  <tr id="order-confirmation-{{ $key1 }}" style="display:none; visibility: none;">
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
                        @foreach ($data[$key1]['order-confirmation-detail'] as $key2 => $value2)
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
                        </table>
                      </div>
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
      </div>


      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Antrian Pesanan</div>
            <div class="panel-body scrollable scrollable-xl">
              @if (count($data['order']) > 0)

                <div class="row">
                  <div class="col-md-3">
                    <div class="list-group">
                      <li class="list-group-item"><label>Antrian Perangkat</label></li>
                      <div class="scrollable scrollable-md">
                      @foreach ($data['order'] as $key => $value)
                        <a href="#" class="list-group-item @if ($key == 0) {{ 'active' }} @endif">
                          #{{ $value->kode_pesanan }}
                          [{{ $value->nama_perangkat }}]
                        </a>
                      @endforeach
                      </div>
                    </div>

                    <div class="list-group">
                      <li class="list-group-item"><label>Antrian Menu</label></li>
                      <div class="scrollable scrollable-lg">
                      @foreach ($data['order-detail'] as $key => $value)
                        <a href="#" class="list-group-item @if ($key == 0) {{ 'active' }} @endif">
                          {{ $value->nama_menu }}
                          ({{ $value->jumlah_pesanan_detil }})
                        </a>
                      @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="row">
                      <div class="col-md-12">
                        <h3 class="text-center">
                          #{{ $data['order'][0]->kode_pesanan }}
                          ({{ $data['order'][0]->nama_perangkat }})
                        </h3>
                        <hr />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <label>Transaksi:</label> #{{ $data['order'][0]->kode_pesanan }}
                        ({{ $data['order'][0]->nama_perangkat }})
                        <br />
                        <label>Pembeli:</label> {{ $data['order'][0]->pembeli_pesanan }}
                        <br />
                        <label>Waktu:</label> {{ $data['order'][0]->tanggal_pesanan }}
                        {{ $data['order'][0]->waktu_pesanan }}
                      </div>
                      <div class="col-md-5">
                        <label>Catatan:</label>
                        <br />
                        {{ $data['order'][0]->catatan_pesanan }}
                      </div>
                      <div class="col-md-3">
                        <button type="button" class="btn-lengko btn-lengko-success block" title="Tandai sudah selesai semua">
                          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </button>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-offset-4 col-md-4">
                            <h3 class="text-center border-btm">Makanan</h3>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            @foreach ($data['order-detail-food'] as $key => $value)
                              @if ($value->kode_pesanan == $data['order'][0]->kode_pesanan)
                                <div class="row">
                                  <div class="col-md-10">
                                    {{ $value->nama_menu }} ({{ $value->jumlah_pesanan_detil }})
                                  </div>
                                  <div class="col-md-2">
                                    @if ($value->status_pesanan_detil == 'P')
                                      <button type="button" class="btn-lengko btn-lengko-success block" style="font-size: 10px;">
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                      </button>
                                    @elseif ($value->status_pesanan_detil == 'D')
                                      <button type="button" class="btn-lengko btn-lengko-warning block" style="font-size: 10px;">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                      </button>
                                    @endif
                                  </div>
                                </div>
                              @endif
                            @endforeach
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-offset-4 col-md-4">
                            <h3 class="text-center border-btm">Minuman</h3>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            @foreach ($data['order-detail-drink'] as $key => $value)
                              @if ($value->kode_pesanan == $data['order'][0]->kode_pesanan)
                                <div class="row">
                                  <div class="col-md-10">
                                    {{ $value->nama_menu }} ({{ $value->jumlah_pesanan_detil }})
                                  </div>
                                  <div class="col-md-2">
                                    @if ($value->status_pesanan_detil == 'P')
                                      <button type="button" class="btn-lengko btn-lengko-success block" style="font-size: 10px;">
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                      </button>
                                    @elseif ($value->status_pesanan_detil == 'D')
                                      <button type="button" class="btn-lengko btn-lengko-warning block" style="font-size: 10px;">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                      </button>
                                    @endif
                                  </div>
                                </div>
                              @endif
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>

                    @if ($data['order'][1])
                    <div class="overlay radius-5 padd-lr-10 padd-tb-10">
                      <div class="row">
                        <div class="col-md-12">
                          <h3 class="text-center">
                            <small><<</small>
                            #{{ $data['order'][1]->kode_pesanan }}
                            ({{ $data['order'][1]->nama_perangkat }})
                            <small>>></small>
                          </h3>
                          <hr />
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <label>Transaksi:</label> #{{ $data['order'][1]->kode_pesanan }}
                          ({{ $data['order'][1]->nama_perangkat }})
                          <br />
                          <label>Pembeli:</label> {{ $data['order'][1]->pembeli_pesanan }}
                          <br />
                          <label>Waktu:</label> {{ $data['order'][1]->tanggal_pesanan }}
                          {{ $data['order'][1]->waktu_pesanan }}
                        </div>
                        <div class="col-md-5">
                          <label>Catatan:</label>
                          <br />
                          {{ $data['order'][1]->catatan_pesanan }}
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn-lengko btn-lengko-success block" title="Tandai sudah selesai semua">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                          </button>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-offset-4 col-md-4">
                              <h3 class="text-center border-btm">Makanan</h3>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              @foreach ($data['order-detail-food'] as $key => $value)
                                @if ($value->kode_pesanan == $data['order'][1]->kode_pesanan)
                                  <div class="row">
                                    <div class="col-md-10">
                                      {{ $value->nama_menu }} ({{ $value->jumlah_pesanan_detil }})
                                    </div>
                                    <div class="col-md-2">
                                      @if ($value->status_pesanan_detil == 'P')
                                        <button type="button" class="btn-lengko btn-lengko-success block" style="font-size: 10px;">
                                          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        </button>
                                      @elseif ($value->status_pesanan_detil == 'D')
                                        <button type="button" class="btn-lengko btn-lengko-warning block" style="font-size: 10px;">
                                          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </button>
                                      @endif
                                    </div>
                                  </div>
                                @endif
                              @endforeach
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-offset-4 col-md-4">
                              <h3 class="text-center border-btm">Minuman</h3>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              @foreach ($data['order-detail-drink'] as $key => $value)
                                @if ($value->kode_pesanan == $data['order'][1]->kode_pesanan)
                                  <div class="row">
                                    <div class="col-md-10">
                                      {{ $value->nama_menu }} ({{ $value->jumlah_pesanan_detil }})
                                    </div>
                                    <div class="col-md-2">
                                      @if ($value->status_pesanan_detil == 'P')
                                        <button type="button" class="btn-lengko btn-lengko-success block" style="font-size: 10px;">
                                          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        </button>
                                      @elseif ($value->status_pesanan_detil == 'D')
                                        <button type="button" class="btn-lengko btn-lengko-warning block" style="font-size: 10px;">
                                          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </button>
                                      @endif
                                    </div>
                                  </div>
                                @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                    @endif
                  </div> <!--end column -->
                </div> <!--end row -->

              @endif

            </div>
          </div>

        </div>
      </div> <!-- end -->

    </div>

  </div>

@endsection
