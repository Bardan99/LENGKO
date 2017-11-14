@extends('layouts.dashboard')

@section('title', 'LENGKO - Menu')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Menu</div>
            <div class="panel-body">
              @if (count($data['menu']) > 0)

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
                    <input type="text" name="" class="form-control" placeholder="Cari Menu" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row mrg-t-20 padd-lr-20">
                <div class="box-menu">
                  <div class="row mrg-b-10">
                    <div class="col-md-6 text-center"><b>Menu</b></div>
                    <div class="col-md-6 text-center"><b>Deskripsi</b></div>
                  </div>
                @foreach ($data['menu'] as $key => $value)
                  <div class="row mrg-b-10 padd-tb-10">
                    <div class="col-md-6">

                      <div class="row">
                        <div class="col-md-5">
                          <img class="img-thumbnail img-center" src="/files/images/menus/{{ $value->gambar_menu }}" alt="{{ $value->nama_menu }}" width="200px" height="200px" />
                          <small><div class="text-center">{{ $data['menu_obj']->menu_type($value->jenis_menu) }}</div></small>
                        </div>
                        <div class="col-md-7">
                          <div class="row">
                            <div class="col-md-12">{{ $value->nama_menu }}</div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">{{ $data['menu_obj']->num_to_rp($value->harga_menu) }}</div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="well well-sm">
                              @php ($res = false)
                              @php ($i = 0)
                              @foreach ($data[$key]['menu-status'] as $key2 => $value2)
                                @php ($i++)
                                @if ($value2->stok_bahan_baku > 0)
                                  @php ($res = true)
                                @else
                                  @php ($res = false)
                                  @break
                                @endif
                              @endforeach
                              @if ($i == count($data[$key]['menu-status']))
                                @if ($res)
                                  {!! '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Tersedia ' !!}
                                @else
                                  {!! '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Tidak Tersedia ' !!}
                                @endif
                              @else
                                {!! '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Tidak Tersedia ' !!}
                              @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="col-md-6">{{ substr($value->deskripsi_menu, 0, 300) . '' }}</div>
                  </div>
                @endforeach
                </div>
              </div>

              @endif

            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Tambah Menu</div>
            <div class="panel-body">

              <form class="form-horizontal">
                <div class="row">
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Kode</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" name="" class="input-lengko-default block" placeholder="Kode Menu" />
                  </div>
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Nama</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" name="" class="input-lengko-default block" placeholder="Nama Menu" />
                  </div>
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Harga</label>
                  </div>
                  <div class="col-md-3">
                    <input type="number" name="" min="0" step="5000" class="input-lengko-default block" placeholder="Harga Menu" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1">
                    <label>Gambar</label>
                  </div>
                  <div class="col-md-2">
                    <div class="container-file-lengko block">
                      <img class="img-thumbnail" src="/files/images/menus/default.png" alt="" width="140px" height="140px" />
                      <input type="file" title="Ubah gambar menu" />
                    </div>
                  </div>
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Jenis</label>
                  </div>
                  <div class="col-md-2">
                    <div class="radio-lengko-default">
                      <input type="radio" name="type" id="menu-food" value="F" /><label for="menu-food">Makanan</label>
                      <input type="radio" name="type" id="menu-drink" value="D" /><label for="menu-drink">Minuman</label>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Deskripsi</label>
                  </div>
                  <div class="col-md-5">
                    <textarea name="" class="textarea-lengko-default block" rows="5" placeholder="Deskripsi Menu"></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="row mrg-b-10">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-8">
                            <label>Bahan Baku</label>
                          </div>
                          <div class="col-md-4">
                            <div class="input-group">
                              <input type="text" name="" class="form-control" placeholder="Cari Bahan Baku" />
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="scrollable scrollable-md">
                          <div class="row">
                            @foreach ($data['material'] as $key => $value)
                              <div class="col-md-6">
                                <input type="number" name="" id="needed-material-{{ $key }}" min="0" max="{{ $value->stok_bahan_baku }}" step="1" class="input-lengko-default" placeholder="0.0" onchange="chg_val('needed-material-{{ $key }}', 'available-material-{{ $key }}', {{ $value->stok_bahan_baku }});" @if ($value->stok_bahan_baku == 0) {{ 'disabled="disabled" disabled' }} @endif />
                                /
                                <input type="number" name="" id="available-material-{{ $key }}" min="0" max="{{ $value->stok_bahan_baku }}" step="1" class="input-lengko-default" placeholder="{{ $value->stok_bahan_baku }}" value="{{ $value->stok_bahan_baku }}" disabled="disabled" disabled />
                                (<small>{{ $value->satuan_bahan_baku }}</small>)
                                {{ $value->nama_bahan_baku }}
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>

                    <br />
                    Bahan baku tidak tersedia? Silahkan ajukan permohonan pengadaan Bahan Baku.
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <hr />
                    <button type="reset" class="btn-lengko btn-lengko-danger">Batalkan</button>
                    <button type="submit" class="btn-lengko btn-lengko-default pull-right">Tambah</button>
                  </div>
                </div>
              </form>

            </div>
          </div>

        </div>

      </div>

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Pengajuan Pengadaan Bahan Baku</div>
            <div class="panel-body">
              <div class="row mrg-tb-20 padd-lr-15">
                <div class="col-md-12">
                  @if (count($data['material-request']) > 0)
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>#</th>
                        <th>Subjek</th>
                        <th>Waktu</th>
                        <th>Prioritas</th>
                        <th width="300px">Keterangan</th>
                        <th>Status</th>
                      </tr>
                    @foreach ($data['material-request'] as $key1 => $value)
                      <tr>
                        <td>{{ $value->kode_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->subjek_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->tanggal_pengadaan_bahan_baku . ' ' . $value->waktu_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->nama_prioritas }}</td>
                        <td width="300px">{{ $value->catatan_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->status_pengadaan_bahan_baku }}</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td colspan="5">
                          <div class="table-responsive">
                            <table class="table table-hover table-striped">
                            <tr>
                              <th>Nama</th>
                              <th>Jumlah</th>
                              <th>Satuan</th>
                            </tr>
                              @foreach ($data[$key1]['material-request-detail'] as $key2 => $value)
                                <tr>
                                  <td>{{ $value->nama_bahan_baku }}</td>
                                  <td>{{ $value->jumlah_bahan_baku }}</td>
                                  <td>{{ $value->satuan_bahan_baku }}</td>
                                </tr>
                              @endforeach
                            </table>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                    </table>
                  </div>
                  @endif
                  <hr />
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <form class="form-horizontal">
                    <div class="row">
                      <div class="col-md-2">
                        <label style="margin: 10px 5px 10px 0px;">Subjek</label>
                      </div>
                      <div class="col-md-5">
                        <input type="text" name="" class="input-lengko-default block" placeholder="Subjek Pengadaan Bahan Baku" />
                      </div>
                      <div class="col-md-2">
                        <label style="margin: 10px 5px 10px 0px;">Prioritas</label>
                      </div>
                      <div class="col-md-3">
                        <select name="" class="select-lengko-default block">
                          @foreach ($data['priority'] as $key => $value)
                            <option value="{{ $value->kode_prioritas }}">{{ $value->nama_prioritas }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <label style="margin: 10px 5px 10px 0px;">Nama</label>
                      </div>
                      <div class="col-md-6">
                        <input type="text" id="material-name-0" name="" class="input-lengko-default block" placeholder="Nama Bahan Baku" />
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-2 col-xs-12 col-sm-12 padd-lr-15">
                            <button type="button" class="btn-lengko btn-lengko-default block" onclick="add_val('material-list-0', 'material-name-0');" style="height:42px; padding: 10px 5px 10px 5px; font-size: 13pt;">
                              <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;
                            </button>
                          </div>
                          <div class="col-md-10 col-xs-12 col-sm-12 padd-lr-15">
                            <select id="material-list-0" name="" class="select-lengko-default block" onchange="add_val('material-list-0', 'material-name-0');">
                              @foreach ($data['material'] as $key => $value)
                                <option value="{{ $value->kode_bahan_baku }}">{{ $value->nama_bahan_baku }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="material-list-request">
                      <!-- using jquery dom append to add above item below -->
                    </div>

                    <div class="row">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" id="btn-material-list-request" class="btn-lengko btn-lengko-default block" style="height:18px; padding: 0px 5px 0px 5px; font-size: 10pt;">
                          <span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>&nbsp;
                        </button>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-2">
                        <label style="margin: 10px 5px 10px 0px;">Keterangan</label>
                      </div>
                      <div class="col-md-10">
                        <textarea name="" class="textarea-lengko-default block" rows="5" placeholder="(Kosongkan jika tidak ada keterangan)"></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <hr />
                        <button type="reset" class="btn-lengko btn-lengko-danger">Batalkan</button>
                        <button type="submit" class="btn-lengko btn-lengko-default pull-right">Ajukan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>

  </div>

@endsection
