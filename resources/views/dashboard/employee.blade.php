@extends('layouts.dashboard')

@section('title', 'LENGKO - Pegawai')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      <input type="hidden" name="search_token" value="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-12">
          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Pegawai</div>
            <div class="panel-body">
              @if (count($data['employee']) > 0)

              <div class="row">
                <div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6 col-xs-12">
                  <div class="input-group">
                    <input type="text" name="employee-search-query" class="form-control input-lengko-default" placeholder="Cari Pegawai" />
                    <input type="hidden" name="employee-search-method" value="post">
                    <input type="hidden" name="employee-search-token" value="{{ csrf_token() }}">
                    <span class="input-group-btn">
                      <button class="btn btn-default" name="employee-search-button" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div id="employee-card-section" class="row mrg-t-20 padd-lr-20">
                <div id="employee-card-table">
                  @foreach ($data['employee'] as $key => $value)
                    <div class="col-md-3 col-sm-4 col-xs-6">
                      <div class="" onclick="show_obj('employee-card-change-{{ $value->kode_pegawai }}'); hide_obj('employee-card-{{ $value->kode_pegawai }}'); hide_obj('employee-card-table')">
                        <div class="row">
                          <div class="col-md-12">
                            <img class="hoverblur img-circle obj-center" src="/files/images/employee/@if($value->gambar_pegawai){{$value->gambar_pegawai}}@else{{'default.png'}}@endif" alt="{{ $value->kode_pegawai }}" width="150px" height="150px" />
                          </div>
                        </div>
                        <div class="row" style="min-height: 60px;">
                          <div class="col-md-12">
                            <h4 class="text-center">{{ $value->nama_pegawai }}</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>

                <div id="employee-card-editable">
                  @foreach ($data['employee'] as $key => $value)
                    <form id="employee-card-change-{{ $value->kode_pegawai }}" hidden="hidden" name="" method="post" action="{{ url('dashboard/update/employee') }}">
                      <div class="row">
                        <div class="col-md-4 col-sm-4">
                          <img class="img-circle obj-center" src="/files/images/employee/@if($value->gambar_pegawai){{$value->gambar_pegawai}}@else{{'default.png'}}@endif" alt="{{ $value->kode_pegawai }}" width="220px" height="220px" />
                        </div>
                        <div class="col-md-7 col-sm-8">

                          <div class="row">
                            <div class="col-md-12">
                              <h3>Kode Pegawai: <b>{{ $value->kode_pegawai }}</b></h3>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 col-sm-3">
                              <label style="margin: 10px 5px 10px 0px;">Nama</label>
                            </div>
                            <div class="col-md-9 col-sm-9">
                              <input type="text" name="employee-change-name" class="input-lengko-default block" placeholder="Nama Pegawai" value="{{ $value->nama_pegawai }}" />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 col-sm-3">
                              <label style="margin: 10px 5px 10px 0px;">Kata Sandi</label>
                            </div>
                            <div class="col-md-9 col-sm-9">
                              <input type="password" name="employee-change-password" class="input-lengko-default block" placeholder="(Kosongkan jika tidak diubah)" value="" />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 col-sm-3">
                              <label style="margin: 10px 5px 10px 0px;">Jenis Kelamin</label>
                            </div>
                            <div class="col-md-9 col-sm-9">
                              <div class="radio-lengko-default">
                                <input type="radio" name="employee-change-gender" id="gender-male-{{ $value->kode_pegawai }}" value="L" @if ($value->jenis_kelamin_pegawai == "Laki-Laki") {{'checked="checked" checked'}} @endif />
                                  <label for="gender-male-{{ $value->kode_pegawai }}">Laki-Laki</label>
                                <input type="radio" name="employee-change-gender" id="gender-female-{{ $value->kode_pegawai }}" value="P" @if ($value->jenis_kelamin_pegawai == "Perempuan") {{'checked="checked" checked'}} @endif />
                                  <label for="gender-female-{{ $value->kode_pegawai }}">Perempuan</label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 col-sm-3">
                              <label style="margin: 10px 5px 10px 0px;">Otoritas</label>
                            </div>
                            <div class="col-md-9 col-sm-9">
                              <select name="employee-change-authority" class="select-lengko-default block">
                                @foreach ($data['authority'] as $key => $value2)
                                  <option value="{{ $value2->kode_otoritas }}" @if ($value2->kode_otoritas == $value->kode_otoritas) {{ 'selected' }} @endif>{{ $value2->nama_otoritas }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="row mrg-t-20">
                            <div class="col-md-12">
                              <button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj('employee-card-{{ $value->kode_pegawai }}'); hide_obj('employee-card-change-{{ $value->kode_pegawai }}'); show_obj('employee-card-table');">
                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Kembali
                              </button>
                              <button class="btn-lengko btn-lengko-default pull-right" type="submit">
                                Simpan <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                              </button>
                              <button class="btn-lengko btn-lengko-danger pull-right" type="button" onclick="delete_employee('{{$value->kode_pegawai}}');">
                                Hapus <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </button>
                              <input type="hidden" name="employee-id" value="{{$value->kode_pegawai}}" />
                              {{ csrf_field() }}
                              {{ method_field('PUT') }}
                            </div>
                          </div>

                        </div>
                      </div>
                    </form>
                  @endforeach
                </div>
              </div>
              @else
                <div class="row">
                  <div class="col-md-8">
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
        <div class="col-md-6 col-sm-8">

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
                    <button type="reset" class="btn-lengko btn-lengko-danger">
                      <i class="material-icons md-18">undo</i> Batalkan
                    </button>
                    <button type="submit" class="btn-lengko btn-lengko-default pull-right">
                      <i class="material-icons md-18">person_add</i> Tambah
                    </button>
                  </div>
                </div>
              </form>

            </div>
          </div>

        </div>
        <div class="col-md-6 col-sm-8">

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
