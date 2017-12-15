function call_waiter(device) {
  var data = {
    '_method' : "post",
    '_token' : $("input[name=_token]").val(),
    '_id' : device
  };
  swal({
    title: "Butuh bantuan?",
    text: "Jangan sungkan, kami siap membantu (^_^)/",
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
        url: "/customer/notif/help",
        data: data,
        cache: false,
        success: function(result) {
          console.log(result);
          if (result) {
            if (result.status == 200) {
              swal({
                title: 'Segera ke sana!',
                html: 'Kalau disamperin jangan salting ya >_<',
                type: 'success',
                timer: 3000
              });
            }
            else {
              swal({
                title: 'Oops terjadi sesuatu',
                html: 'Gagal menghubungi pelayan',
                type: 'warning',
                timer: 3000
              });
            }
          }
          else {
            swal({
              title: 'Waduhh',
              html: 'Oops terjadi sesuatu',
              type: 'warning',
              timer: 3000
            });
          }
        }
      });

    }
  });
}


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
        if (result.content) {
          res += '<div class="row">';
          for (i = 0; i < result.content.length; i++) {
            var status = 'Tidak tersedia';
            var tmp = false;
            var k = 0;
            for (j = 0; j < result.available[i]['menu-status'].length; j++) {
              k++;
              if (result.available[j]['menu-status'].stok_bahan_baku > 0) {
                tmp = true;
              }
              else {
                tmp = false;
                break;
              }
            }

            if (k == result.available[i]['menu-status'].length) {
              if (tmp) {
                status = 'Tersedia';
              }
            }

            res += '<div class="col-md-4 col-sm-6">';
            res += '<div class="menu" onclick="show_obj(\'menu-' + result.content[i].kode_menu + '\');">';
            res += '<img class="hoverblur" src="/files/images/menus/';
            if (result.content[i].gambar_menu) {
              res += result.content[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }
            res += '" alt="' + result.content[i].nama_menu + '" width="100%" height="150px" />';
            res += '<h2 class="menu-title">' + result.content[i].nama_menu + ' <small>(' + status + ')</small></h2>';

            res += '<div class="row"><div class="col-md-6">Rp' + result.content[i].harga_menu;
            res += '</div><div class="col-md-6">';
            res += '<a href="#!" class="pull-right"><i class="material-icons md-36">';
            if (status == 'Tersedia') {
              res += 'add_circle_outline';
            }
            else {
              res += 'report';
            }
            res += '</i></a>';
            res += '</div></div>';

            res += '</div></div>';
            /* overlay content */

            res += '<div id="menu-' + result.content[i].kode_menu + '" class="menu-overlay">';
            res += '<div class="row menu-overlay-content"><div class="col-md-12">';
            res += '<div class="row">  <div class="col-md-offset-11 col-md-1" style="font-size:20pt;">';
            res += '<span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj(\'menu-' + result.content[i].kode_menu + '\');"></span>';
            res += '</div></div>';
            res += '<div class="row"><div class="col-md-3">';
            res += '<img class="hoverblur" src="/files/images/menus/';
            if (result.content[i].gambar_menu) {
              res += result.content[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }
            res += '" alt="' + result.content[i].nama_menu + '" width="200px" height="200px" />';
            res += '</div><div class="col-md-9">';
            res += '<h2 class="menu-title">' + result.content[i].nama_menu + ' <small>(' + status + ')</small></h2>';
            res += '<p>' + result.content[i].deskripsi_menu + '</p>';
            res += 'Rp' + result.content[i].harga_menu + '</div></div>';
            if (status == 'Tersedia') {
              res += '<div class="row">';
              res += '<div class="col-md-offset-10 col-md-2">';
              res += '<div class="input-group">';
              res += '<input type="hidden" name="order-add-name-' + result.content[i].kode_menu + '" value="' + result.content[i].nama_menu + '">';
              res += '<input type="number" name="order-add-count-' + result.content[i].kode_menu + '" class="form-control input-lengko-default" placeholder="Jumlah" value="1" min="1" step="1">';
              res += '<div class="input-group-addon" style="background-color: #2c3e50; color: #ecf0f1" onclick="add_menu(\'' + result.content[i].kode_menu + '\')">Tambah <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></div>';
              res += '</div></div></div>';
            }
            res += '</div></div></div>';

          }//end loop
          res += '</div>';

          /* nav pagination */
          res += '<div class="row"><div class="col-sm-12 col-md-push-4 col-md-4">';
          res += '<nav aria-label="Page navigation" class="text-center"><ul class="pagination pagination-lg">';
          res += '<li class="cursor-pointer ';
          if (result.prev.length > 0 && result.pointer.prev.skip >= 0) {
              res += '" onclick="pagination_menu(' + result.pointer.prev.skip + ', ' + result.pointer.prev.take + ');"><span aria-hidden="true">&laquo;</span></li>';
          }
          else {
            res +=' disabled"><span aria-hidden="true">&laquo;</span></li>';
          }
          res += '<li class="cursor-pointer"><span aria-hidden="true">&nbsp;</span></li>';
          res += '<li class="cursor-pointer';
          if (result.next.length > 0) {
            res += '" onclick="pagination_menu(' + result.pointer.next.skip + ', ' + result.pointer.next.take + ');"><span aria-hidden="true">&raquo;</span></li>';
          }
          else {
            res +=' disabled"><span aria-hidden="true">&raquo;</span></li>';
          }
          res += '</ul></nav></div></div>';
          /* end of nav pagination */
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-offset-2 col-md-8">';
          res += '<div class="alert alert-warning">Menu tidak ditemukan</div></div></div>';
        }
        $('#menu-card-section').html(res);
      }
    },
    error: function(result){

    }
  });
}//endfunction

