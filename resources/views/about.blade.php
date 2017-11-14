@extends('layouts.main')

@section('title', 'LENGKO - Boy Band')

@section('content')

  <div id="members" class="row mrg-b-30">
    <div class="col-md-12">

      <div class="row mrg-b-30">
        <div class="col-md-12">
          <img src="/files/images/members/rakasw.png" class="img-circle img-center" alt="Raka Suryaardi Widjaja" width="90px" height="100px" />
          <h2 class="menu-title text-center">
              Raka Suryaardi Widjaja<br />
              <small>All in One</small>
            </h2>
          <div class="row">
            <div class="col-md-offset-2 col-md-8 text-center">
              <quote class="playfair">
                Saya memang miskin dan bodoh;<br />
                Tetapi saya tidak berencana untuk<br />
                miskin dan bodoh selamanya.<br />
                <small>Raka S.W (2017)</small>
              </quote>
            </div>
          </div>
        </div>
      </div>

      <div class="row mrg-b-30">
        <div class="col-md-2 col-sm-2 text-left">
          <img src="/files/images/members/rakamp.png" class="img-circle img-center" alt="Raka Muhamad Pratama" width="90px" height="100px" />
        </div>
        <div class="col-md-4 col-sm-4">
          <h2 class="menu-title text-left">
              Raka Muhamad Pratama<br />
              <small>Front-end Designer</small>
            </h2>
          <quote class="playfair">
            Kenyataan ada di depan
            <br />
            <small>Raka ci ganteng kalem (2017)</small>
          </quote>
        </div>

        <div class="col-md-4 col-sm-4 text-right">
          <h2 class="menu-title text-right">
              Binsar Bernandus Silalahi<br />
              <small>Front-end Designer</small>
            </h2>
          <quote class="playfair">
            All is well
            <br />
            <small>Binsar kerja di pt mencari cinta sejati (2017)</small>
          </quote>
        </div>
        <div class="col-md-2 col-sm-2">
          <img src="/files/images/members/binsar.png" class="img-circle img-center" alt="Binsar Bernandus Silalahi" width="90px" height="100px" />
        </div>
      </div>

      <div class="row mrg-btm-30">
        <div class="col-md-4 col-sm-4 text-right">
          <h2 class="menu-title text-right">
              Azmi Yudista<br />
              <small>Graphical Designer</small>
            </h2>
          <quote class="playfair">
            Kegagalan bukti perjuangan
            <br />
            <small>Azmi muedtz abiez (2017)</small>
          </quote>
        </div>
        <div class="col-md-2 col-sm-2">
          <img src="/files/images/members/azmi.png" class="img-circle img-center" alt="Azmi Yudista" width="90px" height="100px" />
        </div>

        <div class="col-md-2 col-sm-2 text-left">
          <img src="/files/images/members/zaki.png" class="img-circle img-center" alt="Binsar Bernandus Silalahi" width="90px" height="100px" />
        </div>
        <div class="col-md-4 col-sm-40">
          <h2 class="menu-title text-left">
              Muhammad Zaki<br />
              <small>Quality Assurance</small>
            </h2>
          <quote class="playfair">
            Aku pengen pindah ke Meikarta
            <br />
            <small>Zaki muach muach (2017)</small>
          </quote>
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
