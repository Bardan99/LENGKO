@extends('layouts.dashboard')

@section('title', 'LENGKO - Bahan Baku')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      @if ($auth == 'root' || $auth == 'chef')
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
              <div class="row mrg-tb-20">
                <div class="col-md-12">
                  @if (count($data['material-request-user']) > 0)
                    <!-- copied here -->
                    <div class="row">
                      <div class="col-md-12">

                        <div id="request-material-card-section" class="padd-tb-10">
                          <div class="row padd-lr-15 open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Klik untuk melihat detil pengajuan">

                            <div class="col-md-3 col-sm-3 col-xs-6">
                              <i class="material-icons md-18">arrow_drop_down</i>
                              <label>Subjek</label>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                              <label>Waktu</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                              <label>Prioritas</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                              <label>Status</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <label>Keterangan</label>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="seperator"></div>
                            </div>
                          </div>

                          @foreach ($data['material-request-user'] as $key1 => $value)
                            <div onclick="show_obj('material-request-user-{{ $key1 }}');" class="row cursor-pointer padd-tb-10 padd-lr-15">
                              <div class="col-md-3 col-sm-3 col-xs-6">
                                #{{ $value->kode_pengadaan_bahan_baku }} [{{ $value->subjek_pengadaan_bahan_baku }}]
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-6">
                                {{ $value->tanggal_pengadaan_bahan_baku . ' ' . $value->waktu_pengadaan_bahan_baku }}
                              </div>
                              <div class="col-md-2 col-sm-2 col-xs-6">
                                {{ $value->nama_prioritas }}
                              </div>
                              <div class="col-md-2 col-sm-2 col-xs-6">
                                {{ $data['method']->rewrite('status-number', $value->status_pengadaan_bahan_baku) }}
                              </div>
                              <div class="col-md-2 col-sm-2 col-xs-12">
                                {{ $data['method']->rewrite('status', $value->catatan_pengadaan_bahan_baku) }}
                              </div>
                            </div>
                            @if (count($data[$key1]['material-request-user-detail']) > 0)
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div id="material-request-user-{{ $key1 }}" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">
                                    <table class="table table-hover table-striped stackable">
                                      <tr><th>Bahan Baku</th></tr>
                                      @foreach ($data[$key1]['material-request-user-detail'] as $key2 => $value2)
                                        <tr><td>{{ $value2->nama_bahan_baku }}</td></tr>
                                      @endforeach
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
                          @endforeach

                        </div>
                      <hr />
                      </div>
                    </div>
                    <!-- copied here -->
                  @endif

                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <form name="material-request-add" class="form-horizontal" action="{{url('/dashboard/create/request')}}" method="post">
                    <div class="row">
                      <div class="col-md-2 col-sm-2">
                        <label style="margin: 10px 5px 10px 0px;">Subjek</label>
                      </div>
                      <div class="col-md-5 col-sm-5">
                        <input type="text" name="material-request-create-subject" class="input-lengko-default block" placeholder="Subjek Pengadaan Bahan Baku" />
                      </div>
                      <div class="col-md-2 col-sm-2">
                        <label style="margin: 10px 5px 10px 0px;">Prioritas</label>
                      </div>
                      <div class="col-md-3 col-sm-3">
                        <select name="material-request-create-priority" class="select-lengko-default block">
                          @foreach ($data['priority'] as $key => $value)
                            <option value="{{ $value->kode_prioritas }}">{{ $value->nama_prioritas }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2 col-sm-2 col-xs-12">
                        <label style="margin: 10px 5px 10px 0px;">Nama</label>
                      </div>
                      <div class="col-md-6 col-sm-5 col-xs-7">
                        <input type="text" id="material-request-create-item-0" name="material-request-create-item-0" class="input-lengko-default block" placeholder="Nama Bahan Baku" />
                      </div>
                      <div class="col-md-4 col-sm-5 col-xs-5">
                        <select id="material-list-0" name="" class="select2" onchange="add_val('material-list-0', 'material-request-create-item-0');">
                          @if (count($data['material']) > 0)
                            @foreach ($data['material'] as $key => $value)
                              <option value="{{ $value->kode_bahan_baku }}">{{ $value->nama_bahan_baku }}</option>
                            @endforeach
                          @else
                            <option value="">Tidak tersedia</option>
                          @endif
                        </select>
                      </div>
                    </div>

                    <div id="material-list-request">
                      <!-- using jquery dom append to add above item below -->
                    </div>

                    <div class="row">
                      <div class="col-md-offset-2 col-md-10 open-tooltip" data-placement="top" data-toggle="tooltip" title="Tambah bahan baku lainnya">
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
                        <button type="submit" class="btn-lengko btn-lengko-default pull-right">Kirim Pengajuan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
      @endif
      @if ($auth == 'root' || $auth == 'pantry')
      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Pengadaan Bahan Baku</div>
            <div class="panel-body">
              @if (count($data['material-request']) > 0)
                <!-- copied here -->
                <div class="row">
                  <div class="col-md-12">

                    <div id="confirm-material-card-section" class="padd-tb-10">
                      <div class="row padd-lr-15 open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Klik untuk melihat detil pengajuan">

                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <i class="material-icons md-18">arrow_drop_down</i>
                          <label>Subjek</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <label>Waktu</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                          <label>Prioritas</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                          <label>Status</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <label>Keterangan</label>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="seperator"></div>
                        </div>
                      </div>

                      @foreach ($data['material-request'] as $key1 => $value)
                        <div onclick="show_obj('material-request-{{ $key1 }}');" class="row cursor-pointer padd-tb-10 padd-lr-15">
                          <div class="col-md-3 col-sm-3 col-xs-6">
                            #{{ $value->kode_pengadaan_bahan_baku }} [{{ $value->subjek_pengadaan_bahan_baku }}]
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-6">
                            {{ $value->tanggal_pengadaan_bahan_baku . ' ' . $value->waktu_pengadaan_bahan_baku }}
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-6">
                            {{ $value->nama_prioritas }}
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-6">
                            {{ $data['method']->rewrite('status-number', $value->status_pengadaan_bahan_baku) }}
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-12">
                            {{ $data['method']->rewrite('status', $value->catatan_pengadaan_bahan_baku) }}
                          </div>
                        </div>
                        @if (count($data[$key1]['material-request-detail']) > 0)
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div id="material-request-{{ $key1 }}" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">
                                <table class="table table-hover table-striped">
                                  <tr>
                                    <th>#Detil</th>
                                    <th>Bahan Baku</th>
                                    <th>Kadaluarsa</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                  </tr>
                                  @foreach ($data[$key1]['material-request-detail'] as $key2 => $value2)
                                    <tr>
                                      <td>#{{$value2->kode_pengadaan_bahan_baku_detil}}</td>
                                      <td>
                                        <input type="hidden" name="material-request-detail-id-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2  }}" value="{{$value2->kode_pengadaan_bahan_baku_detil}}">
                                        <input type="text" name="material-request-detail-name-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2  }}" class="input-lengko-default block" placeholder="Nama" value="{{ $value2->nama_bahan_baku }}" />
                                      </td>
                                      <td>
                                        <input type="text" name="material-request-detail-date-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2 }}" class="input-lengko-default block datepicker" placeholder="Tanggal kadaluarsa" />
                                      </td>
                                      <td>
                                        <input type="number" min="0" name="material-request-detail-count-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2 }}" class="input-lengko-default block" placeholder="Jumlah" value="{{ $value2->jumlah_bahan_baku }}" />
                                      </td>
                                      <td>
                                        <input type="text" name="material-request-detail-unit-{{ $value2->kode_pengadaan_bahan_baku . '-' . $key2  }}" class="input-lengko-default block" placeholder="Satuan terkecil" value="{{ $value2->satuan_bahan_baku }}" />
                                      </td>
                                    </tr>
                                  @endforeach
                                </table>
                                <div class="row">
                                  <div class="col-md-12">
                                    *Bahan baku dengan jumlah = 0 dianggap tidak disetujui.
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6 col-sm-6 padd-tb-10">
                                    <input type="hidden" name="material-request-detail-max-{{ $value2->kode_pengadaan_bahan_baku }}" value="{{count($data[$key1]['material-request-detail'])}}">
                                    <button type="button" class="btn-lengko btn-lengko-danger block" onclick="decline_material({{ $value->kode_pengadaan_bahan_baku }});">Tolak</button>
                                  </div>
                                  <div class="col-md-6 col-sm-6 padd-tb-10">
                                    <button type="button" class="btn-lengko btn-lengko-success block" onclick="confirm_material({{ $value->kode_pengadaan_bahan_baku }});">Terima</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="seperator"></div>
                          </div>
                        </div>
                      @endforeach

                    </div>
                  <hr />
                  </div>
                </div>
                <!-- copied here -->

              @else
                <div class="row">
                  <div class="col-md-8">
                    <div class="alert alert-warning">
                      Belum ada pengajuan bahan baku.
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
            <div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <input type="text" name="material-search-query" class="form-control input-lengko-default" placeholder="Cari Bahan Baku" />
                <input type="hidden" name="material-search-method" value="post">
                <input type="hidden" name="material-search-token" value="{{ csrf_token() }}">
                <span class="input-group-btn">
                  <button class="btn btn-default" name="material-search-button" type="button">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                  </button>
                </span>
              </div>
            </div>
          </div>

          <div id="material-card-section" class="row mrg-t-20">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="material-management" class="table table-hover table-striped">
                  <tr>
                    <th>Bahan Baku</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Kadaluarsa</th>
                    <th></th>
                  </tr>
                @foreach ($data['material'] as $key => $value)
                  <tr id="material-card-{{ $value->kode_bahan_baku }}">
                    <td>#{{ $value->kode_bahan_baku }} ({{ $value->nama_bahan_baku }})</td>
                    <td>{{ $value->stok_bahan_baku }}</td>
                    <td>{{ $value->satuan_bahan_baku }}</td>
                    <td width="150px">{{ $value->tanggal_kadaluarsa_bahan_baku }}</td>
                    <td width="100px">
                      <form name="material-delete" action="{{ url('dashboard/delete/material') . '/' . $value->kode_bahan_baku }}" method="POST">
                        <button class="btn-lengko btn-lengko-default pull-right" type="submit">
                          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                        <input type="hidden" name="material-delete-id" value="{{$value->kode_bahan_baku}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                      </form>
                      <a href="{{ url('/dashboard/material/change/' . $value->kode_bahan_baku) }}">
                        <button class="btn-lengko btn-lengko-default pull-right" type="button">
                          <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </button>
                      </a>

                    </td>
                  </tr>
                @endforeach
                </table>
              </div>


            </div>
          </div>
          @else
            <div class="row">
              <div class="col-md-8">
                <div class="alert alert-warning">
                  Belum ada Bahan Baku, silahkan tambahkan bahan baku.
                </div>
              </div>
            </div>
          @endif

        </div>
      </div>

      <div class="row">
        <div class="col-md-6 col-sm-8">

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
                  <div class="col-md-4 col-sm-6">
                    <input type="number" name="material-create-stock" min="0" class="input-lengko-default block" placeholder="Stok Bahan Baku" />
                  </div>
                  <div class="col-md-5 col-sm-6">
                    <input type="text" name="material-create-unit" class="input-lengko-default block" placeholder="Satuan Bahan Baku" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kadaluarsa</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="material-create-date" class="input-lengko-default block datepicker" placeholder="Tanggal Kadaluarsa Bahan Baku" />
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
      @endif
    </div>
  </div>


@endsection
