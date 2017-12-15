@extends('layouts.dashboard')

@section('title', 'LENGKO - Ubah Bahan Baku')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      @if ($auth == 'root' || $auth == 'pantry')
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Ubah Bahan Baku</div>
            <div class="panel-body">
              <form name="" class="form-horizontal" method="post" action="{{ url('dashboard/update/material') }}">
                <input type="hidden" name="material-id" value="{{$data['material']->kode_bahan_baku}}">
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Nama</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="material-change-name" class="input-lengko-default block" placeholder="Nama Bahan Baku" value="{{ $data['material']->nama_bahan_baku }}" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Stok</label>
                  </div>
                  <div class="col-md-4 col-sm-6">
                    <input type="number" min="0" name="material-change-stock" class="input-lengko-default block" placeholder="Stok Bahan Baku" value="{{ $data['material']->stok_bahan_baku }}" />
                  </div>
                  <div class="col-md-5 col-sm-6">
                    <input type="text" name="material-change-unit" class="input-lengko-default block" placeholder="Satuan Bahan Baku" value="{{ $data['material']->satuan_bahan_baku }}" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label style="margin: 10px 5px 10px 0px;">Kadaluarsa</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="material-change-date" class="input-lengko-default block datepicker" placeholder="Kadaluarsa Bahan Baku" value="{{ $data['material']->tanggal_kadaluarsa_bahan_baku }}" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <a href="{{ url('/dashboard/material/') }}">
                      <button class="btn-lengko btn-lengko-default pull-left" type="button">
                        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                      </button>
                    </a>
                    <button class="btn-lengko btn-lengko-default pull-left" type="submit">
                      <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                    </button>
                    <input type="hidden" name="material-id" value="{{$data['material']->kode_bahan_baku}}" />
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endif

    </div>
  </div>


@endsection
