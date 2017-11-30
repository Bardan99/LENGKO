@extends('layouts.dashboard')

@section('title', 'LENGKO - Pegawai')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      <input type="hidden" name="search_token" value="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Pegawai</div>
            <div class="panel-body">
              @if (count($data['employee']) > 0)

              <div class="row">
                <div class="col-md-offset-8 col-md-4">
                  <form name="search-employee" action="" method="post">
                    <div class="input-group">
                      <input type="text" name="employee-search-query" class="form-control" placeholder="Cari Pegawai" />
                      <input type="hidden" name="employee-search-method" value="post">
                      <input type="hidden" name="employee-search-token" value="{{ csrf_token() }}">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                      </span>
                    </div>
                  </form>
                </div>
              </div>

              <div id="employee-card-section" class="row mrg-t-20 padd-lr-20">
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>Jenis Kelamin</th>
                      <th>Otoritas</th>
                      <th></th>
                    </tr>
                  @foreach ($data['employee'] as $key => $value)

                    <form name="" method="post" action="{{ url('dashboard/update/employee') }}">
                      <tr id="employee-card-change-{{ $value->kode_pegawai }}" hidden="hidden">
                        <td>{{ $value->kode_pegawai }}</td>
                        <td>
                          <input type="text" name="employee-change-name" class="input-lengko-default block" placeholder="Nama Pegawai" value="{{ $value->nama_pegawai }}" />
                          <input type="password" name="employee-change-password" class="input-lengko-default block" placeholder="(Kata sandi tidak diubah, kosongkan)" value="" />
                        </td>
                        <td>
                          <div class="radio-lengko-default">
                            <input type="radio" name="employee-change-gender" id="gender-male-{{ $value->kode_pegawai }}" value="L" @if ($value->jenis_kelamin_pegawai == "Laki-Laki") {{'checked="checked" checked'}} @endif />
                              <label for="gender-male-{{ $value->kode_pegawai }}">Laki-Laki</label>
                            <input type="radio" name="employee-change-gender" id="gender-female-{{ $value->kode_pegawai }}" value="P" @if ($value->jenis_kelamin_pegawai == "Perempuan") {{'checked="checked" checked'}} @endif />
                              <label for="gender-female-{{ $value->kode_pegawai }}">Perempuan</label>
                          </div>
                        </td>
                        <td>
                          <select name="employee-change-authority" class="select-lengko-default block">
                            @foreach ($data['authority'] as $key => $value2)
                              <option value="{{ $value2->kode_otoritas }}" @if ($value2->kode_otoritas == $value->kode_otoritas) {{ 'selected' }} @endif>{{ $value2->nama_otoritas }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj('employee-card-{{ $value->kode_pegawai }}'); hide_obj('employee-card-change-{{ $value->kode_pegawai }}');">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                          </button>
                          <button class="btn-lengko btn-lengko-default pull-left" type="submit">
                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                          </button>
                          <input type="hidden" name="employee-id" value="{{$value->kode_pegawai}}" />
                          {{ csrf_field() }}
                          {{ method_field('PUT') }}
                        </td>
                      </tr>
                    </form>

                    <tr id="employee-card-{{ $value->kode_pegawai }}">
                      <td>{{ $value->kode_pegawai }}</td>
                      <td>{{ $value->nama_pegawai }}</td>
                      <td>{{ $value->jenis_kelamin_pegawai }}</td>
                      <td>{{ $value->nama_otoritas }}</td>
                      <td>
                        <button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj('employee-card-change-{{ $value->kode_pegawai }}'); hide_obj('employee-card-{{ $value->kode_pegawai }}');">
                          <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </button>
                        <form name="employee-delete" action="{{ url('dashboard/delete/employee') . '/' . $value->kode_pegawai }}" method="POST">
                          <button class="btn-lengko btn-lengko-default" type="submit">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                          <input type="hidden" name="employee-delete-id" value="{{$value->kode_pegawai}}">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                        </form>
                      </td>
                    </tr>
                  @endforeach
                  </table>
                </div>
              </div>              
              @else
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-warning">
                      Belum ada pegawai, silahkan tambahkan pegawai terlebih dahulu
                    </div>
                  </div>
                </div>
              @endif

            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-md-6">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Tambah Pegawai</div>
            <div class="panel-body">

              <form name="employee-add" class="form-horizontal" action="{{ url('/dashboard/create/employee/') }}" method="post">
                <input type="hidden" name="employee-create-method" value="post">
                <input type="hidden" name="employee-create-token" value="{{ csrf_token() }}">
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kode</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="employee-create-id" class="input-lengko-default block" placeholder="Kode Pegawai (Username)" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kata Sandi</label>
                  </div>
                  <div class="col-md-9">
                    <input type="password" name="employee-create-password" class="input-lengko-default block" placeholder="Kata Sandi Pegawai (Password)" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Nama</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="employee-create-name" class="input-lengko-default block" placeholder="Nama Pegawai" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Jenis Kelamin</label>
                  </div>
                  <div class="col-md-9">
                    <div class="radio-lengko-default">
                      <input type="radio" name="employee-create-gender" id="gender-male" value="L" checked="checked" /><label for="gender-male">Laki-Laki</label>
                      <input type="radio" name="employee-create-gender" id="gender-female" value="P" /><label for="gender-female">Perempuan</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Otoritas</label>
                  </div>
                  <div class="col-md-9">
                    <select name="employee-create-authority" class="select-lengko-default block">
                      @foreach ($data['authority'] as $key => $value)
                        <option value="{{ $value->kode_otoritas }}" @if ($key == 4) {{ 'selected' }} @endif>{{ $value->nama_otoritas }}</option>
                      @endforeach
                    </select>
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
        <div class="col-md-6">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Statistik Pegawai</div>
            <div class="panel-body">
              @if (count($data['employee']) > 0)
                <canvas id="employee-statistic" width="400" height="250"></canvas>
              @else
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-warning">
                      Belum ada pegawai, silahkan tambahkan pegawai terlebih dahulu
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
