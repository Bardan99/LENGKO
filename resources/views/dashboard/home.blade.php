@extends('layouts.dashboard')

@section('title', 'LENGKO - Dasbor')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-7">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Profil Pengguna</div>
            <div class="panel-body">

              <div class="row">
                <div class="col-md-4">
                  <div class="container-file-lengko hov-unblur block">
                    <img class="img-circle img-center" src="/files/images/employee/default.png" alt="" width="140px" height="140px" />
                    <input type="file" title="Ubah foto profil" />
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="row mrg-b-10">
                    <div class="col-md-5">Nama Pengguna</div>
                    <div class="col-md-7"><b>root</b></div>
                  </div>
                  <div class="row mrg-b-10">
                    <div class="col-md-5">Nama Lengkap</div>
                    <div class="col-md-7">
                      <input type="text" name="" class="input-lengko-default block" placeholder="Nama Lengkap" value="Raka Suryaardi Widjaja" />
                    </div>
                  </div>
                  <div class="row mrg-b-10">
                    <div class="col-md-5">Jenis Kelamin</div>
                    <div class="col-md-7">
                      <div class="radio-lengko-default">
                        <input type="radio" name="gender" id="gender-male" value="L" checked="checked" checked /><label for="gender-male">Laki-Laki</label>
                        <input type="radio" name="gender" id="gender-female" value="P" /><label for="gender-female">Perempuan</label>
                      </div>
                    </div>
                  </div>
                  <div class="row mrg-b-10">
                    <div class="col-md-5">Otoritas</div>
                    <div class="col-md-7"><b>Administrator</b></div>
                  </div>
                  <button type="button" class="btn-lengko btn-lengko-default pull-right">Simpan</button>
                </div>
              </div>

            </div>
          </div>

        </div>
        <div class="col-md-5">
          <!-- future reserved -->
        </div>
      </div>

    </div>

  </div>

@endsection
