@extends('layouts.dashboard')

@section('title', 'LENGKO - Beranda')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Pemberitahuan</div>
            <div class="panel-body">
              @if (count($data['notification']) > 0)
              <div class="row">
                <div class="col-md-8 col-sm-8">
                  <div class="list-group-item"><label>Pemberitahuan</label></div>
                  <div class="list-group scrollable scrollable-md">
                    @foreach ($data['notification'] as $key => $value)
                      <li class="list-group-item @if ($key == 0) {{' active'}}@endif">
                        <div class="row">
                          <div class="col-md-8 text-left">
                            {{$value->isi_pemberitahuan}}
                          </div>
                          <div class="col-md-4 text-right">
                            <span class="badge">
                              {{$value->tanggal_pemberitahuan}} &nbsp;
                              {{$value->waktu_pemberitahuan}}
                            </span>
                          </div>
                        </div>
                      </li>
                    @endforeach
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                  <i class="material-icons md-180 desktop-only">notifications</i>
                  <h3 class="desktop-only mrg-t-0">Pemberitahuan</h3>
                </div>
              </div>
            @else
              <div class="row">
                <div class="col-md-8">
                  <div class="alert alert-warning">
                    Belum ada pemberitahuan.
                  </div>
                </div>
              </div>
            @endif
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Profil</div>
            <div class="panel-body">
              @if (count($errors) > 0)
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              @if ($data['employee']->gambar_pegawai !== '')
                @if (file_exists(public_path('/files/images/employee/') . '/' . $data['employee']->gambar_pegawai))
                  @php $path = $data['employee']->gambar_pegawai; @endphp
                @else
                  @php $path = 'default.png'; @endphp
                @endif
              @else
                @php $path = 'default.png'; @endphp
              @endif

              <form class="" action="{{ url('/dashboard/update/profile/') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                    <div class="container-file-lengko overlay block open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Ubah gambar profil">
                      <img id="preview-profile" class="img-circle img-center" src="{{ url('/files/images/employee/') . '/' . $path }}" alt="" width="140px" height="140px" />
                      <input name="employee-photo" type="file" onchange="reload_image(this, '#preview-profile');" />
                      <input type="hidden" name="employee-id" value="{{ $data['employee']->kode_pegawai }}">
                      <input type="hidden" name="_method" value="put">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-8">
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Nama Pengguna</div>
                      <div class="col-md-8"><b>{{ $data['employee']->kode_pegawai }}</b></div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Nama Lengkap</div>
                      <div class="col-md-8">
                        <input type="text" id="employee-name" name="employee-name" class="input-lengko-default block" placeholder="Nama Lengkap" value="{{ $data['employee']->nama_pegawai }}" />
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Kata Sandi</div>
                      <div class="col-md-8">
                        <input type="password" id="employee-password" name="employee-password" class="input-lengko-default block" placeholder="*****" value="" />
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Jenis Kelamin</div>
                      <div class="col-md-8">
                        <div class="radio-lengko-default">
                          <input type="radio" name="employee-gender" id="gender-male" value="L" @if($data['employee']->jenis_kelamin_pegawai == "L") {{'checked="checked" checked'}} @endif /><label for="gender-male">Laki-Laki</label>
                          <input type="radio" name="employee-gender" id="gender-female" value="P" @if($data['employee']->jenis_kelamin_pegawai == "P") {{'checked="checked" checked'}} @endif /><label for="gender-female">Perempuan</label>
                        </div>
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Otoritas</div>
                      <div class="col-md-8"><b>{{ $data['employee']->nama_otoritas }}</b></div>
                    </div>
                    <button type="submit" class="btn-lengko btn-lengko-default pull-right">Simpan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

@endsection
