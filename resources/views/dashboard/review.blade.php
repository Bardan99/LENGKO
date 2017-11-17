@extends('layouts.dashboard')

@section('title', 'LENGKO - Kuisioner')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Kuisioner</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>#</th>
                        <th>Kuisioner</th>
                        <th>Waktu</th>
                        <th>Status</th>
                      </tr>
                    @foreach ($data['review'] as $key1 => $value1)
                      <tr onclick="show_obj('review-{{ $key1 }}');" class="cursor-pointer">
                        <td>#{{ $value1->kode_kuisioner }} ({{ $value1->nama_kuisioner }})</td>
                        <td>{{ $value1->isi_kuisioner }}</td>
                        <td>{{ $value1->tanggal_kuisioner }} {{ $value1->waktu_kuisioner }}</td>
                        <td>{{ $value1->status_kuisioner }}</td>
                      </tr>
                      @if (count($data[$key1]['review-detail']) > 0)
                      <tr id="review-{{ $key1 }}" style="display:none; visibility: none;">
                        <td></td>
                        <td colspan="5">
                          <div class="table-responsive">
                            <table class="table table-hover table-striped">
                            <tr>
                              <th>Pembeli</th>
                              <th>Kritik & Saran</th>
                              <th>Poin</th>
                              <th width="200px">Waktu</th>
                              <th>Status</th>
                            </tr>
                            @foreach ($data[$key1]['review-detail'] as $key2 => $value2)
                              <tr>
                                <td></td>
                                <td></td>
                                <td>{{ $value2->poin_kuisioner_detil }}</td>
                                <td></td>
                                <td></td>
                              </tr>
                            @endforeach
                            </table>
                          </div>
                        </td>
                      </tr>
                      @endif
                    @endforeach
                    </table>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Tambah Kuisioner</div>
            <div class="panel-body">

              <form class="form-horizontal">
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Judul</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="" class="input-lengko-default block" placeholder="Judul Kuisioner" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kuisioner</label>
                  </div>
                  <div class="col-md-9">
                    <textarea name="" class="textarea-lengko-default block" rows="5" placeholder="Kuisioner"></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <button type="reset" class="btn-lengko btn-lengko-danger">Batalkan</button>
                    <button type="submit" class="btn-lengko btn-lengko-default pull-right">Tambah</button>
                  </div>
                </div>
              </form>


            </div>
          </div>

        </div>
        <div class="col-md-6">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Statistik Kuisioner</div>
            <div class="panel-body">
              <canvas id="customer-review" width="400px" height="300px"></canvas>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

@endsection
