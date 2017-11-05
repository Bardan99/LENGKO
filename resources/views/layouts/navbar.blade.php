
  <img class="img-center" src="/files/images/logo.png" alt="" width="140px" height="70px" />
  <hr class="dashed" />
  <?php
    $menus = (object) array(
      (object) array('link' => '/dashboard/', 'title' => 'Beranda', 'glyphicon' => 'glyphicon-dashboard'),
      (object) array('link' => '/dashboard/device/', 'title' => 'Perangkat', 'glyphicon' => 'glyphicon-cog'),
      (object) array('link' => '/dashboard/employee/', 'title' => 'Pegawai', 'glyphicon' => 'glyphicon-user'),
      (object) array('link' => '/dashboard/menu/', 'title' => 'Menu', 'glyphicon' => 'glyphicon-th-list'),
      (object) array('link' => '/dashboard/order/', 'title' => 'Pesanan', 'glyphicon' => 'glyphicon-shopping-cart'),
      (object) array('link' => '/dashboard/pantry/', 'title' => 'Bahan Baku', 'glyphicon' => 'glyphicon-hdd'),
      (object) array('link' => '/dashboard/review/', 'title' => 'Kuisioner', 'glyphicon' => 'glyphicon-heart'),
      (object) array('link' => '/dashboard/report/', 'title' => 'Laporan', 'glyphicon' => 'glyphicon-usd')
    )
  ?>
  <select id="select-navbar" class="obj-center" onchange="location = this.value;">
    @foreach ($menus as $key => $value)
      <option value="{{ $value->link }}">{{ $value->title }}</option>
    @endforeach
  </select>

  <ul id="list-navbar">
    @foreach ($menus as $key => $value)
    <li class="text-left">
      <span class="glyphicon {{ $value->glyphicon }}" aria-hidden="true"></span>&nbsp;
      <a class="navbar-link" href="{{ $value->link }}">{{ $value->title }}</a>
    </li>
    @endforeach
  </ul>
