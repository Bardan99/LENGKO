@extends('layouts.main')

@section('title', 'LENGKO - Boy Band')

@section('content')
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div id="members" class="row mrg-b-30">
    <div class="col-md-12">

      <div class="row mrg-b-30">
        <div class="col-md-12">
          <img src="{{ url('/files/images/members/rakasw.png') }}" class="img-circle img-center" alt="Raka Suryaardi Widjaja" width="90px" height="100px" />
          <h3 class="text-center">
              Raka Suryaardi Widjaja<br />
              <small>All in One Driver Pack</small>
          </h3>
          <div class="row">
            <div class="col-md-offset-2 col-md-8 text-center">
              <quote class="playfair">
                Saya memang miskin dan bodoh; Tetapi saya <br />
                tidak berencana untuk miskin dan bodoh selamanya.<br />
                <small>(2017)</small>
              </quote>
            </div>
          </div>
        </div>
      </div>

      <div class="row mrg-b-30">
        <div class="col-md-6">
          <img src="{{ url('/files/images/members/rakamp.png') }}" class="img-circle img-center" alt="Raka Suryaardi Widjaja" width="90px" height="100px" />
          <h3 class="text-center">
            Raka Muhamad Pratama<br />
            <small>Front-end Designer</small>
          </h3>
          <div class="row">
            <div class="col-md-offset-2 col-md-8 text-center">
              <quote class="playfair">
                Kenyataan ada di depan
                <br />
                <small>Raka ci ganteng kalem (2017)</small>
              </quote>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <img src="{{ url('/files/images/members/binsar.png') }}" class="img-circle img-center" alt="Raka Suryaardi Widjaja" width="90px" height="100px" />
          <h3 class="text-center">
            Binsar Bernandus Silalahi<br />
            <small>Front-end Designer</small>
          </h3>
          <div class="row">
            <div class="col-md-offset-2 col-md-8 text-center">
              <quote class="playfair">
                All is well
                <br />
                <small>Binsar kerja di pt mencari cinta sejati (2017)</small>
              </quote>
            </div>
          </div>
        </div>
      </div>

      <div class="row mrg-b-30">
        <div class="col-md-offset-2 col-md-4">
          <img src="{{ url('/files/images/members/azmi.png') }}" class="img-circle img-center" alt="Raka Suryaardi Widjaja" width="90px" height="100px" />
          <h3 class="text-center">
            Azmi Yudista<br />
            <small>Graphical Designer</small>
          </h3>
          <div class="row">
            <div class="col-md-offset-2 col-md-8 text-center">
              <quote class="playfair">
                Kegagalan bukti perjuangan
                <br />
                <small>Azmi muedtz abiez (2017)</small>
              </quote>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <img src="{{ url('/files/images/members/zaki.png') }}" class="img-circle img-center" alt="Raka Suryaardi Widjaja" width="90px" height="100px" />
          <h3 class="text-center">
            Muhammad Zaki<br />
            <small>Quality Assurance</small>
          </h3>
          <div class="row">
            <div class="col-md-offset-2 col-md-8 text-center">
              <quote class="playfair">
                Aku pengen pindah ke Meikarta
                <br />
                <small>Zaki muach muach (2017)</small>
              </quote>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection

@section('footer-section')
  @include('addition')
  @yield('footer-quote')
  @yield('footer-content')
  @yield('footer-copyright')
@endsection