function pagination_menu(skip, take) {
  var data = {
    '_method' : "post",
    '_token' : $("input[name=_token]").val(),
    '_keyword' : $("input[name=menu-search-query]").val(),
    '_category' : $("select[name=menu-search-type]").val(),
    '_skip': skip,
    '_take': take
  };

  $.ajax({
    type: "POST",
    url: "/customer/page/menu",
    data: data,
    cache: false,
    success: function(result) {
      if (result.status == 500 || result.status == 400) {
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
      else {
        var res = '';
        if (result.content) {
          res += '<div class="row">';
          for (i = 0; i < result.content.length; i++) {
            var status = 'Tidak tersedia';
            var tmp = false;
            var k = 0;
            for (j = 0; j < result.available[i]['menu-status'].length; j++) {
              k++;
              if (result.available[j]['menu-status'].stok_bahan_baku > 0) {
                tmp = true;
              }
              else {
                tmp = false;
                break;
              }
            }

            if (k == result.available[i]['menu-status'].length) {
              if (tmp) {
                status = 'Tersedia';
              }
            }

            res += '<div class="col-md-4 col-sm-6">';
            res += '<div class="menu" onclick="show_obj(\'menu-' + result.content[i].kode_menu + '\');">';
            res += '<img class="hoverblur" src="/files/images/menus/';
            if (result.content[i].gambar_menu) {
              res += result.content[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }
            res += '" alt="' + result.content[i].nama_menu + '" width="100%" height="150px" />';
            res += '<h2 class="menu-title">' + result.content[i].nama_menu + ' <small>(' + status + ')</small></h2>';

            res += '<div class="row"><div class="col-md-6">Rp' + result.content[i].harga_menu;
            res += '</div><div class="col-md-6">';
            res += '<a href="#!" class="pull-right"><i class="material-icons md-36">';
            if (status == 'Tersedia') {
              res += 'add_circle_outline';
            }
            else {
              res += 'report';
            }
            res += '</i></a>';
            res += '</div></div>';

            res += '</div></div>';
            /* overlay content */

            res += '<div id="menu-' + result.content[i].kode_menu + '" class="menu-overlay">';
            res += '<div class="row menu-overlay-content"><div class="col-md-12">';
            res += '<div class="row">  <div class="col-md-offset-11 col-md-1" style="font-size:20pt;">';
            res += '<span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj(\'menu-' + result.content[i].kode_menu + '\');"></span>';
            res += '</div></div>';
            res += '<div class="row"><div class="col-md-3">';
            res += '<img class="hoverblur" src="/files/images/menus/';
            if (result.content[i].gambar_menu) {
              res += result.content[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }
            res += '" alt="' + result.content[i].nama_menu + '" width="200px" height="200px" />';
            res += '</div><div class="col-md-9">';
            res += '<h2 class="menu-title">' + result.content[i].nama_menu + ' <small>(' + status + ')</small></h2>';
            res += '<p>' + result.content[i].deskripsi_menu + '</p>';
            res += 'Rp' + result.content[i].harga_menu + '</div></div>';
            if (status == 'Tersedia') {
              res += '<div class="row">';
              res += '<div class="col-md-offset-10 col-md-2">';
              res += '<div class="input-group">';
              res += '<input type="hidden" name="order-add-name-' + result.content[i].kode_menu + '" value="' + result.content[i].nama_menu + '">';
              res += '<input type="number" name="order-add-count-' + result.content[i].kode_menu + '" class="form-control input-lengko-default" placeholder="Jumlah" value="1" min="1" step="1">';
              res += '<div class="input-group-addon" style="background-color: #2c3e50; color: #ecf0f1" onclick="add_menu(\'' + result.content[i].kode_menu + '\')">Tambah <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></div>';
              res += '</div></div></div>';
            }
            res += '</div></div></div>';

          }//end loop
          res += '</div>';

          /* nav pagination */
          res += '<div class="row"><div class="col-sm-12 col-md-push-4 col-md-4">';
          res += '<nav aria-label="Page navigation" class="text-center"><ul class="pagination pagination-lg">';
          res += '<li class="cursor-pointer ';
          if (result.prev.length > 0 && result.pointer.prev.skip >= 0) {
              res += '" onclick="pagination_menu(' + result.pointer.prev.skip + ', ' + result.pointer.prev.take + ');"><span aria-hidden="true">&laquo;</span></li>';
          }
          else {
            res +=' disabled"><span aria-hidden="true">&laquo;</span></li>';
          }
          res += '<li class="cursor-pointer"><span aria-hidden="true">&nbsp;</span></li>';
          res += '<li class="cursor-pointer';
          if (result.next.length > 0) {
            res += '" onclick="pagination_menu(' + result.pointer.next.skip + ', ' + result.pointer.next.take + ');"><span aria-hidden="true">&raquo;</span></li>';
          }
          else {
            res +=' disabled"><span aria-hidden="true">&raquo;</span></li>';
          }
          res += '</ul></nav></div></div>';
          /* end of nav pagination */
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-offset-2 col-md-8">';
          res += '<div class="alert alert-warning">Menu tidak ditemukan</div></div></div>';
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
    title: "Kirim kuisioner?",
    html: "Kami yakin dan percaya bahwa kamu terbaik",
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
  if (count >= 1) {
    swal({
      title: name,
      html: "Tambahkan " + count + " porsi? <br />Yakin gak akan kurang nihh?",
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
  }
  else {
    swal({
      title: "Oops terjadi kesalahan",
      html: "Jangan bandell yaa.. <br />Minimal beli 1, atau borong semua juga boleh!",
      type: "warning",
      timer: 10000,
      showCancelButton: false,
      confirmButtonText: 'Ok',
      confirmButtonColor: '#2c3e50',
    });
  }
}//end

function remove_menu(id, name) {
  var data = {
    '_token' : $('input[name=_token]').val(),
    '_id' : id,
  };

  swal({
    title: "Batalkan pesanan?",
    html: "Hapus pesanan " + name + " dari daftar pesanan?",
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
        url: "/customer/remove/menu",
        data: data,
        cache: false,
        success: function(result) {

          if (result.status == 200) {
            swal({
              title: "Berhasil membatalkan pesanan",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/order';
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

function change_menu(id, count) {
  var data = {
    '_token' : $('input[name=_token]').val(),
    '_id' : id,
    '_count' : count,
  };

  $.ajax({
    type: "POST",
    url: "/customer/change/menu",
    data: data,
    cache: false,
    success: function(result) {
      if (result.status == 200) {

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

}//end

function create_order(data) {

  swal({
    title: "Lanjutkan proses pemesanan?",
    html: "Pesanan yang sudah diproses tidak dapat dibatalkan.",
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
        url: "/customer/create/order",
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            swal({
              title: "Berhasil melakukan pemesanan",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/order';
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

function finish_order() {

  swal({
    title: "Isi kuisioner",
    html: "Sebelum melanjutkan proses pembayaran, apakah kamu mau mengisi kuisioner?",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      if (result.value) {
        swal({
          title: "Terima kasih",
          html: "Kamu akan diarahkan ke menu kuisioner <br /> Silahkan isi kuisioner dan lanjutkan pembayaran di kasir atau melalui pelayan (^^)",
          type: "success",
          showCancelButton: false,
          confirmButtonText: 'OK',
          confirmButtonColor: '#2c3e50',
        }).then(function(result) {
          if (result.value) {
            window.location = '/reviews';
          }
        });
      }
    }
    else {
      swal({
        title: "Lanjutkan pembayaran",
        html: "Silahkan lanjutkan proses pembayaran di kasir atau melalui pelayan (^^)",
        type: "success",
        showCancelButton: false,
        confirmButtonText: 'OK',
        confirmButtonColor: '#2c3e50',
      });
    }
  });
}//end

function filter_menu(data) {
  $.ajax({
    type: "POST",
    url: "/customer/filter/menu",
    data: data,
    cache: false,
    success: function(result) {
      if (result.status == 200) {
        var res = '';
        if (result.content.length > 0) {
          res += '<div class="row">';
          for (i = 0; i < result.content.length; i++) {
            var status = 'Tidak tersedia';
            var tmp = false;
            for (j = 0; j < result.available[i]['menu-status'].length; j++) {
              i++;
              if (result.available[i]['menu-status'].stok_bahan_baku > 0) {
                tmp = true;
              }
              else {
                tmp = false;
                break;
              }
            }

            if (i == result.available[i]['menu-status'].length) {
              if (tmp) {
                status = 'Tersedia';
              }
            }

            res += '<div class="col-md-4 col-sm-6" onclick="show_obj(\'menu-' + result.content[i].kode_menu + '\');">';
            res += '<div class="menu">';
            res += '<img class="hoverblur" src="/files/images/menus/';
            if (result.content[i].gambar_menu) {
              res += result.content[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }
            res += '" alt="' + result.content[i].nama_menu + '" width="100%" height="150px" />';
            res += '<h2 class="menu-title">' + result.content[i].nama_menu + ' <small>(' + status + ')</small></h2>';

            res += '<div class="row"><div class="col-md-6">Rp' + result.content[i].harga_menu;
            res += '</div><div class="col-md-6">';
            res += '<a href="#!" class="pull-right"><i class="material-icons md-36">';
            if (status == 'Tersedia') {
              res += 'add_circle_outline';
            }
            else {
              res += 'report';
            }
            res += '</i></a>';
            res += '</div></div>';

            res += '</div></div>';
            /* overlay content */

            res += '<div id="menu-' + result.content[i].kode_menu + '" class="menu-overlay">';
            res += '<div class="row menu-overlay-content"><div class="col-md-12">';
            res += '<div class="row">  <div class="col-md-offset-11 col-md-1" style="font-size:20pt;">';
            res += '<span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj(\'menu-' + result.content[i].kode_menu + '\');"></span>';
            res += '</div></div>';
            res += '<div class="row"><div class="col-md-3">';
            res += '<img class="hoverblur" src="/files/images/menus/';
            if (result.content[i].gambar_menu) {
              res += result.content[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }
            res += '" alt="' + result.content[i].nama_menu + '" width="200px" height="200px" />';
            res += '</div><div class="col-md-9">';
            res += '<h2 class="menu-title">' + result.content[i].nama_menu + ' <small>(' + status + ')</small></h2>';
            res += '<p>' + result.content[i].deskripsi_menu + '</p>';
            res += 'Rp' + result.content[i].harga_menu + '</div></div>';
            if (status == 'Tersedia') {
              res += '<div class="row">';
              res += '<div class="col-md-offset-10 col-md-2">';
              res += '<div class="input-group">';
              res += '<input type="hidden" name="order-add-name-' + result.content[i].kode_menu + '" value="' + result.content[i].nama_menu + '">';
              res += '<input type="number" name="order-add-count-' + result.content[i].kode_menu + '" class="form-control input-lengko-default" placeholder="Jumlah" value="1" min="1" step="1">';
              res += '<div class="input-group-addon" style="background-color: #2c3e50; color: #ecf0f1" onclick="add_menu(\'' + result.content[i].kode_menu + '\')">Tambah <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></div>';
              res += '</div></div></div>';
            }
            res += '</div></div></div>';

          }//end loop
          res += '</div>';

          /* nav pagination */
          res += '<div class="row"><div class="col-sm-12 col-md-push-4 col-md-4">';
          res += '<nav aria-label="Page navigation" class="text-center"><ul class="pagination pagination-lg">';
          res += '<li class="cursor-pointer ';
          if (result.prev.length > 0 && result.pointer.prev.skip >= 0) {
              res += '" onclick="pagination_menu(' + result.pointer.prev.skip + ', ' + result.pointer.prev.take + ');"><span aria-hidden="true">&laquo;</span></li>';
          }
          else {
            res +=' disabled"><span aria-hidden="true">&laquo;</span></li>';
          }
          res += '<li class="cursor-pointer"><span aria-hidden="true">&nbsp;</span></li>';
          res += '<li class="cursor-pointer';
          if (result.next.length > 0) {
            res += '" onclick="pagination_menu(' + result.pointer.next.skip + ', ' + result.pointer.next.take + ');"><span aria-hidden="true">&raquo;</span></li>';
          }
          else {
            res +=' disabled"><span aria-hidden="true">&raquo;</span></li>';
          }
          res += '</ul></nav></div></div>';
          /* end of nav pagination */
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-offset-2 col-md-8">';
          res += '<div class="alert alert-warning">Menu tidak ditemukan</div></div></div>';
        }
        $('#menu-card-section').html(res);
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

$(document).ready(function() {

  /* menu */

  if ($('input[name=menu-search-query]').length > 0) {
    $('input[name=menu-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'menu-search-query' : $("input[name=menu-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=_token]").val()
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
        '_token' : $("input[name=_token]").val()
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

  /* order */

  if ($('button[name=order-create-button]')) {
    $('button[name=order-create-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        '_name' : $("input[name=order-create-name]").val(),
        '_addition' : $("textarea[name=order-create-addition]").val(),
        '_method' : "post",
        '_token' : $("input[name=_token]").val()
      };

      create_order(data);
    });
  }

  /* menu */
  if ($('select[name=menu-search-type]')) {
    $('select[name=menu-search-type]').on('change', function(e) {
      e.preventDefault();
      var data = {
        '_keyword' : $("select[name=menu-search-type]").val(),
        '_method' : "post",
        '_token' : $("input[name=_token]").val()
      };

      filter_menu(data);
    });
  }

});
