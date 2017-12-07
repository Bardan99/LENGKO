@extends('layouts.dashboard')

@section('title', 'LENGKO - Laporan')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      <input type="hidden" name="search_token" value="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Laporan Pendapatan</div>
            <div class="panel-body">
              <div class="row padd-lr-10">
                <div class="col-md-4 padd-tb-10">

                  <div class="row">
                    <div class="col-md-12">
                      <h4 class="text-center">Laporan Pendapatan</h4>
                      <select name="report-type" class="select-lengko-default block">
                        <option value="daily">Harian ({{date('Y-m-d')}})</option>
                        <option value="weekly">Mingguan ({{date('Y-m-d', strtotime('-7 days')) . ' s.d. ' . date('Y-m-d')}})</option>
                        <option value="monthly">Bulanan ({{date('Y-m-d', strtotime('-30 days')) . ' s.d. ' . date('Y-m-d')}})</option>
                        <option value="yearly">Tahunan ({{date('Y-m-d', strtotime('-365 days')) . ' s.d. ' . date('Y-m-d')}})</option>
                      </select>
                      <fieldset class="title">
                          <legend>atau</legend>
                      </fieldset>
                    </div>
                  </div>
                  <div class="row mrg-b-10">
                    <div class="col-md-6">
                      <input type="text" name="report-date-start" class="input-lengko-default block datepicker" placeholder="Tanggal Awal" />
                    </div>
                    <div class="col-md-6">
                      <input type="text" name="report-date-end" class="input-lengko-default block datepicker" placeholder="Tanggal Akhir" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="button" name="report-search-button" class="btn-lengko btn-lengko-default block">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        Lihat
                      </button>
                    </div>
                  </div>

                </div>
                <div class="col-md-8">
                  <h4 class="text-center">Pendapatan 7 Hari Terakhir</h4>
                  <canvas id="report-transaction" width="400" height="160"></canvas>
                </div>
              </div>

              <div class="row mrg-t-20">
                <div id="report-card-section" class="col-md-6">

                </div>
                <div class="col-md-5">
                  <!-- future update -->
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection
