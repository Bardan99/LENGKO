@extends('layouts.dashboard')

@section('title', 'LENGKO - Bahan Baku')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      <input type="hidden" name="search_token" value="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Pengajuan Pengadaan Bahan Baku</div>
            <div class="panel-body">
              @if (count($errors) > 0)
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
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
                  @else
                    <div class="row">
                      <div class="col-md-8">
                        <div class="alert alert-warning">
                          Kamu belum membuat pengajuan bahan baku;<br />
                          Jangan lama-lama, nanti diduluin orang bawa doi ke penghulu (Baper::me)
                        </div>
                      </div>
                    </div>
                  @endif
                  <hr />
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <form name="material-request-add" class="form-horizontal" action="{{url('/dashboard/create/request')}}" method="post">
                    <div class="row">
                      <div class="col-md-2">
                        <label style="margin: 10px 5px 10px 0px;">Subjek</label>
                      </div>
                      <div class="col-md-5">
                        <input type="text" name="material-request-create-subject" class="input-lengko-default block" placeholder="Subjek Pengadaan Bahan Baku" />
                      </div>
                      <div class="col-md-2">
                        <label style="margin: 10px 5px 10px 0px;">Prioritas</label>
                      </div>
                      <div class="col-md-3">
                        <select name="material-request-create-priority" class="select-lengko-default block">
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
                        <input type="text" id="material-request-create-item-0" name="material-request-create-item-0" class="input-lengko-default block" placeholder="Nama Bahan Baku" />
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-2 col-xs-12 col-sm-12 padd-lr-15">
                            <button type="button" class="btn-lengko btn-lengko-default block" onclick="add_val('material-list-0', 'material-request-create-item-0');" style="height:42px; padding: 10px 5px 10px 5px; font-size: 13pt;">
                              <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;
                            </button>
                          </div>
                          <div class="col-md-10 col-xs-12 col-sm-12 padd-lr-15">
                            <select id="material-list-0" name="" class="select-lengko-default block" onchange="add_val('material-list-0', 'material-request-create-item-0');">
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
                        <textarea name="material-request-create-addition" class="textarea-lengko-default block" rows="5" placeholder="(Kosongkan jika tidak ada keterangan)"></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <hr />
                        <input type="hidden" name="_method" value="post">
                        <input type="hidden" name="material-request-create-max" value="1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
              @if (count($data['material-request']) > 0)

              <div class="row mrg-tb-20 padd-lr-15">
                <div id="request-material-card-section" class="col-md-12">

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>#</th>
                        <th>Subjek</th>
                        <th>Waktu</th>
                        <th>Prioritas</th>
                        <th width="300px">Keterangan</th>
                      </tr>
                    @foreach ($data['material-request'] as $key1 => $value)
                      <tr onclick="show_obj('material-request-{{ $key1 }}');" class="cursor-pointer">
                        <td>{{ $value->kode_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->subjek_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->tanggal_pengadaan_bahan_baku . ' ' . $value->waktu_pengadaan_bahan_baku }}</td>
                        <td>{{ $value->nama_prioritas }}</td>
                        <td width="300px">{{ $value->catatan_pengadaan_bahan_baku }}</td>
                      </tr>
                      <tr id="material-request-{{ $key1 }}" style="display:none; visibility: none;">
                        <td></td>
                        <td colspan="5">
                          <form name="material-request-detil-add" action="{{url('/dashboard/create/materialrequest')}}" method="post">
                            <input type="hidden" name="material-request-detail-method" value="post">
                            <input type="hidden" name="material-request-detail-token" value="{{ csrf_token() }}">
                            <div class="table-responsive">
                              <table class="table table-hover">
                              <tr>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Kadaluarsa</th>
                              </tr>
                                @foreach ($data[$key1]['material-request-detail'] as $key2 => $value2)
                                  <tr>
                                    <td>
                                      <input type="hidden" name="material-request-detail-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2  }}" value="{{$value2->kode_pengadaan_bahan_baku_detil}}">
                                      <input type="text" name="material-request-detail-name-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2  }}" class="input-lengko-default block" placeholder="Nama" value="{{ $value2->nama_bahan_baku }}" />
                                    </td>
                                    <td width="120px">
                                      <input type="number" min="0" name="material-request-detail-count-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2 }}" class="input-lengko-default block" placeholder="Jumlah" value="{{ $value2->jumlah_bahan_baku }}" />
                                    </td>
                                    <td width="180px">
                                      <input type="text" name="material-request-detail-unit-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2  }}" class="input-lengko-default block" placeholder="Satuan terkecil" value="{{ $value2->satuan_bahan_baku }}" />
                                    </td>
                                    <td width="200px">
                                      <input type="text" name="material-request-detail-date-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2 }}" class="input-lengko-default block datepicker" placeholder="Tanggal kadaluarsa" />
                                    </td>
                                  </tr>
                                @endforeach
                              </table>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                *Bahan baku dengan jumlah = 0 dianggap tidak disetujui.
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <input type="hidden" name="material-request-detail-max" value="{{count($data[$key1]['material-request-detail'])}}">
                                <input type="hidden" name="material-request-detail-id" value="{{ $value2->kode_pengadaan_bahan_baku }}" />
                                <button type="button" class="btn-lengko btn-lengko-danger block" onclick="decline_material({{ $value2->kode_pengadaan_bahan_baku }});">Tolak</button>
                              </div>
                              <div class="col-md-6">
                                <button type="submit" class="btn-lengko btn-lengko-success block">Terima</button>
                              </div>
                            </div>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                    </table>
                  </div>

                  <hr />
                </div>
              </div>
              @else
                <div class="row">
                  <div class="col-md-8">
                    <div class="alert alert-warning">
                      Belum ada pengajuan bahan baku dari koki.
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>

      <div class="panel panel-default panel-custom">
        <div class="panel-heading">Manajemen Bahan Baku</div>
        <div class="panel-body">
          @if (count($data['material']) > 0)

          <div class="row">
            <div class="col-md-offset-8 col-md-4">
              <form name="search-material" action="" method="post">
                <div class="input-group">
                  <input type="text" name="material-search-query" class="form-control" placeholder="Cari Bahan Baku" />
                  <input type="hidden" name="material-search-method" value="post">
                  <input type="hidden" name="material-search-token" value="{{ csrf_token() }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                      <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                  </span>
                </div>
              </form>
            </div>
          </div>

          <div id="material-card-section" class="row mrg-t-20 padd-lr-20">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Kadaluarsa</th>
                    <th></th>
                  </tr>
                @foreach ($data['material'] as $key => $value)

                  <form name="" method="post" action="{{ url('dashboard/update/material') }}">
                    <tr id="material-card-change-{{ $value->kode_bahan_baku }}" hidden="hidden">
                      <td>{{ $value->kode_bahan_baku }}</td>
                      <td>
                        <input type="hidden" name="material-id" value="{{$value->kode_bahan_baku}}">
                        <input type="text" name="material-change-name" class="input-lengko-default block" placeholder="Nama Bahan Baku" value="{{ $value->nama_bahan_baku }}" />
                      </td>
                      <td>
                        <input type="number" min="0" name="material-change-stock" class="input-lengko-default block" placeholder="Stok Bahan Baku" value="{{ $value->stok_bahan_baku }}" />
                      </td>
                      <td>
                        <input type="text" name="material-change-unit" class="input-lengko-default block" placeholder="Satuan Bahan Baku" value="{{ $value->satuan_bahan_baku }}" />
                      </td>
                      <td>
                        <input type="text" name="material-change-date" class="input-lengko-default block datepicker" placeholder="Kadaluarsa Bahan Baku" value="{{ $value->tanggal_kadaluarsa_bahan_baku }}" />
                      </td>
                      <td>
                        <button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj('material-card-{{ $value->kode_bahan_baku }}'); hide_obj('material-card-change-{{ $value->kode_bahan_baku }}');">
                          <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                        </button>
                        <button class="btn-lengko btn-lengko-default pull-left" type="submit">
                          <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                        </button>
                        <input type="hidden" name="material-id" value="{{$value->kode_bahan_baku}}" />
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                      </td>
                    </tr>
                  </form>

                  <tr id="material-card-{{ $value->kode_bahan_baku }}">
                    <td>{{ $value->kode_bahan_baku }}</td>
                    <td>{{ $value->nama_bahan_baku }}</td>
                    <td>{{ $value->stok_bahan_baku }}</td>
                    <td>{{ $value->satuan_bahan_baku }}</td>
                    <td>{{ $value->tanggal_kadaluarsa_bahan_baku }}</td>
                    <td>
                      <button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj('material-card-change-{{ $value->kode_bahan_baku }}'); hide_obj('material-card-{{ $value->kode_bahan_baku }}');">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                      </button>
                      <form name="material-delete" action="{{ url('dashboard/delete/material') . '/' . $value->kode_bahan_baku }}" method="POST">
                        <button class="btn-lengko btn-lengko-default" type="submit">
                          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                        <input type="hidden" name="material-delete-id" value="{{$value->kode_bahan_baku}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                      </form>
                    </td>
                  </tr>
                @endforeach
                </table>
              </div>
            </div>
          </div>
          @else
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-warning">
                  Belum ada Bahan Baku, silahkan tambahkan bahan baku.
                </div>
              </div>
            </div>
          @endif

        </div>
      </div>

      <div class="row">
        <div class="col-md-7">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Tambah Bahan Baku</div>
            <div class="panel-body">

              <form name="material-add" class="form-horizontal" action="{{ url('/dashboard/create/material/') }}" method="post">
                <input type="hidden" name="material-create-method" value="post">
                <input type="hidden" name="material-create-token" value="{{ csrf_token() }}">
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Nama</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="material-create-name" class="input-lengko-default block" placeholder="Nama Bahan Baku" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Stok</label>
                  </div>
                  <div class="col-md-4">
                    <input type="number" name="material-create-stock" min="0" class="input-lengko-default block" placeholder="Stok Bahan Baku" />
                  </div>
                  <div class="col-md-5">
                    <input type="text" name="material-create-unit" class="input-lengko-default block" placeholder="Satuan Bahan Baku" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kadaluarsa</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="material-create-date" class="input-lengko-default block datepicker" placeholder="Tanggal Kadaluarsa" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button type="reset" class="btn-lengko btn-lengko-danger">Batalkan</button>
                    <button type="submit" class="btn-lengko btn-lengko-default pull-right">Tambah</button>
                  </div>
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>

    </div>
  </div>


@endsection
