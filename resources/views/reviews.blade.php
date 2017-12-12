@extends('layouts.main')

@section('title', 'LENGKO - Apa Kata Mereka?')

@section('content')

  <div class="container">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if (count($data['customer-reviews']) > 0)
    <div class="row mrg-b-10">
      <div class="col-md-12">
        <h2 class="text-center">~Ini kata mereka</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-8 col-md-6">
        <canvas id="customer-review" width="400px" height="300px"></canvas>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6">
          @foreach ($data['customer-reviews'] as $key => $value)
            <div class="row">
              <div class="col-md-12">
                <h3>{{$value->pembeli_kuisioner_perangkat}}</h3>
                <p>{{$value->pesan_kuisioner_perangkat}}</p>
                <div class="row">
                  <div class="col-md-12 text-right">
                    {{$value->tanggal_kuisioner_perangkat}}
                    {{$value->waktu_kuisioner_perangkat}}
                  </div>
                </div>
                <div class="row">
                  @foreach ($data[$key]['review-detail'] as $key2 => $value2)
                  <div class="col-xs-6 col-sm-2 col-md-3 col-lg-3">
                    {{ $value2->judul_kuisioner }}
                  </div>
                  <div class="col-xs-6 col-sm-2 col-md-3 col-lg-3">
                    <select class="barrating-readonly">
                      <option value=""></option>
                      @for ($i = 1; $i <= 5; $i++)
                        <option value="{{$i}}" @if ($i == $value2->poin_kuisioner_detil) {{'selected'}} @endif>{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          @endforeach
      </div>
    </div>
    @else
      <div class="row">
        <div class="col-md-8">
          <div class="alert alert-warning">
            Kuisioner tidak tersedia untuk ditampilkan.
          </div>
        </div>
      </div>
    @endif

    <div class="row mrg-b-20">
      <div class="col-md-12">
        <hr />
        <h2 class="text-center">
          @if (count($data['customer-reviews']) > 0)
            Bagaimana dengan kamu?
          @else
            Yuk, bantu kami tingkatkan kualitas ^_^
          @endif
        </h2>
      </div>
    </div>

    <div class="row mrg-b-10">
      <div class="col-md-6">

        <div class="row mrg-b-10">
          <div class="col-md-6">
            <label>Nama Pembeli</label>
            <input type="text" name="review-create-name" class="input-lengko-default block" placeholder="Nama Pembeli" value="" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label>Kritik & Saran</label>
            <textarea name="review-create-message" class="textarea-lengko-default block" rows="5" placeholder="Aku mau jadi lebih baik lagi buat kamu; buat masa depan kita.."></textarea>
          </div>
        </div>

      </div>
      <div class="col-md-6">
        <input type="hidden" name="_rattings" value="{{count($data['review'])}}">
        @foreach ($data['review'] as $key => $value)
        <div class="row mrg-b-10">
          <div class="col-md-8">
            [<b>{{ $value->judul_kuisioner }}</b>]
            {{ $value->isi_kuisioner }}
          </div>
          <div class="col-md-4">
            <input type="hidden" name="review-create-rating-id-{{$key}}" value="{{$value->kode_kuisioner}}">
            <select id="review-create-rating-{{$value->kode_kuisioner}}" name="review-create-rating-{{$key}}" class="barrating">
              <option value=""></option>
              @for ($i = 1; $i <= 5; $i++)
                <option value="{{$i}}" @if ($i == 5) {{'selected'}} @endif>{{$i}}</option>
              @endfor
            </select>
          </div>
        </div>
        @endforeach

        <div class="row">
          <div class="col-md-12">
            <button type="button" name="review-create-btn" class="btn-lengko btn-lengko-default block">
              <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Kirim
            </button>
          </div>
        </div>
      </div>
    </div>

  </div> <!-- end container -->

@endsection

@section('footer-section')
  @include('addition')
  @yield('footer-copyright')
@endsection
