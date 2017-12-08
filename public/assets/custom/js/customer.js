function search_menu(data) {
  $.ajax({
    type: "POST",
    url: "/customer/search/menu",
    data: data,
    cache: false,
    success: function(result) {
      if (result.status == 500) {
        swal({
          title: "Oops terjadi kesalahan",
          html: result.text,
          type: "warning",
          timer: 10000,
          showCancelButton: false,
          confirmButtonText: 'Ok',
          confirmButtonColor: '#2c3e50',
        });
      }
      else if (result.status == 400) {
        swal({
          title: "Oops terjadi kesalahan",
          html: result.text,
          type: "error",
          timer: 10000,
          showCancelButton: false,
          confirmButtonText: 'Ok',
          confirmButtonColor: '#2c3e50',
        });
      }
      else {
        var res = '';
        if (result.content.length > 0) {
          for (i = 0; i < result.content.length; i++) {
            res += '<div class="col-md-4 col-sm-6" onclick="show_obj(\'menu-' + result.content[i].kode_menu + '\');">';
            res += '<div class="menu">';
            res += '<img src="/files/images/menus/';
            if (result.content[i].gambar_menu) {
              res += result.content[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }
            res += '" alt="' + result.content[i].nama_menu + '" width="100%" height="150px" />';
            res += '<h2 class="menu-title">' + result.content[i].nama_menu + '</h2>';
            res += 'Rp' + result.content[i].harga_menu;
            res += '<a href="/" class="pull-right"><i class="material-icons">add_shopping_cart</i></a>';
            res += '<br /></div></div>';
            /* overlay content */
            res += '<div id="menu-' + result.content[i].kode_menu + '" class="menu-overlay">';
            res += '<div class="row menu-overlay-content"><div class="col-md-12">';
            res += '<div class="row">  <div class="col-md-offset-11 col-md-1" style="font-size:20pt;">';
            res += '<span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj(\'menu-' + result.content[i].kode_menu + '\');"></span>';
            res += '</div></div>';
            res += '<div class="row"><div class="col-md-3">';
            res += '<img src="/files/images/menus/';
            if (result.content[i].gambar_menu) {
              res += result.content[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }
            res += '" alt="' + result.content[i].nama_menu + '" width="200px" height="200px" />';
            res += '</div><div class="col-md-9">';
            res += '<h2 class="menu-title">' + result.content[i].nama_menu + '</h2>';
            res += '<p>' + result.content[i].deskripsi_menu + '</p>';
            res += 'Rp' + result.content[i].harga_menu + '</div></div>';
            res += '<div class="row">';
            res += '<div class="col-md-offset-10 col-md-2">';
            res += '<div class="input-group">';
            res += '<input type="number" class="form-control input-lengko-default" placeholder="Jumlah" value="1" min="1" step="1">';
            res += '<div class="input-group-addon" style="background-color: #2c3e50; color: #ecf0f1">Tambah <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></div>';
            res += '</div></div></div>';
            res += '</div></div></div>';
          }
        }
        else {
          res = '<div class="padd-lr-15">Menu tidak ditemukan</div>';
        }
        $('#menu-card-section').html(res);
      }
    },
    error: function(result){

    }
  });
}//endfunction

function add_review(data) {

  swal({
    title: "Tambah kuisioner?",
    html: "",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {

      $.ajax({
        type: "POST",
        url: "/customer/create/review",
        data: data,
        cache: false,
        success: function(result) {
          console.log(result);
          if (result.status == 200) {
            swal({
              title: "Berhasil menambah kuisioner",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/reviews';
              }
            });
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.text,
              type: "warning",
              timer: 10000,
              showCancelButton: false,
              confirmButtonText: 'Ok',
              confirmButtonColor: '#2c3e50',
            });
          }
        },
        error: function(result){

        }
      });

    }
  });
}//end

function add_menu(menu) {
  var name = $('input[name=order-add-name-' + menu + ']').val();
  var count = $('input[name=order-add-count-' + menu + ']').val();
  var data = {
    '_token' : $('input[name=_token]').val(),
    '_id' : menu,
    '_count' : count,
  };

  swal({
    title: "Tambah pesanan?",
    html: "Kamu yakin akan menambahkan " + name + "<br /> sebanyak " + count + " porsi? <br />Yakin gak akan kurang nihh?",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Tambahkan',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Batalkan'
  }).then(function(result) {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "/customer/add/menu",
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            swal({
              title: "Berhasil menambah menu",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/menu';
              }
            });
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.text,
              type: "warning",
              timer: 10000,
              showCancelButton: false,
              confirmButtonText: 'Ok',
              confirmButtonColor: '#2c3e50',
            });
          }
        },
        error: function(result){

        }
      });

    }
  });
}//end

$(document).ready(function() {

  /* menu */

  if ($('input[name=menu-search-query]').length > 0) {
    $('input[name=menu-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'menu-search-query' : $("input[name=menu-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };

      search_menu(data);
    });
  }

  if ($('button[name=menu-search-button]')) {
    $('button[name=menu-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        'menu-search-query' : $("input[name=menu-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };

      search_menu(data);
    });
  }

  /* reviews */

  if ($('button[name=review-create-btn]').length > 0) {
    $('button[name=review-create-btn]').on('click', function(e) {
      e.preventDefault();
      var id = [];
      var ratting = [];
      for (i = 0; i < $("input[name=_rattings]").val(); i++) {
        id[i] = $("input[name=review-create-rating-id-" + i + "]").val();
        ratting[i] = $("select[name=review-create-rating-" + i + "]").val();
      }
      var data = {
        '_name' : $("input[name=review-create-name]").val(),
        '_msg' : $("textarea[name=review-create-message]").val(),
        '_id' : id,
        '_ratting' : ratting,
        '_method' : "post",
        '_token' : $("input[name=_token]").val()
      };

      add_review(data);
    });
  }
});