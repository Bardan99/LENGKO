@extends('layouts.dashboard')

@section('title', 'LENGKO - Pegawai')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="panel panel-default panel-custom">
        <div class="panel-heading">Manajemen Pegawai</div>
        <div class="panel-body">
          @if (count($data['employee']) > 0)

          <div class="row">
            <div class="col-md-offset-8 col-md-4">
              <div class="input-group">
                <input type="text" name="" class="form-control" placeholder="Cari Pegawai" />
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                  </button>
                </span>
              </div>
            </div>
          </div>

          <div class="row mrg-t-20 padd-lr-20">
            <table class="table table-hover table-striped">
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Otoritas</th>
              </tr>
            @foreach ($data['employee'] as $key => $value)
              <tr>
                <td>{{ $value->kode_pegawai }}</td>
                <td>{{ $value->nama_pegawai }}</td>
                <td>{{ $value->jenis_kelamin_pegawai }}</td>
                <td>{{ $value->nama_otoritas }}</td>
              </tr>
            @endforeach
            </table>
          </div>
          <div class="row mrg-t-20">
            <div class="col-md-12">
              <nav aria-label="Page navigation" class="text-center">
                <ul class="pagination pagination-lg mrg-tb-0">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    </a>
                  </li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          @endif

        </div>
      </div>

      <div class="row">
        <div class="col-md-6">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Tambah Pegawai</div>
            <div class="panel-body">

              <form class="form-horizontal">
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 15px 5px;">Kode</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="" class="input-lengko-default block" placeholder="Kode Pegawai (Username)" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 15px 5px;">Kata Sandi</label>
                  </div>
                  <div class="col-md-9">
                    <input type="password" name="" class="input-lengko-default block" placeholder="Kata Sandi Pegawai (Password)" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 15px 5px;">Nama</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="" class="input-lengko-default block" placeholder="Nama Pegawai" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 15px 5px;">Jenis Kelamin</label>
                  </div>
                  <div class="col-md-9">
                    <div class="radio-lengko-default">
                      <input type="radio" name="gender" id="gender-male" value="L" /><label for="gender-male">Laki-Laki</label>
                      <input type="radio" name="gender" id="gender-female" value="P" /><label for="gender-female">Perempuan</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 15px 5px;">Otoritas</label>
                  </div>
                  <div class="col-md-9">
                    <select name="" class="select-lengko-default block">
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
              <canvas id="employee-statistic" width="400" height="250"></canvas>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>

@endsection
