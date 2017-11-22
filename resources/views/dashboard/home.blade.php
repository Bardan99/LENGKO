@extends('layouts.dashboard')

@section('title', 'LENGKO - Dasbor')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-8">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Profil</div>
            <div class="panel-body">
              <form id="dash-employee-profile" class="" action="{!! url('/dashboard/update/profile/root') !!}" method="post">
                <div class="row">
                  <div class="col-md-3">
                    <div class="container-file-lengko hov-unblur block">
                      <img class="img-circle img-center" src="{{ url('/files/images/employee/default.png') }}" alt="" width="140px" height="140px" />
                      <input type="file" title="Ubah foto profil" />
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Nama Pengguna</div>
                      <div class="col-md-8"><b>root</b></div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Nama Lengkap</div>
                      <div class="col-md-8">
                        <input type="text" name="employee-name" class="input-lengko-default block" placeholder="Nama Lengkap" value="" />
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Kata Sandi</div>
                      <div class="col-md-8">
                        <input type="password" name="employee-password" class="input-lengko-default block" placeholder="Kata Sandi" value="" />
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Jenis Kelamin</div>
                      <div class="col-md-8">
                        <div class="radio-lengko-default">
                          <input type="radio" name="employee-gender" id="gender-male" value="L" checked="checked" checked /><label for="gender-male">Laki-Laki</label>
                          <input type="radio" name="employee-gender" id="gender-female" value="P" /><label for="gender-female">Perempuan</label>
                        </div>
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Otoritas</div>
                      <div class="col-md-8"><b>Administrator</b></div>
                    </div>
                    <button type="submit" class="btn-lengko btn-lengko-default pull-right">Simpan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>
        <div class="col-md-4">
          <!-- future reserved -->
        </div>
      </div>

    </div>

  </div>

@endsection
