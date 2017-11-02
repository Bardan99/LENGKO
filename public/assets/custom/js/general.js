/* local db */

var menus = new Array (
  {
  'id' : 'menu-1',
  'nama' : 'Nasi Tutug Oncom Tasikmalaya',
  'harga' : '4000',
  'cara' : '',
  'deskripsi' : 'Nasi Tutug Oncom atau Sangu Tutug Oncom dalam Bahasa Sunda sering disingkat Nasi T.O adalah makanan yang dibuat dari nasi yang diaduk dengan oncom goreng atau bakar. Penyajian makanan ini umumnya dalam keadaan hangat. Secara bahasa, kata tutug dalam Bahasa Sunda artinya menumbuk. Proses aduk-tumbuk nasi dengan oncom ini menjadi nama jenis makanan yang dikenal dengan nama tutug oncom. Nasi tutug oncom menjadimakanan khas Tasikmalaya. Walaupun menjadi makanan khas, tutug oncom dapat dibawa menjadi oleh-oleh karena sekarang sudah tersedia tutug oncom instan yang telah dikemas dan mampu bertahan hingga berbulan-bulan tanpa menggunakan pengawet.',
  'sejarah' : 'Menurut Pupuhu Caraka Sundanologi Bandung Adang S, sejak tahun 1940-an nasi tutug oncom sudah disajikan sebagai teman sarapan. Awalnya, kata Adang, oncom tersebut hanya dibakar dan ditambah garam, tanpa diberi bumbu macam-macam. Oncom bakar tersebut lalu dijadikan teman makan nasi. Disajikan dengan teh tanpa gula, oncom bakar biasanya dimakan pada pagi hari sebagai teman sarapan. “Orang Sunda zaman dulu, meski punya peliharaan ayam atau ikan, tidak pernah makan hewan peliharaan tersebut. ',
  'gambar' : 'img4-nasi-tutug-oncom-tasikmalaya.jpg'
  },
  {
  'id' : 'menu-2',
  'nama' : 'Nasi Lengko Cirebon',
  'harga' : '9000',
  'cara' : 'Cara membuat Nasi Lengko Cirebon',
  'deskripsi' : 'Sega lengko (nasi lengko dalam bahasa Indonesia) adalah makanan khas masyarakat pantai utara (Cirebon, Indramayu, Brebes, Tegal dan sekitarnya). Makanan khas yang sederhana ini sarat akan protein dan serat serta rendah kalori karena bahan-bahan yang digunakan adalah 100% non-hewani. Bahan-bahannya antara lain: nasi putih (panas-panas lebih baik), tempe goreng, tahu goreng, mentimun (mentah segar, dicacah), tauge (direbus), daun kucai (dipotong kecil-kecil), bawang goreng, bumbu kacang (seperti bumbu rujak, pedas atau tidak, tergantung selera), dan kecap manis. Dan, umumnya kecap manis yang dipergunakan adalah kecap manis encer, bukan yang kental. Disiramkan ke atas semua bahan.',
  'sejarah' : 'Nasi Lengko berasal dari kata nasi langka, kata langka berarti tidak ada atau jarang. Maksud kata jarang disini adalah lauknya sedikit atau jarang sehingga pelengkap yang digunakan dalam pembuatan nasi lengko pun sangat sederhana seperti nasi putih, tahu, tempe, tauge, daun kucai, mentimun, bawang goreng dan disiram dengan sambel kacang serta kecap, kemudian diaduk hingga rata. Karena nasi dan lauk pauk tersebut diaduk-aduk, ada juga orang yang beranggapan nasi lengko berasal dari kata "lekoh" (kental). Bahkan seiring berkembangnya zaman, ada pula pedagang yang mengakronimkan kata "lengko" adalah singkatan dari "lengkap dan ekonomis".',
  'gambar' : 'img1-lengko-cirebon.jpg'
  },
  {
  'id' : 'menu-3',
  'nama' : 'Rendang Padang',
  'harga' : '15000',
  'cara' : 'Cara membuat Rendang Padang',
  'deskripsi' : 'Rendang atau randang adalah masakan daging bercita rasa pedas yang menggunakan campuran dari berbagai bumbu dan rempah-rempah. Masakan ini dihasilkan dari proses memasak yang dipanaskan berulang-ulang dengan santan kelapa. Proses memasaknya memakan waktu berjam-jam (biasanya sekitar empat jam) hingga kering dan berwarna hitam pekat. Dalam suhu ruangan, rendang dapat bertahan hingga berminggu-minggu. Rendang yang dimasak dalam waktu yang lebih singkat dan santannya belum mengering disebut kalio, berwarna coklat terang keemasan.',
  'sejarah' : 'Dalam catatan harian Kolonel Stuers yang pada tahun 1827 menulis tentang kuliner dan sastra. Di dalam catatan tersebut sering kali muncul secara implisit deskripsi kuliner yang dduga mengarah pada rendang dan tertulis istilah makanan yang dihitamkan dan dihanguskan. Hal ini, menurut Gusti, adalah salah satu metode pengawetan yang biasa dilakukan oleh masyarakat minang. Rendang sendiri berasal dari kata “merandang,” yaitu untuk memasak santan hingga kering secara perlahan hal ini cocok dengan rendang yang memang butuh waktu lama untuk dimasak hingga kuahnya kering.',
  'gambar' : 'img2-rendang-padang.jpg'
  },
  {
  'id' : 'menu-4',
  'nama' : 'Gudeg Yogyakarta',
  'harga' : '18000',
  'cara' : 'Cara membuat Gudeg Yogyakarta',
  'deskripsi' : 'Gudeg (ejaan bahasa Jawa: ꦒꦸꦝꦼꦒ꧀​, gudheg) adalah makanan khas Yogyakarta dan Jawa Tengah yang terbuat dari nangka muda yang dimasak dengan santan. Perlu waktu berjam-jam untuk membuat masakan ini. Warna coklat biasanya dihasilkan oleh daun jati yang dimasak bersamaan. Gudeg dimakan dengan nasi dan disajikan dengan kuah santan kental (areh), ayam kampung, telur, tahu dan sambal goreng krecek.',
  'sejarah' : 'Hingga saat ini, belum diketahui secara jelas tentang sejarah Gudeg. Beberapa pandangan mengkaitkan Gudeg sebagai makanan dari Kraton Yogyakarta, sementara lainnya berpandangan bahwa Gudeg telah lama ada sejak penyerbuan pertama ke Batavia pada 1726-1728 oleh pasukan Sultan Agung yang tercatat dalam sejarah meski belum dapat dibuktikan kebenarannya. Namun dalam berbagai kesimpulan mengenai sejarah Gudeg dapat disimpulkan bahwa Gudeg adalah makanan Masyarakat jaman dulu karena bahan bakunya yaitu nangka muda mudah untuk ditemukan di pekarangan sekitar rumah warga. Nangka tersebut kemudian diolah dan dikembangkan sehingga menjadi Gudeg makanan khas masyarakat Yogyakarta sampai saat ini.',
  'gambar' : 'img3-gudeg-yogyakarta.jpg'
  }
);

