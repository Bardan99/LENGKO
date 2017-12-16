
  <a href="{{ url ('/dashboard') }}" title="LENGKO">
    <img class="img-center" src="{{ url('/files/images/lengko-logo.png') }}" alt="" width="140px" height="70px" />
  </a>

  <hr class="dashed" />

  <select id="select-navbar" class="" onchange="location = this.value;">
    @foreach ($pages as $key => $value)
      @php $path = $value->kode_halaman; @endphp
      @if ($value->kode_halaman == "home")
        @php $path = "/"; @endphp
      @endif
      <option @if ($value->kode_halaman == "home") id="{{'notifnavs'}}" @endif value="{{ url('/dashboard/'.$path) }}" @if($page == $path) {{ 'selected' }} @endif>
        {{ $value->nama_halaman }}
        @if ($value->kode_halaman == "home")
          (0)
        @endif
      </option>
    @endforeach
  </select>

  <ul id="list-navbar">
    @foreach ($pages as $key => $value)
      @php $path = $value->kode_halaman; @endphp
      @if ($value->kode_halaman == "home")
        @php $path = "/"; @endphp
      @endif
      <li class="text-left @if($page == $path) {{ 'active' }} @endif">
        <span class="glyphicon {{ $value->ikon_halaman }}" aria-hidden="true"></span>&nbsp;
        <a class="" href="{{ url('/dashboard/'.$path) }}">
          {{ $value->nama_halaman }}
        </a>
        @if ($value->kode_halaman == "home")
          <span id="notifs" class="badge">0</span>
        @endif
      </li>
    @endforeach
  </ul>
