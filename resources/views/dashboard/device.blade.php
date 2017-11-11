@extends('layouts.dashboard')

@section('title', 'LENGKO - Perangkat')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Perangkat</div>
            <div class="panel-body">
              @if (count($data['device']) > 0)

              <div class="row">
                <div class="col-md-offset-8 col-md-4">
                  <div class="input-group">
                    <input type="text" name="" class="form-control" placeholder="Cari Perangkat" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row mrg-t-20">
              @foreach ($data['device'] as $key => $value)
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="device device-{{ $value->status_text }}">
                    <div class="device-title">{{ $value->nama_perangkat }}</div>
                    <span>({{$value->kode_perangkat }})</span>
                    <hr />
                    <div class="">
                      Kapasitas: {{ $value->jumlah_kursi_perangkat }} Orang<br />
                      Status: {{ $value->status_text }}
                    </div>
                  </div>
                </div>
              @endforeach
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
              <div class="row mrg-t-20">
                <div class="col-md-12">
                  <strong>*Keterangan:</strong>
                  <small>
                    <b>available</b>: Tidak sedang digunakan,
                    <b>unavailable</b>: Sedang digunakan,
                    <b>disabled</b>: Tidak diketahui
                  </small>
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
            <div class="panel-heading">Tambah Perangkat</div>
            <div class="panel-body">

              <form class="form-horizontal">
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kode</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="" class="input-lengko-default block" placeholder="Kode Perangkat" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Nama</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="" class="input-lengko-default block" placeholder="Nama Perangkat" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kata Sandi</label>
                  </div>
                  <div class="col-md-9">
                    <input type="password" name="" class="input-lengko-default block" placeholder="Kata Sandi Perangkat" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kursi</label>
                  </div>
                  <div class="col-md-9">
                    <input type="number" name="" min="1" class="input-lengko-default block" placeholder="Jumlah Kursi" />
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
            <div class="panel-heading">Statistik Perangkat</div>
            <div class="panel-body">
              <canvas id="device-statistic" width="400" height="250"></canvas>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>

@endsection
