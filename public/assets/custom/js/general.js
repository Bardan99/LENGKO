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

function ajax_init() {
  if ($('.select2').length > 0) {
    $('.select2').select2({
      placeholder: '...',
      width: '100%'
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

  if ($('#material-management').length > 0) {
    $("#material-management").stacktable();
  }

  if ($('#transaciton-management').length > 0) {
    $("#transaciton-management").stacktable();
  }

  if ($('#transaciton-history-management').length > 0) {
    $("#transaciton-history-management").stacktable();
  }

  if ($('.stackable'.length > 0)) {
    $('.stackable').stacktable();
  }
}

function rewrite(type, param) {
  var res = false;
  switch (type) {
    case 'status-number':
      switch ($param) {
        case 0:
          res = 'Belum disetujui';
        break;
        case -1:
          res = 'Tidak disetujui';
        break;
        case 1:
          res = 'Disetujui';
        break;
      }
    break;
    case 'status':
      switch (param) {
        case '':
          res = '-';
        break;
        case 'C':
          res = 'Menunggu konfirmasi';
        break;
        case 'P':
          res = 'Sedang diproses';
        break;
        case 'T':
          res = 'Menunggu pembayaran';
        break;
        case 'D':
          res = 'Selesai diproses';
        break;
        default:res = '-';break;
      }
    break;
    default:break;
  }
  return res;
}

function generate_toast(data) {
  $.toast({
    heading: data.heading,
    text: data.text,
    icon: data.icon,
    bgColor: data.bgColor,
    textColor: data.textColor,
    loader: data.loader,
    loaderBg: data.loaderBg,
    showHideTransition: 'slide',
    hideAfter: data.hideAfter,
    allowToastClose: data.allowToastClose,
    stack: data.stack,
    position: 'bottom-right',
  });
}

/* PopOver Dismiss */

$('body').on('click', function (e) {
  $('[data-toggle="popover"]').each(function () {
    //the 'is' for buttons that trigger popups
    //the 'has' for icons within a button that triggers a popup
    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
        $(this).popover('hide');
    }
  });
});


$('body').on('click', function (e) {
  $('[data-toggle="tooltip"]').each(function () {
    //the 'is' for buttons that trigger popups
    //the 'has' for icons within a button that triggers a popup
    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.tooltip').has(e.target).length === 0) {
        $(this).tooltip('hide');
    }
  });
});

$(document).ready(function() {
  /* Tooltip */
  $('.open-tooltip').tooltip('show', {
    container: 'html',
    html: true,
    delay: { "show": 200, "hide": 500 },
  });

  $('[data-toggle="tooltip"]').tooltip({
    container: 'html',
    html: true,
    delay: { "show": 200, "hide": 500 },
  });

  $('.open-popover').popover('show', {
    container: 'html',
    html: true,
    delay: { "show": 200, "hide": 500 },
  });

  $('[data-toggle="popover"]').popover({
    container: 'html',
    html: true,
    delay: { "show": 200, "hide": 500 },
  });

  /* Type it settings */
  if ($('#brand-description').length > 0) {
    $('#brand-description').typeIt({
      startDelay: 100,
      speed: 80,
      deleteSpeed: 50,
      cursor: true,
      cursorSpeed: 800,
      breakDelay: 100,
      breakLines: true,
      deleteDelay: 50,
      callback: function() {
        setTimeout(function() {
          $('#brand-description').remove();
        }, 5000);
      }
    });
  }
  /* End of Type it settings */


  /* Select2 settings */
  if ($('.select2').length > 0) {
    $('.select2').select2({
      placeholder: '...',
      width: '100%'
    });
  }

  /* End of Select2 settings */

  if ($('.stackable').length > 0) {
    $('.stackable').stacktable();
  }

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
