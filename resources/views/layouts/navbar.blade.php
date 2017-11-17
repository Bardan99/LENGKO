
  <a href="/" title="LENGKO">
    <img class="img-center" src="/files/images/lengko-logo.png" alt="" width="140px" height="70px" />
  </a>
  <hr class="dashed" />

  <select id="select-navbar" class="" onchange="location = this.value;">
    @foreach ($pages as $key => $value)
      <option value="/dashboard{{ $value->kode_halaman }}" @if('/' . $page == $value->kode_halaman) {{ 'selected' }} @endif>
        {{ $value->nama_halaman }}
      </option>
    @endforeach
  </select>

  <ul id="list-navbar">
    @foreach ($pages as $key => $value)
    <li class="text-left @if('/' . $page == $value->kode_halaman) {{ 'active' }} @endif">
      <span class="glyphicon {{ $value->ikon_halaman }}" aria-hidden="true"></span>&nbsp;
      <a class="" href="/dashboard{{ $value->kode_halaman }}">
        {{ $value->nama_halaman }}
      </a>
    </li>
    @endforeach
  </ul>
