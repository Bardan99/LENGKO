/* local db */

var menu_detail = document.getElementById('menu-detail');
var menu_title = document.getElementById('menu-title');
var menu_description = document.getElementById('menu-description');
var menu_make = document.getElementById('menu-make');
var menu_history = document.getElementById('menu-history');
var menu_price = document.getElementById('menu-price');
var menu_detail = document.getElementById('menu-detail');
var btn_close = document.getElementsByClassName("close")[0];

function go_to(url) {
  if (url) {
    window.location = '/' + url;
  }
}

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

  $('.slider-for').slick({
     slidesToScroll: 1,
     variableWidth: false,
     arrows: false,
     fade: true,
     asNavFor: '.slider-nav',
     autoplay: true,
     autoplaySpeed: 3000,
     centerMode: true,
     centerPadding: '60px',
  });

  $('.slider-nav').slick({
     slidesToShow: 4,
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
