@extends('layouts.dashboard')

@section('title', 'LENGKO - Menu')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      <input type="hidden" name="search_token" value="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Manajemen Menu</div>
            <div class="panel-body">
              @if (count($data['menu']) > 0)

              <div class="row padd-lr-20">
                <div class="col-md-offset-8 col-md-4">
                  <div class="input-group">
                    <input type="hidden" name="menu-search-token" value="{{ csrf_token() }}">
                    <input type="text" name="menu-search-query" class="form-control input-lengko-default" placeholder="Cari Menu" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" name="menu-search-button" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row mrg-t-20 padd-lr-20">

                <div id="menu-card-section" class="box-menu scrollable @if (count($data['menu']) > 2) {{'scrollable-lg'}} @endif">
                  @foreach ($data['menu'] as $keymenu => $value)
                    <form name="menu-update" class="form-horizontal" action="{{ url('/dashboard/update/menu/') }}" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="_method" value="put">
                      <input type="hidden" name="menu-change-id" value="{{$value->kode_menu}}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="row mrg-b-10 padd-tb-10">
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-5">
                              <div class="container-file-lengko block">
                                <img id="preview-image-{{$keymenu}}" class="hoverblur" src="/files/images/menus/@if($value->gambar_menu){{$value->gambar_menu}}@else{{'not-available.png'}}@endif" alt="{{ $value->nama_menu }}" width="200px" height="150px" style="border-radius:5px;" />
                                @if ($auth == 'root' || $auth == 'chef')
                                  <input id="choose-image-{{$keymenu}}" name="menu-change-thumbnail" type="file" title="Ubah gambar menu" onchange="reload_image(this, '#preview-image-{{$keymenu}}');" />
                                @endif
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="row">
                                <div class="col-md-3">
                                  <div class="text-left padd-tb-10">[<b>{{ $value->kode_menu }}</b>]</div>
                                </div>
                                <div class="col-md-9">
                                  <input type="text" name="menu-change-name" class="input-lengko-default block" placeholder="Nama Menu" value="{{ $value->nama_menu }}" @if ($auth != 'root' && $auth != 'chef') {{'readonly'}} @endif/>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-7">
                                  <select name="menu-change-type" class="select-lengko-default block" @if ($auth != 'root' && $auth != 'chef') {{'disabled="disabled"'}} @endif>
                                    <option value="F" @if ($value->jenis_menu == "F") {{ 'selected="selected"' }} @endif>Makanan</option>
                                    <option value="D" @if ($value->jenis_menu == "D") {{ 'selected="selected"' }} @endif>Minuman</option>
                                  </select>
                                </div>
                                <div class="col-md-5">
                                  <input type="number" name="menu-change-price" class="input-lengko-default block" placeholder="Harga Menu" value="{{ $value->harga_menu }}" @if ($auth != 'root' && $auth != 'chef') {{'readonly'}} @endif />
                                </div>
                              </div>
                              <div class="row padd-tb-10">
                                <div class="col-md-12">
                                  <div class="well well-sm">
                                  @php ($res = false)
                                  @php ($i = 0)
                                  @foreach ($data[$keymenu]['menu-status'] as $key2 => $value2)
                                    @php ($i++)
                                    @if ($value2->stok_bahan_baku > 0)
                                      @php ($res = true)
                                    @else
                                      @php ($res = false)
                                      @break
                                    @endif
                                  @endforeach
                                  @if ($i == count($data[$keymenu]['menu-status']))
                                    @if ($res)
                                      {!! '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Tersedia ' !!}
                                    @else
                                      {!! '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Tidak Tersedia ' !!}
                                    @endif
                                  @else
                                    {!! '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Tidak Tersedia ' !!}
                                  @endif
                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12">
                              <textarea name="menu-change-description" class="textarea-lengko-default block" rows="5" placeholder="Deskripsi Menu" @if ($auth != 'root' && $auth != 'chef') {{'readonly'}} @endif>{{ substr($value->deskripsi_menu, 0, 300) . '' }}</textarea>
                            </div>
                          </div>
                          @if ($auth == 'root' || $auth == 'chef')
                          <div class="row">
                            <div class="col-md-6">
                              <button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj('material-card-change-{{ $value->kode_menu }}');">
                                Bahan Baku <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                              </button>
                            </div>
                            <div class="col-md-6">
                              <button class="btn-lengko btn-lengko-default pull-right" type="submit">
                                <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                              </button>

                              <button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="delete_menu('{{$value->kode_menu}}');">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </button>
                            </div>
                          </div>
                          @endif
                        </div>
                        <!-- end row -->
                      </div>

                      <div id="material-card-change-{{ $value->kode_menu }}" class="row" hidden="hidden">
                        <div class="col-md-12">

                            <div class="scrollable @if (count($data['material']) > 8) {{'scrollable-md'}} @endif">
                              <div class="row">

                              @foreach ($data['material'] as $key => $value)
                                <div class="col-md-6">
                                  <input type="hidden" name="menu-material-change-id-{{$key}}" value="{{$value->kode_bahan_baku}}" />
                                  <?php $count = 0; ?>
                                  @foreach ($data[$keymenu]['menu-material'] as $key3 => $value3)
                                    @if ($value3->kode_bahan_baku == $value->kode_bahan_baku)
                                      <?php $count = $value3->jumlah_bahan_baku_detil ?>
                                    @endif
                                  @endforeach

                                  @if ($count > 0)
                                    <input type="number" name="menu-material-change-count-{{$key}}" min="0" class="input-lengko-default" placeholder="0.0" value="{{$count}}" />
                                    (<small>{{ $value->satuan_bahan_baku }}</small>)
                                    <b>{{ $value->nama_bahan_baku }}</b>
                                  @else
                                    <input type="number" name="menu-material-change-count-{{$key}}" min="0" class="input-lengko-default" placeholder="0.0" />
                                    (<small>{{ $value->satuan_bahan_baku }}</small>)
                                    {{ $value->nama_bahan_baku }}
                                  @endif
                                </div>
                              @endforeach
                              <input type="hidden" name="menu-material-max" value="{{count($data['material'])}}" />
                              </div>
                            </div>

                          Bahan baku tidak tersedia? Silahkan ajukan <a href="{{url('/dashboard/material')}}">Permohonan Pengadaan Bahan Baku</a>.
                        </div>
                      </div>
                    </form>
                  <hr />
                  @endforeach
                </div>
              </div>

              @endif

            </div>
          </div>

        </div>
      </div>
      @if ($auth == 'root' || $auth == 'chef')
      <div class="row">
        <div class="col-md-12 col-sm-8">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Tambah Menu</div>
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

              @if (count($data['material']) > 0)
              <form name="menu-add" class="form-horizontal" action="{{ url('/dashboard/create/menu/') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Tambahkan informasi menu..">
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Kode</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" name="menu-create-id" class="input-lengko-default block" placeholder="Kode Menu" />
                  </div>
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Nama</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" name="menu-create-name" class="input-lengko-default block" placeholder="Nama Menu" />
                  </div>
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Harga</label>
                  </div>
                  <div class="col-md-3">
                    <input type="number" name="menu-create-price" min="0" class="input-lengko-default block" placeholder="Harga Menu" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1">
                    <label>Gambar</label>
                  </div>
                  <div class="col-md-2">
                    <div class="container-file-lengko block">
                      <img id="preview-thumbnail" class="img-thumbnail hoverblur" src="/files/images/menus/default.png" alt="" width="140px" height="140px" />
                      <input name="menu-create-thumbnail" type="file" title="Ubah gambar menu" onchange="reload_image(this, '#preview-thumbnail');" />
                    </div>
                  </div>
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Jenis</label>
                  </div>
                  <div class="col-md-2">
                    <div class="radio-lengko-default">
                      <input type="radio" name="menu-create-type" id="menu-food" value="F" /><label for="menu-food">Makanan</label>
                      <input type="radio" name="menu-create-type" id="menu-drink" value="D" checked="checked" /><label for="menu-drink">Minuman</label>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <label style="margin: 10px 5px 10px 0px;">Deskripsi</label>
                  </div>
                  <div class="col-md-5">
                    <textarea name="menu-create-description" class="textarea-lengko-default block" rows="5" placeholder="Deskripsi Menu"></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="row mrg-b-10">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-8">
                            <label>Bahan Baku</label>
                          </div>
                          <div class="col-md-4">
                            <input type="hidden" name="material-menu-search-token" value="{{ csrf_token() }}">
                            <div class="input-group">
                              <input type="text" name="search-material-menu-query" class="form-control input-lengko-default" placeholder="Cari Bahan Baku" />
                              <span class="input-group-btn">
                                <button class="btn btn-default" name="search-material-menu-button" type="button">
                                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                              </span>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="scrollable @if (count($data['material']) > 8) {{'scrollable-md'}} @endif">
                          <div id="material-card-section" class="row">
                            @foreach ($data['material'] as $key => $value)
                              <div class="col-md-6">
                                <input type="hidden" name="menu-material-create-id-{{$key}}" value="{{$value->kode_bahan_baku}}" />
                                <input type="number" name="menu-material-create-count-{{$key}}" min="0" class="input-lengko-default" placeholder="0.0" />
                                (<small>{{ $value->satuan_bahan_baku }}</small>)
                                {{ $value->nama_bahan_baku }}
                              </div>
                            @endforeach
                            <input type="hidden" name="menu-material-max" value="{{count($data['material'])}}" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <br />
                    Bahan baku tidak tersedia? Silahkan ajukan <a href="{{url('/dashboard/material')}}">Permohonan Pengadaan Bahan Baku</a>.
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <hr />
                    <button type="reset" class="btn-lengko btn-lengko-danger">Batalkan</button>
                    <button type="submit" class="btn-lengko btn-lengko-default pull-right">Tambah</button>
                  </div>
                </div>
              </form>
              @else
                <div class="row">
                  <div class="col-md-8">
                    <div class="alert alert-warning">
                      Bahan baku tidak tersedia. Tidak dapat menambahkan menu.<br />
                      Silahkan ajukan <a href="{{url('/dashboard/material')}}">Permohonan Pengadaan Bahan Baku</a>.
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>
      @endif
    </div>

  </div>

@endsection
