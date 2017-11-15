@extends('layouts.dashboard')

@section('title', 'LENGKO - Bahan Baku')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Pengajuan Pengadaan Bahan Baku</div>
            <div class="panel-body">

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
                    <input type="text" name="" class="form-control" placeholder="Cari Bahan Baku" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row mrg-tb-20 padd-lr-15">
                <div class="col-md-12">
                  @if (count($data['material-request-user']) > 0)
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
                    @foreach ($data['material-request-user'] as $key1 => $value)
                      <tr onclick="show_obj('material-request-user-{{ $key1 }}');" class="cursor-pointer">
                        <td>{{ $value->kode_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->subjek_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->tanggal_pengadaan_bahan_baku . ' ' . $value->waktu_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->nama_prioritas }}</td>
                        <td width="300px">{{ $value->catatan_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->status_pengadaan_bahan_baku }}</td>
                      </tr>
                      <tr id="material-request-user-{{ $key1 }}" style="display:none; visibility: none;">
                        <td></td>
                        <td colspan="5">
                          <div class="table-responsive">
                            <table class="table table-hover table-striped">
                            <tr>
                              <th>Nama</th>
                              <th>Jumlah</th>
                              <th>Satuan</th>
                            </tr>
                              @foreach ($data[$key1]['material-request-user-detail'] as $key2 => $value)
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

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Pengadaan Bahan Baku</div>
            <div class="panel-body">

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
                    <input type="text" name="" class="form-control" placeholder="Cari Bahan Baku" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

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
                      <tr onclick="show_obj('material-request-{{ $key1 }}');" class="cursor-pointer">
                        <td>{{ $value->kode_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->subjek_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->tanggal_pengadaan_bahan_baku . ' ' . $value->waktu_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->nama_prioritas }}</td>
                        <td width="300px">{{ $value->catatan_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->status_pengadaan_bahan_baku }}</td>
                      </tr>
                      <tr id="material-request-{{ $key1 }}" style="display:none; visibility: none;">
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

            </div>
          </div>

        </div>
      </div>


    </div>
  </div>

@endsection
