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
                <div class="col-md-offset-8 col-md-4">
                  <div class="input-group padd-tb-10">
                    <input type="text" name="review-search-query" class="form-control" placeholder="Cari Kuisioner" />
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

                  <div id="review-card-section" class="table-responsive">
                    <table class="table">
                      <tr>
                        <th width="150px">#</th>
                        <th>Kritik & Saran</th>
                        <th width="200px">Waktu</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    @foreach ($data['review-device'] as $key1 => $value1)
                      <tr class="cursor-pointer">
                        <td onclick="show_obj('review-{{ $key1 }}');">#{{ $value1->kode_kuisioner_perangkat }} ({{ $value1->pembeli_kuisioner_perangkat }})</td>
                        <td onclick="show_obj('review-{{ $key1 }}');">{{ $value1->pesan_kuisioner_perangkat }}</td>
                        <td onclick="show_obj('review-{{ $key1 }}');">{{ $value1->tanggal_kuisioner_perangkat }} {{ $value1->waktu_kuisioner_perangkat }}</td>
                        <td>
                          <form method="post" action="{{url('/dashboard/update/reviewdevice')}}">
                            <input type="hidden" name="_id" value="{{ $value1->kode_kuisioner_perangkat }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="put">
                          @if ($value1->status_kuisioner_perangkat === 1)
                            <button class="btn-lengko btn-lengko-default pull-right" type="submit">
                              <span class="glyphicon glyphicon-record" aria-hidden="true"></span>
                            </button>
                          @elseif ($value1->status_kuisioner_perangkat === 0)
                            <button class="btn-lengko btn-lengko-default pull-right" type="submit">
                              <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>
                            </button>
                          @endif
                          </form>
                        </td>
                        <td>
                          <button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="delete_review_device('{{$value1->kode_kuisioner_perangkat}}');">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                        </td>
                      </tr>
                      @if (count($data[$key1]['review-detail']) > 0)
                      <tr id="review-{{ $key1 }}" style="display:none; visibility: none;">
                        <td></td>
                        <td colspan="5">
                          <div class="table-responsive">
                            <table class="table table-hover table-striped">
                            <tr>
                              <th>Kuisioner</th>
                              <th>Poin</th>
                            </tr>
                            @foreach ($data[$key1]['review-detail'] as $key2 => $value2)
                              <tr>
                                <td>
                                  [{{ $value2->judul_kuisioner }}]
                                  {{$value2->isi_kuisioner}}
                                </td>
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
                          </div>
                        </td>
                      </tr>
                      @endif
                    @endforeach
                    </table>
                  </div>

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
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>#</th>
                        <th>Kuisioner</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    @foreach ($data['review'] as $key1 => $value1)
                      <tr class="cursor-pointer">
                        <td>#{{ $value1->kode_kuisioner }} ({{ $value1->judul_kuisioner }})</td>
                        <td>{{ $value1->isi_kuisioner }}</td>
                        <td>{{ $value1->tanggal_kuisioner }} {{ $value1->waktu_kuisioner }}</td>
                        <td>
                          <form method="post" action="{{url('/dashboard/update/review')}}">
                            <input type="hidden" name="_id" value="{{ $value1->kode_kuisioner }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="put">
                          @if ($value1->status_kuisioner === 1)
                            <button class="btn-lengko btn-lengko-default pull-right" type="submit">
                              <span class="glyphicon glyphicon-record" aria-hidden="true"></span>
                            </button>
                          @elseif ($value1->status_kuisioner === 0)
                            <button class="btn-lengko btn-lengko-default pull-right" type="submit">
                              <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>
                            </button>
                          @endif
                          </form>
                        </td>
                        <td>
                          <button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="delete_review('{{$value1->kode_kuisioner}}');">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                        </td>
                      </tr>
                    @endforeach
                    </table>
                  </div>
                  @else
                    Belum ada kuisioner
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
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Judul</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="review-add-title" class="input-lengko-default block" placeholder="Judul Kuisioner" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kuisioner</label>
                  </div>
                  <div class="col-md-9">
                    <textarea name="review-add-content" class="textarea-lengko-default block" rows="5" placeholder="Kuisioner"></textarea>
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
              @if (count($data['review-status']) > 0)
              <canvas id="customer-review" width="400px" height="300px"></canvas>
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
