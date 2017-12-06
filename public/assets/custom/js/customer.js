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
            res += '<div class="input-group-addon" style="background-color: #2c3e50; color: #ecf0f1"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>';
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
});
