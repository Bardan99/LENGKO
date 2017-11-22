@extends('layouts.single')

@section('title', 'LENGKO - Login')

@section('content')
  <div class="row mrg-b-30">
    <div class="col-xs-12 col-sm-push-2 col-sm-8 col-md-push-4 col-md-4">
      <div id="form-login">
        <form method="POST" action="{{ url('/dashboard/login') }}">
          <div class="form-section mrg-b-20">
            <a href="/">
              <img class="img-center" src="{{ url('/files/images/lengko-logo.png') }}" alt="" width="150px" height="70px" />
            </a>
            {{ csrf_field() }}
          </div>
          <div class="form-section {{ $errors->has('kode_pegawai') ? ' has-error' : '' }}">
            <input type="text" id="device-id" name="kode_pegawai" placeholder="Kode Pegawai" value="{{ old('email') }}">
            @if ($errors->has('kode_pegawai'))
              <span class="help-block">
                <strong>{{ $errors->first('kode_pegawai') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-section {{ $errors->has('kata_sandi_pegawai') ? ' has-error' : '' }}">
            <input type="password" id="device-pw" name="kata_sandi_pegawai" placeholder="Kata Sandi Pegawai">
            @if ($errors->has('kata_sandi_pegawai'))
              <span class="help-block">
                <strong>{{ $errors->first('kata_sandi_pegawai') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-section">
            <button type="submit" class="btn-lengko btn-lengko-default block">Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
