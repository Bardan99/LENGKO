@extends('layouts.main')

@section('title', 'LENGKO - Apa Kata Mereka?')

@section('content')

  <div class="container">

    <div class="row mrg-b-10">
      <div class="col-md-12">
        <h2 class="text-center">Ini kata mereka</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <canvas id="customer-review" width="400px" height="300px"></canvas>
      </div>
      <div class="col-md-6">

        @foreach ($data['customer-reviews'] as $key => $value)
          <div class="slider-description">
            <div class="row">
              <div class="col-md-12">
                <h3>{{$value->pembeli_kuisioner_perangkat}}</h3>
                <p>{{$value->pesan_kuisioner_perangkat}}</p>
                {{$value->tanggal_kuisioner_perangkat}}
                {{$value->waktu_kuisioner_perangkat}}
              </div>
            </div>
          </div>
        @endforeach

      </div>
    </div>

    <div class="row mrg-b-20">
      <div class="col-md-12">
        <hr />
        <h2 class="text-center">Bagaimana dengan anda?</h2>
      </div>
    </div>

    <div class="row mrg-b-10">
      <div class="col-md-6">

        <div class="row mrg-b-10">
          <div class="col-md-6">
            <label>Nama Pembeli</label>
            <input type="text" name="" class="input-lengko-default block" placeholder="Nama Pembeli" value="" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label>Kritik & Saran</label>
            <textarea name="" class="textarea-lengko-default block" rows="5" placeholder="Aku mau jadi lebih baik lagi buat kamu; buat masa depan kita.."></textarea>
          </div>
        </div>

      </div>
      <div class="col-md-6">

        @foreach ($data['review'] as $key => $value)
        <div class="row mrg-b-10">
          <div class="col-md-8">
            [<b>{{ $value->nama_kuisioner }}</b>]
            {{ $value->isi_kuisioner }}
          </div>
          <div class="col-md-4">
            <select id="customer-rating-{{$key}}" class="barrating">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
        </div>
        @endforeach

      </div>
    </div>
    <div class="row mrg-b-10">
      <div class="col-md-offset-2 col-md-8">
        <button type="submit" class="btn-lengko btn-lengko-default block">
          <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Kirim
        </button>
      </div>
    </div>

  </div> <!-- end container -->

@endsection

@section('footer-section')
  @include('addition')
  @yield('footer-copyright')
@endsection
