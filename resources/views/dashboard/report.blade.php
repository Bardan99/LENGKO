@extends('layouts.dashboard')

@section('title', 'LENGKO - Laporan')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Statistik Pendapatan</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-10">
                  <canvas id="report-income-yearly" width="400" height="130"></canvas>
                </div>
                <div class="col-md-2">
                  <label>Statistik</label>
                  <br />Min: Rp100.352.000
                  <br />Max: Rp164.832.000
                  <br />Avg: Rp135.223.432
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Laporan Transaksi Penjualan</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <select name="" class="select-lengko-default block">
                        @foreach ($data['report-type'] as $key => $value)
                          <option value="{{ $value->kode_jenis_laporan }}">{{ $value->nama_jenis_laporan }}</option>
                        @endforeach
                      </select>
                      <fieldset class="title">
                          <legend>atau</legend>
                      </fieldset>
                    </div>
                  </div>
                  <div class="row mrg-b-10">
                    <div class="col-md-6">
                      <input type="text" name="" class="input-lengko-default block datepicker" placeholder="Tanggal Awal" />
                    </div>
                    <div class="col-md-6">
                      <input type="text" name="" class="input-lengko-default block datepicker" placeholder="Tanggal Akhir" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <button type="button" class="btn-lengko btn-lengko-warning block">Cetak</button>
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="btn-lengko btn-lengko-default block">Lihat</button>
                    </div>
                  </div>

                </div>
                <div class="col-md-8">
                  <canvas id="report-transaction" width="400" height="160"></canvas>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <!-- future reserved -->
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection
