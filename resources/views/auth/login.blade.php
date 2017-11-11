@extends('layouts.single')

@section('title', 'LENGKO - Login')

@section('content')
  <div class="row mrg-b-30">
    <div class="col-xs-12 col-sm-push-2 col-sm-8 col-md-push-4 col-md-4">
      <div id="form-login">
        <form method="POST" action="{{ url('/login') }}">
          <div class="form-section">
            <a href="/">
              <img class="img-center" src="/files/images/logo.png" alt="" width="150px" height="70px" />
            </a>
            {{ csrf_field() }}
          </div>
          <div class="form-section {{ $errors->has('kode_perangkat') ? ' has-error' : '' }}">
            <input type="text" id="device-id" name="kode_perangkat" placeholder="Perangkat" value="{{ old('email') }}">
            @if ($errors->has('kode_perangkat'))
              <span class="help-block">
                <strong>{{ $errors->first('kode_perangkat') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-section {{ $errors->has('kata_sandi_perangkat') ? ' has-error' : '' }}">
            <input type="password" id="device-pw" name="kata_sandi_perangkat" placeholder="Kode Perangkat">
            @if ($errors->has('kata_sandi_perangkat'))
              <span class="help-block">
                <strong>{{ $errors->first('kata_sandi_perangkat') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-section">
            <button type="submit" class="block">Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
