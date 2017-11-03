@extends('single')

@section('title', 'LENGKO - Login')

@section('content')
  <div class="row mrg-b-30">
    <div class="col-xs-12 col-sm-push-2 col-sm-8 col-md-push-4 col-md-4">
      <div id="form-login">
        <form method="POST">
          <div class="form-section">
            <a href="/">
              <img class="img-center" src="files/images/logo.png" alt="" width="150px" height="70px" />
            </a>
          </div>
          <div class="form-section">
            <input type="email" id="device-id" placeholder="Perangkat">
          </div>
          <div class="form-section">
            <input type="password" id="device-pw" placeholder="Kode Perangkat">
          </div>
          <div class="form-section">
            <button type="submit" class="block">Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