/*****/

var menu_detail = document.getElementById('menu-detail');
var menu_title = document.getElementById('menu-title');
var menu_description = document.getElementById('menu-description');
var menu_make = document.getElementById('menu-make');
var menu_history = document.getElementById('menu-history');
var menu_price = document.getElementById('menu-price');
var menu_detail = document.getElementById('menu-detail');
var btn_close = document.getElementsByClassName("close")[0];

function get_url() {
  var url = window.location.href;
  if (!url) {
    url = document.url;
  }
  return url;
}

function get_acnhor(url) {
  var res = false;
  if (url !== '' || url !== false) {
    if (url.indexOf('#') !== -1) {
      res = url.substring(url.indexOf('#') + 1);
    }
  }
  return res;
}

function seq_search(data, id) {
  var res = false;
  for (i = 0; i < data.length; i++) {
    if (data[i].id == id) {
      res = data[i];
    }
  }
  return res;
}

function num_to_rp(num) {
  if (num) {
    return 'Rp' + num;
  }
}

function get_menu(tmp) {
  var result = false;
  if (!tmp) {
    var url = get_url();
    if (get_acnhor(url)) {
      tmp = alert(get_acnhor(url));
    }
  }
  var menu = seq_search(menus, tmp);
  if (menu) {
    if (menu_detail) {
      menu_title.innerHTML = menu.nama;
      menu_description.innerHTML = menu.deskripsi;
      menu_make.innerHTML = menu.cara;
      menu_history.innerHTML = menu.sejarah;
      menu_description.innerHTML = menu.deskripsi;
      menu_price.innerHTML = num_to_rp(menu.harga);
      menu_detail.style.display = "block";
    }
  }
  return result;
}

// When the user clicks on <span> (x), close the modal
if (btn_close) {
  btn_close.onclick = function() {
    menu_detail.style.display = "none";
  };
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == menu_detail) {
    menu_detail.style.display = "none";
  }
};

$(document).ready(function() {

  $('.carousel').carousel({
    interval: 5000,
    pause: 'hover',
    direction: 'right'
  });

  $('.slider-for').slick({
     slidesToScroll: 1,
     variableWidth: false,
     arrows: false,
     fade: true,
     asNavFor: '.slider-nav',
     autoplay: true,
     autoplaySpeed: 5000,
     centerMode: true,
     centerPadding: '60px',
  });

  $('.slider-nav').slick({
     slidesToShow: 3,
     slidesToScroll: 1,
     asNavFor: '.slider-for',
     dots: true,
     centerMode: true,
     focusOnSelect: true
  });


  /* check offset width
  var docWidth = document.documentElement.offsetWidth;

  [].forEach.call(
    document.querySelectorAll('*'),
    function(el) {
      if (el.offsetWidth > docWidth) {
        console.log(el);
      }
    }
  );
  */

});
