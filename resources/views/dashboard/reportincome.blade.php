@extends('layouts.report')

@section('title', 'LENGKO - Laporan Pendapatan')

@push('style')
  <style type="text/css" media="print">
    @page {
        size: landscape;
        margin: 0.1cm;
    }
  </style>
@endpush

@section('content')

  <input type="hidden" name="search_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">

          @if (count($data) > 0)
          <!-- copied here -->
          <div class="row">
            <div class="col-md-12">

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 padd-lr-30">
                  <h1>Laporan Pendapatan LENGKO Resto's</h1>
                  <p>
                    Jl. Sendirian Aja No. 99, Kav. Kawin, Bandung, Jawa Barat <br />
                    Telepon: +(62)222 0000 2017 &nbsp;&nbsp;&nbsp;&nbsp; Fax: +(62)222 1111 2017
                  </p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="seperator"></div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 padd-lr-30 padd-tb-10">
                    Periode: {{$period}}
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="seperator"></div>
                </div>
              </div>

              <div id="report-card-section" class="padd-tb-10">
                <div class="row">
                  <div class="col-md-12">

                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                    <tr>
                      <th class="text-center">Tanggal</th>
                      <th class="text-center">Pendapatan</th>
                    </tr>
                  @php ($total = 0)
                  @for ($i = 0; $i < count($data); $i++)
                    <tr>
                      <td class="text-center">{{$data[$i]->tanggal}}</td>
                      <td class="text-center">{{ $method->num_to_rp($data[$i]->pendapatan)}}</td>
                    </tr>
                    @php ($total += $data[$i]->pendapatan)
                  @endfor
                    <tr>
                      <td class="text-right" style="font-weight:bold;">Total</td>
                      <td class="text-center">{{ $method->num_to_rp($total)}}</td>
                    </tr>
                  </table>
                </div>

                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="seperator"></div>
                    </div>
                  </div>

                  <div class="row mrg-t-20">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      <quote class="parisienne">
                        May all the good people good
                      </quote>
                    </div>
                  </div>


                <!-- copied here -->

              @else
                <div class="row padd-tb-10">
                  <div class="col-md-8">
                    <div class="alert alert-warning">
                      Laporan tidak ditemukan
                    </div>
                  </div>
                </div>
              @endif

            </div>
          </div>

        </div>
      </div> <!-- end -->

    </div>
  </div>

@endsection
