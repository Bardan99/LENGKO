@extends('layouts.dashboard')

@section('title', 'LENGKO - Laporan')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      <input type="hidden" name="search_token" value="{{ csrf_token() }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Statistik Pendapatan</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-9 padd-tb-10">
                  <h4 class="text-center">Pendapatan 7 Hari Terakhir</h4>
                  <canvas id="report-transaction" width="400" height="160"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Laporan Pendapatan</div>
            <div class="panel-body">

              <div class="row">
                <div class="col-md-12 padd-tb-10">
                  <div class="row">
                    <div class="col-md-4 col-sm-4">
                      <label>Jenis Laporan</label>
                      <select name="report-type" class="select-lengko-default block">
                        <option value="daily">Harian ({{date('Y-m-d')}})</option>
                        <option value="weekly">Mingguan ({{date('Y-m-d', strtotime('-7 days')) . ' s.d. ' . date('Y-m-d')}})</option>
                        <option value="monthly">Bulanan ({{date('Y-m-d', strtotime('-30 days')) . ' s.d. ' . date('Y-m-d')}})</option>
                        <option value="yearly">Tahunan ({{date('Y-m-d', strtotime('-365 days')) . ' s.d. ' . date('Y-m-d')}})</option>
                      </select>
                    </div>
                    <div class="col-md-5 col-sm-5">
                      <label>Rentang Waktu</label>
                      <div class="row">
                        <div class="col-md-12 col-sm-12">
                          <div class="input-group input-group-sm">
                            <input type="text" name="report-date-start" class="input-lengko-box block form-control datepicker" style="height:45px;" aria-describedby="basic-addon1" placeholder="Tanggal Awal" />
                            <span class="input-group-addon" id="basic-addon1" style="border: 0px; padding: 2px 10px; height: 45px;">
                              s.d.
                            </span>
                            <input type="text" name="report-date-end" class="input-lengko-box block form-control datepicker" style="height:45px;" aria-describedby="basic-addon1" placeholder="Tanggal Akhir" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-3 text-left">
                      <label>&nbsp; </label>
                      <div class="row">
                        <div class="col-md-12 col-sm-12">
                          <div class="btn-group" role="group" aria-label="...">
                            <button type="button" name="report-search-button" class="btn-lengko btn-lengko-default">
                              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                              Lihat
                            </button>
                            <button type="button" name="report-print-button" class="btn-lengko btn-lengko-warning">
                              <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              Cetak
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <hr />
                  <div id="report-card-section"></div>
                  <div id="report-card-print-section"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection
