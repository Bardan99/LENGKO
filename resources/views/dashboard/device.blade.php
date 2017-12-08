@extends('layouts.dashboard')

@section('title', 'LENGKO - Perangkat')

@section('content')

  <div id="device-section" class="row mrg-b-20">
    <div class="col-md-12">

      <input type="hidden" name="search_token" value="{{ csrf_token() }}">

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Perangkat</div>
            <div class="panel-body">
              @if (count($data['device']) > 0)

              <div class="row">
                <div class="col-md-offset-8 col-md-4">
                  <div class="input-group">
                    <input type="text" name="device-search-query" class="form-control" placeholder="Cari Perangkat" />
                    <input type="hidden" name="device-search-method" value="post">
                    <input type="hidden" name="device-search-token" value="{{ csrf_token() }}">
                    <span class="input-group-btn">
                      <button class="btn btn-default" name="device-search-button" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div id="device-card-section" class="row mrg-t-20">
              @foreach ($data['device'] as $key => $value)
                @if ($auth == 'root')
                <form id="device-card-change-{{$value->kode_perangkat}}" action="{{ url('dashboard/update/device') }}" method="POST" hidden="hidden">
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="device device-{{ $value->status_text }}">
                      <div class="device-title row">
                        <div class="col-md-12">
                          <input type="text" name="device-change-name" class="input-lengko-default block" value="{{ $value->nama_perangkat }}" />
                        </div>
                      </div>
                      <span>({{$value->kode_perangkat }})</span>
                      <div class="row">
                        <div class="col-md-12">
                          Kapasitas: <input type="number" name="device-change-chair" min="1" class="input-lengko-default" value="{{ $value->jumlah_kursi_perangkat }}" /> Orang<br />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          Status:
                          <select name="device-change-status" class="select-lengko-default">
                            @foreach ($data['status'] as $key2 => $value2)
                              <option value="{{ $value2->status }}" @if ($value2->status == $value->status_perangkat) {{ 'selected' }} @endif>
                                {{$value2->text}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          Kata sandi:
                          <input type="password" name="device-change-password" class="input-lengko-default block" placeholder="(tidak diubah, kosongkan)" />
                          <hr />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-xs-6">
                          <form action="{{ url('dashboard/delete/device') . '/' . $value->kode_perangkat }}" method="POST">
                            <button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj('device-card-{{ $value->kode_perangkat }}'); hide_obj('device-card-change-{{ $value->kode_perangkat }}');">
                              <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                            </button>
                            <button class="btn-lengko btn-lengko-default" type="submit">
                              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          </form>
                        </div>
                        <div class="col-md-6 col-xs-6">
                          <button class="btn-lengko btn-lengko-default pull-right" type="submit">
                            <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                          </button>
                          <input type="hidden" name="device-id" value="{{$value->kode_perangkat}}" />
                          {{ csrf_field() }}
                          {{ method_field('PUT') }}
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                @endif
                <div id="device-card-{{ $value->kode_perangkat }}" class="col-md-3 col-sm-6 col-xs-12">
                  <div class="device device-{{ $value->status_text }}">
                    <div class="device-title row">
                      <div class="col-md-12">
                        {{ $value->nama_perangkat }}
                      </div>
                    </div>
                    <span>({{$value->kode_perangkat }})</span>
                    <div class="row">
                      <div class="col-md-12">
                        <hr />
                        Kapasitas: {{ $value->jumlah_kursi_perangkat }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        Status: {{$value->status_text_human}}
                        <hr />
                      </div>
                    </div>
                    @if ($auth == 'root')
                    <div class="row">
                      <div class="col-md-6 col-xs-6">
                        <form action="{{ url('dashboard/delete/device') . '/' . $value->kode_perangkat }}" method="POST">
                          <button class="btn-lengko btn-lengko-default pull-left" type="submit">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                        </form>
                      </div>
                      <div class="col-md-6 col-xs-6">
                        <button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="show_obj('device-card-change-{{$value->kode_perangkat}}'); hide_obj('device-card-{{ $value->kode_perangkat }}');">
                          <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </button>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              @endforeach
              </div>
              @else
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-warning">
                      Perangkat belum tersedia, silahkan tambahkan perangkat terlebih dahulu
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        @if ($auth == 'root')
        <div class="col-md-6">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Tambah Perangkat</div>
            <div class="panel-body">
              <form id="device-add" class="form-horizontal" action="{{ url('/dashboard/create/device/') }}" method="post">
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kode</label>
                  </div>
                  <div class="col-md-9">
                    <input type="hidden" name="device-create-method" value="post">
                    <input type="hidden" name="device-create-token" value="{{ csrf_token() }}">
                    <input type="text" name="device-create-id" class="input-lengko-default block" placeholder="Kode Perangkat" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Nama</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="device-create-name" class="input-lengko-default block" placeholder="Nama Perangkat" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kata Sandi</label>
                  </div>
                  <div class="col-md-9">
                    <input type="password" name="device-create-password" class="input-lengko-default block" placeholder="Kata Sandi Perangkat" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kursi</label>
                  </div>
                  <div class="col-md-9">
                    <input type="number" name="device-create-chair" min="1" class="input-lengko-default block" placeholder="Jumlah Kursi" />
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
        @endif
        <div class="col-md-6">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Statistik Perangkat</div>
            <div class="panel-body">
              @if (count($data['device']) > 0)
                <canvas id="device-statistic" width="400" height="250"></canvas>
              @else
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-warning">
                      Perangkat belum tersedia, silahkan tambahkan perangkat terlebih dahulu
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>

@endsection
