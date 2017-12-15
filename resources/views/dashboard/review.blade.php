@extends('layouts.dashboard')

@section('title', 'LENGKO - Kuisioner')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      <input type="hidden" name="search_token" value="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Hasil Kuisioner</div>
            <div class="panel-body">
              @if (count($data['review-device']) > 0)

              <div class="row">
                <div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6">
                  <div class="input-group padd-tb-10">
                    <input type="text" name="review-search-query" class="form-control input-lengko-default" placeholder="Cari Kuisioner" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" name="review-search-button" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">

                  <!-- copied here -->
                  <div class="row">
                    <div class="col-md-12">
                      <div id="review-card-section" class="padd-tb-10">
                        <div class="row padd-lr-15 open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Klik untuk melihat detil kuisioner">
                          <div class="col-md-3 col-sm-3 col-xs-4">
                            <i class="material-icons md-18">arrow_drop_down</i>
                            <label>Responden</label>
                          </div>
                          <div class="col-md-5 col-sm-5 col-xs-4">
                            <label>Kritik & Saran</label>
                          </div>
                          <div class="col-md-4 col-sm-4 col-xs-4">
                            <label>Waktu</label>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="seperator"></div>
                          </div>
                        </div>
                        @foreach ($data['review-device'] as $key1 => $value1)
                          <div onclick="show_obj('review-{{ $key1 }}');" class="cursor-pointer padd-tb-10 mrg-lr-15 padd-lr-15 @if ($value1->status_kuisioner_perangkat === 0) {{'status-disabled'}} @endif">
                            <div class="row">
                              <div class="col-md-3 col-sm-3 col-xs-4">
                                #{{ $value1->kode_kuisioner_perangkat }} ({{ $value1->pembeli_kuisioner_perangkat }})
                              </div>
                              <div class="col-md-5 col-sm-5 col-xs-4">
                                {{ $value1->pesan_kuisioner_perangkat }}
                              </div>
                              <div class="col-md-4 col-sm-4 col-xs-4">
                                {{ $value1->tanggal_kuisioner_perangkat }} {{ $value1->waktu_kuisioner_perangkat }}
                              </div>
                            </div>
                          </div>
                          @if (count($data[$key1]['review-detail']) > 0)
                            <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="review-{{ $key1 }}" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">
                                  <table class="table table-hover table-striped">
                                    <tr>
                                      <th>Kuisioner</th>
                                      <th>Poin</th>
                                    </tr>
                                  @foreach ($data[$key1]['review-detail'] as $key2 => $value2)
                                    <tr>
                                      <td> [{{ $value2->judul_kuisioner }}] {{$value2->isi_kuisioner}} </td>
                                      <td>
                                        <select id="customer-reviews-{{$value2->kode_kuisioner_detil}}" class="barrating-readonly">
                                          @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{$i}}" @if ($i == $value2->poin_kuisioner_detil) {{'selected'}} @endif>{{$i}}</option>
                                          @endfor
                                        </select>
                                      </td>
                                    </tr>
                                  @endforeach

                                  </table>
                                  <div class="row padd-tb-10">
                                    <div class="col-md-6">
                                      <button class="btn-lengko btn-lengko-danger block" type="button" onclick="delete_review_device('{{$value1->kode_kuisioner_perangkat}}');">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus
                                      </button>
                                    </div>
                                    <div class="col-md-6">
                                      <form method="post" action="{{url('/dashboard/update/reviewdevice')}}">
                                        <input type="hidden" name="_id" value="{{ $value1->kode_kuisioner_perangkat }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="put">
                                      @if ($value1->status_kuisioner_perangkat === 1)
                                        <button class="btn-lengko btn-lengko-default block" type="submit">
                                          <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> Sembunyikan
                                        </button>
                                      @elseif ($value1->status_kuisioner_perangkat === 0)
                                        <button class="btn-lengko btn-lengko-default block" type="submit">
                                          <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Tampilkan
                                        </button>
                                      @endif
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          @endif
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="seperator"></div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>

                  </div>
                  <!-- copied here -->

                </div>
              </div>
              @else
                <div class="row">
                  <div class="col-md-8">
                    <div class="alert alert-warning">Belum ada kuisioner pelanggan.</div>
                  </div>
                </div>
              @endif

            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Kuisioner</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  @if (count($data['review']) > 0)
                  <div>
                    <table class="table table-hover table-striped stackable">
                      <tr>
                        <th>#</th>
                        <th>Kuisioner</th>
                        <th>Waktu</th>
                        <th></th>
                      </tr>
                    @foreach ($data['review'] as $key1 => $value1)
                      <tr class="@if ($value1->status_kuisioner === 0) {{'status-disabled'}} @endif">
                        <td>#{{ $value1->kode_kuisioner }} ({{ $value1->judul_kuisioner }})</td>
                        <td>{{ $value1->isi_kuisioner }}</td>
                        <td>{{ $value1->tanggal_kuisioner }} {{ $value1->waktu_kuisioner }}</td>
                        <td>
                          <button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="delete_review('{{$value1->kode_kuisioner}}');">
                            <i class="material-icons md-18">close</i>
                          </button>
                          @if ($value1->status_kuisioner === 1)
                            <button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="change_review('{{$value1->kode_kuisioner}}');">
                              <i class="material-icons md-18">radio_button_checked</i>
                            </button>
                          @elseif ($value1->status_kuisioner === 0)
                            <button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="change_review('{{$value1->kode_kuisioner}}');">
                              <i class="material-icons md-18">radio_button_unchecked</i>
                            </button>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                    </table>
                  </div>
                  @else
                    <div class="row">
                      <div class="col-md-8">
                        <div class="alert alert-warning">Belum ada kuisioner.</div>
                      </div>
                    </div>
                  @endif
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
              @if (count($errors) > 0)
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form class="form-horizontal" name="review-add" method="post" action="{{url('/dashboard/create/review')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                  <div class="col-md-3 col-sm-2">
                    <label style="margin: 10px 5px 10px 0px;">Judul</label>
                  </div>
                  <div class="col-md-9 col-sm-7">
                    <input type="text" name="review-add-title" class="input-lengko-default block" placeholder="Judul Kuisioner" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 col-sm-2">
                    <label style="margin: 10px 5px 10px 0px;">Kuisioner</label>
                  </div>
                  <div class="col-md-9 col-sm-7">
                    <textarea name="review-add-content" class="textarea-lengko-default block" rows="5" placeholder="Kuisioner"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-9">
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
              @if (count($data['review-status']) > 0)
              <div class="row">
                <div class="col-md-12 col-sm-8">
                  <canvas id="customer-review" width="400px" height="300px"></canvas>
                </div>
              </div>
              @else
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-warning">
                      Kuisioner tidak tersedia untuk ditampilkan.
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

@endsection
