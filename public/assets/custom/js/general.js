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

function chg_val(src, dst, max, add) { //src & dst = id
  var obj1 = document.getElementById(src);
  var obj2 = document.getElementById(dst);
  if (obj1 && obj2) {
    if (obj1.value >= max) {
      obj1.value = add + '' + max;
    }
    if (obj1.value < 0) {
      obj1.value = 0;
    }
    obj2.value = add + '' +  (max - obj1.value);

  }
}

function multiply_val(src, dst, by, add) {
  var obj1 = document.getElementById(src);
  var obj2 = document.getElementById(dst);
  if (obj1 && obj2) {
    obj2.value = add + '' + (obj1.value * by);
  }
}

function set_point(src, val) {
  var obj1 = document.getElementById(src);
  if (obj1) {
   obj1.value = val;
  }
}

function cash_back(src, dst, max, add) { //src & dst = id
  var obj1 = document.getElementById(src);
  var obj2 = document.getElementById(dst);
  if (obj1 && obj2) {
    if (obj1.value < max) {
      obj1.value = add + '' + (max);
    }
    obj2.value = add + '' + (obj1.value - max);
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

function hide_obj(id) {
  var obj = document.getElementById(id);
  if (obj) {
    $('#' + id).hide('slow');
  }
}

function truggle(selector) {
  if ($('input[name=' + selector + ']').val() == 1) {
    $('input[name=' + selector + ']').val(0);
  }
  else {
    $('input[name=' + selector + ']').val(1);
  }
}

/* custome preview image for dynamic purposes */
function reload_image(input, target) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $(target).attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
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

  var inc = 0;

  $('#btn-material-list-request').click(function() {
    inc += 1;
    $.ajax({
      type: "GET",
      url: "/ajax/object/bahan-baku/",
      data: {inc: inc},
      success: function(result) {
        var field = '<div class="row padd-lr-15"><div class="col-md-offset-2 col-md-6">';
        field += '<input type="text" id="material-request-create-item-' + inc + '" name="material-request-create-item-' + inc + '" class="input-lengko-default block" placeholder="Nama Bahan Baku" /></div>';
        field += '<div class="col-md-4"><div class="row"><div class="col-md-2 col-xs-12 col-sm-12 padd-lr-15">';
        field += '<button type="button" class="btn-lengko btn-lengko-default block" onclick="add_val(\'material-list-' + inc + '\', \'material-request-create-item-' + inc + '\');" style="height:42px; padding: 10px 5px 10px 5px; font-size: 13pt;">';
        field += '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;</button>';
        field += '</div><div class="col-md-10 col-xs-12 col-sm-12 padd-lr-15">';
        field += '<select id="material-list-' + inc + '" name="" class="select-lengko-default block" onchange="add_val(\'material-list-' + inc + '\', \'material-request-create-item-' + inc + '\');">';
        for (j = 0; j < result.data.material.length; j++) {
          field += '<option value="' + result.data.material[j].kode_bahan_baku + '">' + result.data.material[j].nama_bahan_baku + '</option>';
        }
        field +=  '</select>';
        field +=  '</div></div></div></div>';
        add_element('material-list-request', field);
        $('input[name=material-request-create-max]').val(inc);
      }
    });

  });

  if ($('.datepicker').length > 0) {
    $('.datepicker').datepicker({
      language: 'id-ID',
      format: 'yyyy-mm-dd',
      startDate: new Date(2014, 0, 1),
      endDate: new Date(2020, 0, 1),
      days: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
      daysShort: ['Ming','Sen','Sel','Rab','Kam','Jum','Sab'],
      daysMin: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
      weekStart: 1,
      months: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
      monthsShort: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']
    });
  }

  if ($('.slider-for').length > 0 && $('.slider-nav').length > 0) {
    $('.slider-for').slick({
       slidesToScroll: 1,
       variableWidth: false,
       arrows: false,
       fade: true,
       asNavFor: '.slider-nav',
       autoplay: true,
       autoplaySpeed: 10000,
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
  }

  if ($('.barrating').length > 0) {
    $('.barrating').barrating({
      theme: 'fontawesome-stars',
      allowEmpty: true,
      showValues: false
    });
  }

  if ($('.barrating-readonly').length > 0) {
    $('.barrating-readonly').barrating({
      theme: 'fontawesome-stars',
      showValues: false,
      readonly: true
    });
  }
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
