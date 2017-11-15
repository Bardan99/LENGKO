
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

function chg_val(src, dst, max) { //src & dst = id
  var obj1 = document.getElementById(src);
  var obj2 = document.getElementById(dst);
  if (obj1 && obj2) {
    if (obj1.value >= max) {
      obj1.value = max;
    }
    if (obj1.value < 0) {
      obj1.value = 0;
    }
    obj2.value = max - obj1.value;

  }
}

function cash_back(src, dst, max) { //src & dst = id
  var obj1 = document.getElementById(src);
  var obj2 = document.getElementById(dst);
  if (obj1 && obj2) {
    if (obj1.value < max) {
      obj1.value = max;
    }
    obj2.value = obj1.value - max;
  }
}

function add_val(src, dst) {
  var obj1 = document.getElementById(src);
  var obj2 = document.getElementById(dst);
  if (obj1 && obj2) {
    obj2.value = $('#' + src + ' :selected').text();
  }
}

function add_element(target, data) { //currently unused
  var obj1 = document.getElementById(target);
  if (obj1 && data) {
    $('#' + target).append(data);
  }
}

function show_obj(id) {
  var obj = document.getElementById(id);
  if (obj) {
    $('#' + id).toggle('slow');
  }
}

$(document).ready(function() {

  /* Type it settings */
  if ($('#brand-description').length > 0) {
    $('#brand-description').typeIt({
      startDelay: 1000,
      speed: 80,
      deleteSpeed: 50,
      cursor: true,
      cursorSpeed: 800,
      breakDelay: 100,
      breakLines: true,
      deleteDelay: 50,
      callback: function() {
        setTimeout(function() {
          $('#brand-description').typeIt({
            strings: 'Love of Beauty is taste <br>The creation of Beauty is Art <small>~Ralph W.E</small>',
            startDelay: 500,
            callback: function() {
              setTimeout(function() {
                $('#brand-description').remove();
              }, 10000);
            }
          });
        }, 5000);
      }
    });
  }
  /* End of Type it settings */


  /* Select2 settings */
  if ($('.select2-bahan-baku').length > 0) {
    $('.select2-bahan-baku').select2({
      placeholder: 'Nama Bahan Baku',
    });
  }

  /* End of Select2 settings */

  var inc = 1;

  $('#btn-material-list-request').click(function() {
    inc += 1;
    $.ajax({
      type: "GET",
      url: "/ajax/object/bahan-baku/",
      data: {inc: inc},
      success: function(result) {
        var field = '<div class="row padd-lr-15"><div class="col-md-offset-2 col-md-6">';
        field += '<input type="text" id="material-name-' + inc + '" name="" class="input-lengko-default block" placeholder="Nama Bahan Baku" /></div>';
        field += '<div class="col-md-4"><div class="row"><div class="col-md-2 col-xs-12 col-sm-12 padd-lr-15">';
        field += '<button type="button" class="btn-lengko btn-lengko-default block" onclick="add_val(\'material-list-' + inc + '\', \'material-name-' + inc + '\');" style="height:42px; padding: 10px 5px 10px 5px; font-size: 13pt;">';
        field += '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;</button>';
        field += '</div><div class="col-md-10 col-xs-12 col-sm-12 padd-lr-15">';
        field += '<select id="material-list-' + inc + '" name="" class="select-lengko-default block" onchange="add_val(\'material-list-' + inc + '\', \'material-name-' + inc + '\');">';
        for (j = 0; j < result.data.material.length; j++) {
          field += '<option value="' + result.data.material[j].kode_bahan_baku + '">' + result.data.material[j].nama_bahan_baku + '</option>';
        }
        field +=  '</select>';
        field +=  '</div></div></div></div>';
        add_element('material-list-request', field);
      }
    });

  });

  if ($('.datepicker').length > 0) {
    $('.datepicker').datepicker({
      language: 'id-ID',
      format: 'dd/mm/yyyy',
      startDate: new Date(2017, 0, 1),
      endDate: new Date(2020, 0, 1),
      days: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
      daysShort: ['Ming','Sen','Sel','Rab','Kam','Jum','Sab'],
      daysMin: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
      weekStart: 1,
      months: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
      monthsShort: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']
    });
  }

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
