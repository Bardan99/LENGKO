function decline_material(id) {
  swal({
    title: "Tolak pengajuan",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      data = {
        '_id' : id,
        '_method' : "post",
        '_token' : $('input[name="material-request-detail-token"]').val()
      };

      $.ajax({
        type: "POST",
        url: "/dashboard/decline/material",
        data: data,
        cache: false,
        success: function(result) {

          if (result.status == 200) {
            swal({
              title: "Berhasil menolak permintaan pengajuan bahan baku",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/material/';
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
      });//end ajax
    }//endif
  });//endswal
}//end


function confirm_material(id) {
  //var id = $('input[name=material-request-detail-id]').val();
  var max = $('input[name=material-request-detail-max-' + id + ']').val();
  if (max > 0) {
    swal({
      title: "Setujui pengajuan?",
      type: "question",
      timer: 10000,
      showCancelButton: true,
      confirmButtonText: 'Iya',
      confirmButtonColor: '#2c3e50',
      cancelButtonText: 'Tidak'
    }).then(function(result) {
      if (result.value) {
        var data = [];
        for (i = 0; i < max; i++) {
          data = data.concat ({
            'material-request-detail-id' : $('input[name=material-request-detail-id-' + id + '-' + i + ']').val(),
            'material-request-detail-name' : $('input[name=material-request-detail-name-' + id + '-' + i + ']').val(),
            'material-request-detail-count' : $('input[name=material-request-detail-count-' + id + '-' + i + ']').val(),
            'material-request-detail-unit' : $('input[name=material-request-detail-unit-' + id + '-' + i + ']').val(),
            'material-request-detail-date' : $('input[name=material-request-detail-date-' + id + '-' + i + ']').val()
          });
        }

        data = {
          '_id' : id,
          '_data' : data,
          '_method' : "post",
          '_token' : $('input[name="material-request-detail-token"]').val()
        };

        $.ajax({
          type: "POST",
          url: "/dashboard/create/materialrequest",
          data: data,
          cache: false,
          success: function(result) {
            if (result.status == 200) {
              swal({
                title: "Pengajuan berhasil diterima",
                text: result.text,
                type: "success",
                timer: 30000
              }).then(function(result) {
                if (result.value) {
                  window.location = '/dashboard/material/';
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
      html: "Silahkan pilih bahan baku untuk diproses.",
      type: "warning",
      timer: 10000,
      showCancelButton: false,
      confirmButtonText: 'Ok',
      confirmButtonColor: '#2c3e50',
    });
  }//end if > 0
}//end


function delete_menu(id) {
  swal({
    title: "Hapus menu?",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      data = {
        '_id' : id,
        '_method' : "delete",
        '_token' : $('input[name="search_token"]').val()
      };

      $.ajax({
        type: "POST",
        url: "/dashboard/delete/menu/" + id,
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            swal({
              title: "Berhasil menghapus menu",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/menu/';
              }
            });
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.text,
              type: "warning",
              timer: 10000,
              confirmButtonText: 'Ok',
              confirmButtonColor: '#2c3e50',
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/menu/';
              }
            });
          }
        },
        error: function(result){

        }
      });//end ajax
    }//endif
  });//endswal
}

function done_order(id) {
  swal({
    title: "Tandai pesanan selesai dibuat?",
    html: "Tandai seluruh pesanan selesai dibuat",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      var data = {
        '_id' : id,
        '_method' : "get",
        '_token' : $('input[name="search_token"]').val()
      };

      $.ajax({
        type: "POST",
        url: "/dashboard/update/order/" + id,
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            swal({
              title: "Berhasil mengubah status pesanan.",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/order/';
              }
            });
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.text,
              type: "warning",
              timer: 10000,
              confirmButtonText: 'Ok',
              confirmButtonColor: '#2c3e50',
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/order/';
              }
            });
          }
        },
        error: function(result){

        }
      });//end ajax
    }//endif
  });//endswal
}

function done_menu(id) {
  swal({
    title: "Tandai menu selesai dibuat?",
    html: "Tandai menu telah selesai dibuat",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      var data = {
        '_id' : id,
        '_method' : "get",
        '_token' : $('input[name="search_token"]').val()
      };

      $.ajax({
        type: "POST",
        url: "/dashboard/update/ordermenu/" + id,
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            swal({
              title: "Berhasil mengubah status pesanan menu.",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/order/';
              }
            });
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.text,
              type: "warning",
              timer: 10000,
              confirmButtonText: 'Ok',
              confirmButtonColor: '#2c3e50',
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/order/';
              }
            });
          }
        },
        error: function(result){

        }
      });//end ajax
    }//endif
  });//endswal
}

function done_transaction(id, min) {
  var cash = $('input[name="transaction-cash-' + id + '"]').val();
  if (cash >= min) {
    swal({
      title: "Transaksi selesai?",
      html: "Lakukan pembayaran terhadap pesanan ini?",
      type: "question",
      timer: 10000,
      showCancelButton: true,
      confirmButtonText: 'Iya',
      confirmButtonColor: '#2c3e50',
      cancelButtonText: 'Tidak'
    }).then(function(result) {
      if (result.value) {
        var data = {
          '_id' : id,
          '_cash' : $('input[name="transaction-cash-' + id + '"]').val(),
          '_method' : "get",
          '_token' : $('input[name="search_token"]').val()
        };

        $.ajax({
          type: "POST",
          url: "/dashboard/update/transaction/" + id + "/" + cash,
          data: data,
          cache: false,
          success: function(result) {
            if (result.status == 200) {
              swal({
                title: "Berhasil melakukan pembayaran",
                text: result.text,
                type: "success",
                timer: 30000
              }).then(function(result) {
                if (result.value) {
                  window.location = '/dashboard/transaction/';
                }
              });
            }
            else {
              swal({
                title: "Oops terjadi kesalahan",
                html: result.text,
                type: "warning",
                timer: 10000,
                confirmButtonText: 'Ok',
                confirmButtonColor: '#2c3e50',
              }).then(function(result) {
                if (result.value) {
                  window.location = '/dashboard/transaction/';
                }
              });
            }
          },
          error: function(result){

          }
        });//end ajax
      }//endif
    });//endswal
  }
  else {
    swal({
      title: "Oops terjadi kesalahan",
      html: "Biaya yang dibayarkan kurang dari yang seharusnya",
      type: "warning",
      timer: 10000,
      confirmButtonText: 'Ok',
      confirmButtonColor: '#2c3e50',
    });
  }
}

function delete_review(id) {
  swal({
    title: "Hapus kuisioner?",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      data = {
        '_id' : id,
        '_method' : "delete",
        '_token' : $('input[name="search_token"]').val()
      };

      $.ajax({
        type: "POST",
        url: "/dashboard/delete/review/" + id,
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            swal({
              title: "Berhasil menghapus kuisioner",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/review/';
              }
            });
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.text,
              type: "warning",
              timer: 10000,
              confirmButtonText: 'Ok',
              confirmButtonColor: '#2c3e50',
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/review/';
              }
            });
          }
        },
        error: function(result){

        }
      });//end ajax
    }//endif
  });//endswal
}

function delete_review_device(id) {
  swal({
    title: "Hapus hasil kuisioner?",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      data = {
        '_id' : id,
        '_method' : "delete",
        '_token' : $('input[name="search_token"]').val()
      };

      $.ajax({
        type: "POST",
        url: "/dashboard/delete/reviewdevice/" + id,
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            swal({
              title: "Berhasil menghapus kuisioner",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/review/';
              }
            });
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.text,
              type: "warning",
              timer: 10000,
              confirmButtonText: 'Ok',
              confirmButtonColor: '#2c3e50',
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/review/';
              }
            });
          }
        },
        error: function(result){

        }
      });//end ajax
    }//endif
  });//endswal
}

function search_device(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/search/device",
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
          var token = $('input[name=search_token]').val();
          for (i = 0; i < result.content.length; i++) {
            if (result.auth == 'root') {
              res += '<form id="device-card-change-' + result.content[i].kode_perangkat + '" action="/dashboard/update/device" method="POST" hidden="hidden">';
              res += '<div class="col-md-3 col-sm-6 col-xs-12">';
              res += '<div class="device device-' + result.content[i].status_text + '">';
              res += '<div class="device-title row"><div class="col-md-12">';
              res += '<input type="text" name="device-change-name" class="input-lengko-default block" value="' + result.content[i].nama_perangkat + '" />';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-12">';
              res += 'Kapasitas: <input type="number" name="device-change-chair" min="1" class="input-lengko-default" value="' + result.content[i].jumlah_kursi_perangkat + '" /> Orang<br />';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-12">Status:';
              res += '<select name="device-change-status" class="select-lengko-default">';
              res += '<option value="0">Tidak Tersedia</option>';
              res += '<option value="1">Tersedia</option>';
              res += '</select>';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-12">Kata sandi:';
              res += '<input type="password" name="device-change-password" class="input-lengko-default block" placeholder="(tidak diubah, kosongkan)" />';
              res += '<hr /></div></div>';
              res += '<div class="row"><div class="col-md-6 col-xs-6">';
              res += '<form action="/dashboard/delete/device/' + result.content[i].kode_perangkat + '" method="POST">';
              res += '<button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj(\'device-card-' + result.content[i].kode_perangkat + '\'); hide_obj(\'device-card-change-' + result.content[i].kode_perangkat + '\');">';
              res += '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>';
              res += '</button><button class="btn-lengko btn-lengko-default" type="submit">';
              res += '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
              res += '</button>';
              res += '<input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="DELETE">';
              res += '</form></div>';
              res += '<div class="col-md-6 col-xs-6">';
              res += '<button class="btn-lengko btn-lengko-default pull-right" type="submit">';
              res += '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>';
              res += '</button>';
              res += '<input type="hidden" name="device-id" value="' + result.content[i].kode_perangkat + '" />';
              res += '<input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="PUT"></div></div></div></div></form>';
            }

            res += '<div id="device-card-' + result.content[i].kode_perangkat + '" class="col-md-3 col-sm-6 col-xs-12">';
            res += '<div class="device device-' + result.content[i].status_text + '">';
            res += '<div class="device-title row"><div class="col-md-12">';
            res += '' + result.content[i].nama_perangkat + '';
            res += '</div></div><span>(' + result.content[i].kode_perangkat + ')</span>';
            res += '<div class="row"><div class="col-md-12">';
            res += '<hr />Kapasitas: ' + result.content[i].jumlah_kursi_perangkat + ' Orang';
            res += '</div></div><div class="row">';
            res += '<div class="col-md-12">Status: ' + result.content[i].status_text_human + '';
            res += '<hr /></div></div>';
            if (result.auth == 'root') {
              res += '<div class="row"><div class="col-md-6 col-xs-6">';
              res += '<form action="/dashboard/delete/device/' + result.content[i].kode_perangkat + '" method="POST">';
              res += '<button class="btn-lengko btn-lengko-default pull-left" type="submit">';
              res += '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
              res += '</button><input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="DELETE">';
              res += '</form></div><div class="col-md-6 col-xs-6">';
              res += '<button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="show_obj(\'device-card-change-' + result.content[i].kode_perangkat + '\'); hide_obj(\'device-card-' + result.content[i].kode_perangkat + '\');">';
              res += '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>';
              res += '</button>';
              res += '</div></div>';
            }
            res += '</div></div>';
          }
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Perangkat tidak ditemukan</div></div></div>';
        }
        $('#device-card-section').html(res);
        swal({
          title: "Berhasil melakukan pencarian",
          html: result.text,
          type: "success",
          timer: 30000
        });
      }
    },
    error: function(result){

    }
  });
}//end

function search_employee(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/search/employee",
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
          var token = $('input[name=search_token]').val();
          res += '<div id="employee-card-table">';
            for (i = 0; i < result.content.length; i++) {
              res += '<div class="col-md-3 col-sm-4 col-xs-6">';
              res += '<div class="" onclick="show_obj(\'employee-card-change-' + result.content[i].kode_pegawai + '\'); hide_obj(\'employee-card-' + result.content[i].kode_pegawai + '\'); hide_obj(\'employee-card-table\')">';
              res += '<div class="row"><div class="col-md-12">';
              res += '<img class="hoverblur img-circle obj-center" src="/files/images/employee/';
              if (result.content[i].gambar_pegawai) {
                res += result.content[i].gambar_pegawai;
              }
              else {
                res += 'default.png';
              }
              res += '" alt="' + result.content[i].kode_pegawai + '" width="150px" height="150px" />';
              res += '</div></div>';
              res += '<div class="row" style="min-height: 60px;"><div class="col-md-12">';
              res += '<h4 class="text-center">' + result.content[i].nama_pegawai + '</h4>';
              res += '</div></div></div></div>';
            }
          res += '</div>';

          res += '<div id="employee-card-editable">';
            for (i = 0; i < result.content.length; i++) {
              res += '<form id="employee-card-change-' + result.content[i].kode_pegawai + '" hidden="hidden" name="" method="post" action="/dashboard/update/employee">';
              res += '<div class="row"><div class="col-md-4 col-sm-4">';
              res += '<img class="img-circle obj-center" src="/files/images/employee/';
              if (result.content[i].gambar_pegawai) {
                res += result.content[i].gambar_pegawai;
              }
              else {
                res += 'default.png';
              }
              res += '" alt="' + result.content[i].kode_pegawai + '" width="220px" height="220px" />';
              res += '</div><div class="col-md-7 col-sm-8">';
              res += '<div class="row">';
              res += '<div class="col-md-12">';
              res += '<h3>Kode Pegawai: <b>' + result.content[i].kode_pegawai + '</b></h3>';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-3 col-sm-3">';
              res += '<label style="margin: 10px 5px 10px 0px;">Nama</label>';
              res += '</div><div class="col-md-9 col-sm-9">';
              res += '<input type="text" name="employee-change-name" class="input-lengko-default block" placeholder="Nama Pegawai" value="' + result.content[i].nama_pegawai + '" />';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-3 col-sm-3">';
              res += '<label style="margin: 10px 5px 10px 0px;">Kata Sandi</label>';
              res += '</div><div class="col-md-9 col-sm-9">';
              res += '<input type="password" name="employee-change-password" class="input-lengko-default block" placeholder="(Kosongkan jika tidak diubah)" value="" />';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-3 col-sm-3">';
              res += '<label style="margin: 10px 5px 10px 0px;">Jenis Kelamin</label>';
              res += '</div><div class="col-md-9 col-sm-9">';
              res += '<div class="radio-lengko-default">';
              res += '<input type="radio" name="employee-change-gender" id="gender-male-' + result.content[i].kode_pegawai + '" value="L"';
              if (result.content[i].jenis_kelamin_pegawai == "Laki-Laki") {
                res += 'checked="checked" checked';
              }
              res += ' > <label for="gender-male-' + result.content[i].kode_pegawai + '">Laki-Laki</label>';
              res += '<input type="radio" name="employee-change-gender" id="gender-female-' + result.content[i].kode_pegawai + '" value="P"';
              if (result.content[i].jenis_kelamin_pegawai == "Perempuan") {
                res += 'checked="checked" checked';
              }
              res += ' > <label for="gender-female-' + result.content[i].kode_pegawai + '">Perempuan</label>';
              res += '</div></div></div>';
              res += '<div class="row"><div class="col-md-3 col-sm-3">';
              res += '<label style="margin: 10px 5px 10px 0px;">Otoritas</label>';
              res += '</div><div class="col-md-9 col-sm-9">';
              res += '<select name="employee-change-authority" class="select-lengko-default block">';
              for (j = 0; j < result.authority.length; j++) {
                res += '<option value="' + result.authority[j].kode_otoritas + '"';
                if (result.authority[j].kode_otoritas == result.content[i].kode_otoritas) {
                  res += 'selected';
                }
                res += '>' + result.authority[j].nama_otoritas + '</option>';
              }//endloop
              res += '</select>';
              res += '</div></div>';
              res += '<div class="row mrg-t-20"><div class="col-md-12">';
              res += '<button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj(\'employee-card-' + result.content[i].kode_pegawai + '\'); hide_obj(\'employee-card-change-' + result.content[i].kode_pegawai + '\'); show_obj(\'employee-card-table\');">';
              res += '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Kembali</button>';
              res += '<button class="btn-lengko btn-lengko-default pull-right" type="submit">';
              res += 'Simpan <span class="glyphicon glyphicon-save" aria-hidden="true"></span></button>';
              res += '<button class="btn-lengko btn-lengko-danger pull-right" type="button" onclick="delete_employee(\'' + result.content[i].kode_pegawai + '\');">';
              res += 'Hapus <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>';
              res += '<input type="hidden" name="employee-id" value="' + result.content[i].kode_pegawai + '" />';
              res += '<input type="hidden" name="_method" value="PUT" />';
              res += '<input type="hidden" name="_token" value=' + token + ' />';
              res += '</div></div></div></div></form>';
            }//endloop
          res += '</div>';
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Pegawai tidak ditemukan</div></div></div>';
        }
        $('#employee-card-section').html(res);
        swal({
          title: "Berhasil melakukan pencarian",
          html: result.text,
          type: "success",
          timer: 30000
        });
      }
    },
    error: function(result){

    }
  });
}//end

function delete_employee(id) {
  swal({
    title: "Hapus pegawai?",
    html: "Hapus " + id + " dari daftar pegawai?",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      data = {
        '_id' : id,
        '_method' : "delete",
        '_token' : $('input[name="_token"]').val()
      };

      $.ajax({
        type: "POST",
        url: "/dashboard/delete/employee/" + id,
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            swal({
              title: "Berhasil menghapus pegawai",
              text: result.text,
              type: "success",
              timer: 30000
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/employee/';
              }
            });
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.text,
              type: "warning",
              timer: 10000,
              confirmButtonText: 'Ok',
              confirmButtonColor: '#2c3e50',
            }).then(function(result) {
              if (result.value) {
                window.location = '/dashboard/employee/';
              }
            });
          }
        },
        error: function(result){

        }
      });//end ajax
    }//endif
  });//endswal
}

function search_material(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/search/material",
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
          var token = $('input[name=search_token]').val();
          res += '<div class="col-md-12">';
          res += '<div class="table-responsive">';
          res += '<table id="material-management" class="table table-hover table-striped">';
          res += '<tr><th>Bahan Baku</th>';
          res += '<th>Stok</th><th>Satuan</th>';
          res += '<th>Kadaluarsa</th><th></th></tr>';
          for (i = 0; i < result.content.length; i++) {
            res += '<tr id="material-card-' + result.content[i].kode_bahan_baku + '">';
            res += '<td>#' + result.content[i].kode_bahan_baku + ' ' + result.content[i].nama_bahan_baku + '';
            res += '<td>' + result.content[i].stok_bahan_baku + '</td>';
            res += '<td>' + result.content[i].satuan_bahan_baku + '</td>';
            res += '<td width="150px">' + result.content[i].tanggal_kadaluarsa_bahan_baku + '</td>';
            res += '<td width="100px">';
            res += '<form name="material-delete" action="/dashboard/delete/material' + '/' + result.content[i].kode_bahan_baku + '" method="POST">';
            res += '<button class="btn-lengko btn-lengko-default pull-right" type="submit">';
            res += '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
            res += '</button>';
            res += '<input type="hidden" name="material-delete-id" value="' + result.content[i].kode_bahan_baku + '">';
            res += '<input type="hidden" name="_token" value="' + token + '">';
            res += '<input type="hidden" name="_method" value="DELETE">';
            res += '</form>';
            res += '<a href="/dashboard/material/change/' + result.content[i].kode_bahan_baku + '">';
            res += '<button class="btn-lengko btn-lengko-default pull-right" type="button">';
            res += '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>';
            res += '</button>';
            res += '</a></td></tr>';
          }
          res += '</table></div></div>';
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Bahan baku tidak ditemukan</div></div></div>';
        }        
        $('#material-card-section').html(res);
        ajax_init();
        swal({
          title: "Berhasil melakukan pencarian",
          html: result.text,
          type: "success",
          timer: 30000
        });
      }
    },
    error: function(result){

    }
  });
}//end


function search_menu(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/search/menu",
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
        if (result.content.menu.length > 0) {
          var token = $('input[name=search_token]').val();
          for (i = 0; i < result.content.menu.length; i++) {
            res += '<form name="menu-update" class="form-horizontal" action="/dashboard/update/menu" method="post" enctype="multipart/form-data">';
            res += '<input type="hidden" name="_method" value="put">';
            res += '<input type="hidden" name="menu-change-id" value="'+ result.content.menu[i].kode_menu + '">';
            res += '<input type="hidden" name="_token" value="' + token + '">';
            res += '<div class="row mrg-b-10 padd-tb-10">';
            res += '<div class="col-md-6"><div class="row"><div class="col-md-5 col-sm-4">';
            res += '<div class="container-file-lengko block">';
            res += '<img id="preview-image-' + i + '" src="/files/images/menus/';
            if (result.content.menu[i].gambar_menu) {
              res += result.content.menu[i].gambar_menu;
            }
            else {
              res += 'not-available.png';
            }

            res += '" alt="' + result.content.menu[i].nama_menu + '" width="200px" height="150px" style="border-radius:5px;" />';
            if (result.auth == 'root' || result.auth == 'chef') {
              res += '<input id="choose-image-' + i + '" name="menu-change-thumbnail" type="file" title="Ubah gambar menu" onchange="reload_image(this, \'#preview-image-\'' + i + ');" />';
            }
            res += '</div>';
            res += '</div><div class="col-md-7 col-sm-8"><div class="row"><div class="col-md-3 col-sm-2">';
            res += '<div class="text-left padd-tb-10">[<b>' + result.content.menu[i].kode_menu + '</b>]</div>';
            res += '</div><div class="col-md-9 col-sm-10">';
            res += '<input type="text" name="menu-change-name" class="input-lengko-default block" placeholder="Nama Menu" value="' + result.content.menu[i].nama_menu + '"';
            if (result.auth != 'root' && result.auth != 'chef') {
              res += ' readonly ';
            }
            res += '/>';
            res += '</div></div><div class="row"><div class="col-md-7 col-sm-6">';
            res += '<select name="menu-change-type" class="select-lengko-default block"';
            if (result.auth != 'root' && result.auth != 'chef') {
              res += ' disabled="disabled" ';
            }
            res += '>';
            res += '<option value="F"';
            if (result.content.menu[i].jenis_menu == "F") {
              res += ' selected="selected"';
            }
            res += '>Makanan</option> <option value="D"';
            if (result.content.menu[i].jenis_menu == "D") {
              res += ' selected="selected"';
            }
            res += '>Minuman</option></select></div><div class="col-md-5 col-sm-6">';
            res += '<input type="number" name="menu-change-price" class="input-lengko-default block" placeholder="Harga Menu" value="' + result.content.menu[i].harga_menu + '"';
            if (result.auth != 'root' && result.auth != 'chef') {
              res += ' readonly ';
            }
            res += '/>';
            res += '</div></div><div class="row padd-tb-10"><div class="col-md-12">';
            res += '<div class="well well-sm">';
            var tmp = false; var inc = 0;

            for (j = 0; j < result.content[i]['menu-status'].length; j++ ) {
              inc++;
              if (result.content[i]['menu-status'][j].stok_bahan_baku > 0) {
                tmp = true;
              }
              else {
                tmp = false;
                break;
              }
            }

            if (inc === result.content[i]['menu-status'].length) {
              if (tmp) {
                res += '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Tersedia ';
              }
              else {
                res += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Tidak Tersedia ';
              }
            }
            else {
              res += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Tidak Tersedia ';
            }

            res += '</div></div></div></div></div></div>';
            res += '<div class="col-md-6"><div class="row">';
            res += '<div class="col-md-12">';
            res += '<textarea name="menu-change-description" class="textarea-lengko-default block" rows="5" placeholder="Deskripsi Menu"';
            if (result.auth != 'root' && result.auth != 'chef') {
              res += ' readonly ';
            }
            res += '>' + result.content.menu[i].deskripsi_menu + '</textarea>';
            res += '</div></div>';
            if (result.auth == 'root' || result.auth == 'chef') {
              res += '<div class="row"><div class="col-md-6">';
              res += '<button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj(\'material-card-change-' + result.content.menu[i].kode_menu +'\');">';
              res += 'Bahan Baku <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>';
              res += '</button></div><div class="col-md-6">';
              res += '<button class="btn-lengko btn-lengko-default pull-right" type="submit">';
              res += '<span class="glyphicon glyphicon-save" aria-hidden="true"></span>';
              res += '</button><button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="delete_menu(\'' + result.content.menu[i].kode_menu + '\');">';
              res += '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
              res += '</button></div></div>';
            }

            res += '</div></div>';
            res += '<div id="material-card-change-' + result.content.menu[i].kode_menu + '" class="row" hidden="hidden">';
            res += '<div class="col-md-12"><div class="scrollable scrollable-md"><div class="row">';

            for (j = 0; j < result.material.length; j++) {
              res += '<div class="col-md-6">';
              res += '<input type="hidden" name="menu-material-change-id-' + j + '" value="' + result.material[j].kode_bahan_baku + '" />';
              var count = 0;

              for (k = 0; k < result.content[i]['menu-material'].length; k++) {
                if (result.content[i]['menu-material'][k].kode_bahan_baku == result.material[j].kode_bahan_baku) {
                  count = result.content[i]['menu-material'][k].jumlah_bahan_baku_detil;
                }
              }

              if (count > 0) {
                res += '<input type="number" name="menu-material-change-count-' + j + '" min="0" class="input-lengko-default" placeholder="0.0" value="' + count + '" />';
                res += '(<small>' + result.material[j].satuan_bahan_baku + '</small>) ';
                res += '<b>' + result.material[j].nama_bahan_baku + '</b>';
              }
              else {
                res += '<input type="number" name="menu-material-change-count-' + j + '" min="0" class="input-lengko-default" placeholder="0.0" />';
                res += '(<small>' + result.material[j].satuan_bahan_baku + '</small>) ';
                res += result.material[j].nama_bahan_baku;
              }
              res += '</div>';
            }
            res += '<input type="hidden" name="menu-material-max" value="' + result.material.length + '" />';
            res += '</div></div>';
            res += 'Bahan baku tidak tersedia? Silahkan ajukan <a href="/dashboard/material">Permohonan Pengadaan Bahan Baku</a>.';
            res += '</div></div></form><hr />';

          }//end loop
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Menu tidak ditemukan</div></div></div>';
        }
        $('#menu-card-section').html(res);
        swal({
          title: "Berhasil melakukan pencarian",
          html: result.text,
          type: "success",
          timer: 30000
        });
      }
    },
    error: function(result){

    }
  });
}//end

function search_material_menu(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/search/materialmenu",
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
          var token = $('input[name=search_token]').val();
          for (i = 0; i < result.content.length; i++) {
            res += '<div class="col-md-6">';
              res += '<input type="hidden" name="menu-material-create-id-' + i + '" value="' + result.content[i].kode_bahan_baku + '" />';
              res += '<input type="number" name="menu-material-create-count-' + i + '" min="0" max="' + result.content[i].stok_bahan_baku + '" class="input-lengko-default" placeholder="0.0" />';
              res += ' (<small>' + result.content[i].satuan_bahan_baku + '</small>) ';
              res += result.content[i].nama_bahan_baku;
            res += '</div>';
          }

          res += '<input type="hidden" name="menu-material-max" value="' + result.content.length + '" />';
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Bahan baku tidak ditemukan</div></div></div>';
        }
        $('#material-card-section').html(res);
        swal({
          title: "Berhasil melakukan pencarian",
          html: result.text,
          type: "success",
          timer: 30000
        });
      }
    },
    error: function(result){

    }
  });
}//end

function search_transaction(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/search/transaction",
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
      else if (result.status == 200) {
        var res = '';
        if (result.content.length > 0) {
          var token = $('input[name=search_token]').val();
          res += '<table class="table"><tr><th>Transaksi</th><th>Waktu</th>';
          res += '<th>Pembeli</th><th>Perangkat</th></tr>';
          for (i = 0; i < result.content.transaction.length; i++) {
            res += '<tr onclick="show_obj(\'transaction-' + i + '\');" class="cursor-pointer">';
            res += '<td>#' + result.content.transaction[i].kode_pesanan + '</td>';
            res += '<td>' + result.content.transaction[i].tanggal_pesanan + ' ' + result.content.transaction[i].waktu_pesanan + '</td>';
            res += '<td>' + result.content.transaction[i].pembeli_pesanan + '</td>';
            res += '<td>' + result.content.transaction[i].nama_perangkat + '</td></tr>';
            if (result.content[i]['transaction-detail'].length > 0) {
              res += '<tr id="transaction-' + i + '" style="display:none; visibility: none;">';
              res += '<td></td><td colspan="5"><div class="table-responsive">';
              res += '<table class="table table-hover table-striped">';
              res += '<tr><th>Menu</th><th>Harga</th>';
              res += '<th>Jumlah</th><th>Sub-Total</th></tr>';

              for (j = 0; j < result.content[i]['transaction-detail'].length; j++) {
                res += '<tr><td>' + result.content[i]['transaction-detail'][j].nama_menu + '</td>';
                res += '<td>' + result.content[i]['transaction-detail'][j].harga_menu + '</td>';
                res += '<td>' + result.content[i]['transaction-detail'][j].jumlah_pesanan_detil + '</td>';
                res += '<td>' + result.content[i]['transaction-detail'][j].harga_menu * result.content[i]['transaction-detail'][j].jumlah_pesanan_detil + '</td>';
                res += '</tr>';
              }
              res += '<tr><td colspan="3" class="text-right"><label>Total</label></td>';
              res += '<td>' + result.content.transaction[i].harga_pesanan + '</td>';
              res += '</tr><tr>';
              res += '<td colspan="3" class="text-right"><label>Tunai</label></td>';
              res += '<td width="170px">';
              res += '<input type="number" id="transaction-cash-' + result.content.transaction[i].kode_pesanan + '" name="transaction-cash-' + result.content.transaction[i].kode_pesanan + '" min="' + result.content.transaction[i].harga_pesanan + '" class="input-lengko-default block" placeholder="0" value="' + result.content.transaction[i].harga_pesanan + '" onchange="cash_back(\'transaction-cash-' + result.content.transaction[i].kode_pesanan + '\', \'transaction-cash-back-' + result.content.transaction[i].kode_pesanan + '\', ' + result.content.transaction[i].harga_pesanan + ', \'Rp\');" />';
              res += '</td></tr>';
              res += '<tr><td colspan="3" class="text-right"><label>Kembali</label></td>';
              res += '<td><input type="text" id="transaction-cash-back-' + result.content.transaction[i].kode_pesanan + '" class="input-lengko-default block" value="0" disabled="disabled" disabled />';
              res += '</td></tr></table><hr />';
              res += '<button type="button" class="btn-lengko btn-lengko-warning pull-left">';
              res += '<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak';
              res += '</button>';
              res += '<button type="button" class="btn-lengko btn-lengko-default pull-right" onclick="done_transaction(' + result.content.transaction[i].kode_pesanan + ', ' + result.content.transaction[i].harga_pesanan + ');">';
              res += '<span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Bayar';
              res += '</button>';
              res += '</div></td></tr>';
            }
          }
          res += '</table>';
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Transaksi tidak ditemukan</div></div></div>';
        }
        $('#transaction-card-section').html(res);
        swal({
          title: "Berhasil melakukan pencarian",
          html: result.text,
          type: "success",
          timer: 30000
        });
      }
      else {
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
    },
    error: function(result){

    }
  });
}//end

function search_transaction_history(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/search/transactionhistory",
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
      else if (result.status == 200) {
        var res = '';
        if (result.content) {
          var token = $('input[name=search_token]').val();
          res += '<table class="table"><tr>';
          res += '<th>Transaksi</th><th>Waktu</th>';
          res += '<th>Pembeli</th><th>Perangkat</th></tr>';
          for (i = 0; i < result.content['transaction-history'].length; i++) {
            res += '<tr onclick="show_obj(\'transaction-history-' + i + '\');" class="cursor-pointer">';
            res += '<td>#' + result.content['transaction-history'][i].kode_pesanan + '</td>';
            res += '<td>' + result.content['transaction-history'][i].tanggal_pesanan + ' ' + result.content['transaction-history'][i].waktu_pesanan + '</td>';
            res += '<td>' + result.content['transaction-history'][i].pembeli_pesanan + '</td>';
            res += '<td>' + result.content['transaction-history'][i].nama_perangkat + '</td></tr>';
            if (result.content[i]['transaction-history-detail'].length > 0) {
              res += '<tr id="transaction-history-' + i + '" style="display:none; visibility: none;">';
              res += '<td></td><td colspan="5"><div class="table-responsive">';
              res += '<table class="table table-hover table-striped">';
              res += '<tr><th>Menu</th><th>Harga</th><th>Jumlah</th>';
              res += '<th>Sub-Total</th></tr>';
              for (j = 0; j < result.content[i]['transaction-history-detail'].length; j++) {
                res += '<tr><td>' + result.content[i]['transaction-history-detail'][j].nama_menu + '</td>';
                res += '<td>' + result.content[i]['transaction-history-detail'][j].harga_menu + '</td>';
                res += '<td>' + result.content[i]['transaction-history-detail'][j].jumlah_pesanan_detil + '</td>';
                res += '<td>' + result.content[i]['transaction-history-detail'][j].harga_menu * result.content[i]['transaction-history-detail'][j].jumlah_pesanan_detil + '</td></tr>';
              }
              res += '<tr><td colspan="3" class="text-right"><label>Total</label></td>';
              res += '<td>' + result.content['transaction-history'][i].harga_pesanan + '</td></tr>';
              res += '<tr><td colspan="3" class="text-right"><label>Tunai</label></td>';
              res += '<td>' + result.content['transaction-history'][i].tunai_pesanan + '</td></tr>';
              res += '<tr><td colspan="3" class="text-right"><label>Kembali</label></td>';
              res += '<td>' + (result.content['transaction-history'][i].tunai_pesanan - result.content['transaction-history'][i].harga_pesanan) + '</td>';
              res += '</tr></table></div>';
              res += '<button type="button" class="btn-lengko btn-lengko-warning pull-right">';
              res += '<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak';
              res += '</button></td></tr>';
            }
          }
          res += '</table>';
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Catatan transaksi tidak ditemukan</div></div></div>';
        }
        $('#transaction-history-card-section').html(res);
        swal({
          title: "Berhasil melakukan pencarian",
          html: result.text,
          type: "success",
          timer: 30000
        });
      }
      else {
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
    },
    error: function(result){

    }
  });
}//end

function search_review(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/search/review",
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
          var token = $('input[name=search_token]').val();
          res += '<table class="table"><tr><th width="150px">#</th>';
          res += '<th>Kritik & Saran</th><th width="200px">Waktu</th>';
          res += '<th>Status</th><th></th></tr>';
          for (i = 0; i < result.content['review-device'].length; i++) {
            res += '<tr class="cursor-pointer">';
            res += '<td onclick="show_obj(\'review-' + i + '\');">#' + result.content['review-device'][i].kode_kuisioner_perangkat + ' (' + result.content['review-device'][i].pembeli_kuisioner_perangkat + ')</td>';
            res += '<td onclick="show_obj(\'review-' + i + '\');">' + result.content['review-device'][i].pesan_kuisioner_perangkat + '</td>';
            res += '<td onclick="show_obj(\'review-' + i + '\');">' + result.content['review-device'][i].tanggal_kuisioner_perangkat + ' ' + result.content['review-device'][i].waktu_kuisioner_perangkat + '</td>';
            res += '<td>';
            res += '<form method="post" action="/dashboard/update/reviewdevice">';
            res += '<input type="hidden" name="_id" value="' + result.content['review-device'][i].kode_kuisioner_perangkat + '">';
            res += '<input type="hidden" name="_token" value="' + token + '">';
            res += '<input type="hidden" name="_method" value="put">';

            res += '<button class="btn-lengko btn-lengko-default pull-right" type="submit">';
            if (result.content['review-device'][i].status_kuisioner_perangkat === 1) {
              res += '<span class="glyphicon glyphicon-record" aria-hidden="true"></span>';
            }
            else if (result.content['review-device'][i].status_kuisioner_perangkat === 0) {
              res += '<span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>';
            }
            res += '</button>';

            res += '</form></td><td>';
            res += '<button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="delete_review_device(' + result.content['review-device'][i].kode_kuisioner_perangkat + ');">';
            res += '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
            res += '</button></td></tr>';
            if (result.content[i]['review-detail'].length > 0) {
              res += '<tr id="review-' + i + '" style="display:none; visibility: none;">';
              res += '<td></td><td colspan="5">';
              res += '<div class="table-responsive">';
              res += '<table class="table table-hover table-striped">';
              res += '<tr><th>Kuisioner</th><th>Poin</th></tr>';
              for (j = 0; j < result.content[i]['review-detail'].length; j++) {
                res += '<tr><td>[' + result.content[i]['review-detail'][j].judul_kuisioner + ']';
                res += result.content[i]['review-detail'][j].isi_kuisioner + '</td>';
                res += '<td><select id="customer-reviews-' + result.content[i]['review-detail'][j].kode_kuisioner_detil + '" class="barrating-readonly">';
                for (k = 1; k <= 5; k++) {
                  res += '<option value="' + k + '"';
                  if (k === result.content[i]['review-detail'][j].poin_kuisioner_detil) {
                      res += 'selected';
                  }
                  res += '>' + k + '</option>';
                }
                res += '</select></td></tr>';
              }
              res += '</table></div></td></tr>';
            }
          }
          res += '</table>';
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Kuisioner tidak ditemukan</div></div></div>';
        }
        $('#review-card-section').html(res);
        swal({
          title: "Berhasil melakukan pencarian",
          html: result.text,
          type: "success",
          timer: 30000
        });
      }
    },
    error: function(result){

    }
  });
}//end


function report_lookup(data) {
  swal({
    title: "Lihat laporan pendapatan?",
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
        url: "/dashboard/retrieve/report",
        data: data,
        cache: false,
        success: function(result) {
          if (result.status == 200) {
            var res = '';
            if (result.content) {
              var total = 0;
              res += '<div class="row"><div class="col-md-12">';
              res += '<h4 class="text-center">Hasil Laporan</h4></div></div>';
              res += '<div class="table-responsive">';
              res += '<table class="table table-hover table-striped">';
              res += '<tr><th class="text-center">Tanggal</th>';
              res += '<th class="text-center">Pendapatan</th></tr>';
              for (i = 0; i < result.content.length; i++) {
                res += '<tr><td class="text-center">' + result.content[i].tanggal + '</td>';
                res += '<td class="text-center">Rp' + result.content[i].pendapatan + '</td></tr>';
                total += Number(result.content[i].pendapatan);
              }
              res += '<tr><td class="text-right" style="font-weight:bold;">Total</td><td class="text-center">Rp' + total + '</td></tr>';
              res += '</table></div>';

              res += '<div class="row"><div class="col-md-offset-9 col-md-3">';
              res += '<button type="button" name="report-print-button" class="btn-lengko btn-lengko-warning block">';
              res += '<span class="glyphicon glyphicon-print" aria-hidden="true"></span>';
              res += ' Cetak</button></div></div>';
            }
            else {
              res = '<div class="row padd-lr-15"><div class="col-md-12">';
              res += '<div class="alert alert-warning">';
              res += 'Data tidak ditemukan';
              res += '</div></div></div>';
            }
            $('#report-card-section').html(res);
          }
          else {
            swal({
              title: "Oops terjadi kesalahan",
              html: result.content,
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

function filter_device(data) {
  $.ajax({
    type: "POST",
    url: "/dashboard/filter/device",
    data: data,
    cache: false,
    success: function(result) {
      if (result.status == 200) {
        var res = '';
        if (result.content) {
          var token = $('input[name=search_token]').val();
          for (i = 0; i < result.content.length; i++) {
            if (result.auth == 'root') {
              res += '<form id="device-card-change-' + result.content[i].kode_perangkat + '" action="/dashboard/update/device" method="POST" hidden="hidden">';
              res += '<div class="col-md-3 col-sm-6 col-xs-12">';
              res += '<div class="device device-' + result.content[i].status_text + '">';
              res += '<div class="device-title row"><div class="col-md-12">';
              res += '<input type="text" name="device-change-name" class="input-lengko-default block" value="' + result.content[i].nama_perangkat + '" />';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-12">';
              res += 'Kapasitas: <input type="number" name="device-change-chair" min="1" class="input-lengko-default" value="' + result.content[i].jumlah_kursi_perangkat + '" /> Orang<br />';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-12">Status:';
              res += '<select name="device-change-status" class="select-lengko-default">';
              res += '<option value="0">Tidak Tersedia</option>';
              res += '<option value="1">Tersedia</option>';
              res += '</select>';
              res += '</div></div>';
              res += '<div class="row"><div class="col-md-12">Kata sandi:';
              res += '<input type="password" name="device-change-password" class="input-lengko-default block" placeholder="(tidak diubah, kosongkan)" />';
              res += '<hr /></div></div>';
              res += '<div class="row"><div class="col-md-6 col-xs-6">';
              res += '<form action="/dashboard/delete/device/' + result.content[i].kode_perangkat + '" method="POST">';
              res += '<button class="btn-lengko btn-lengko-default pull-left" type="button" onclick="show_obj(\'device-card-' + result.content[i].kode_perangkat + '\'); hide_obj(\'device-card-change-' + result.content[i].kode_perangkat + '\');">';
              res += '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>';
              res += '</button><button class="btn-lengko btn-lengko-default" type="submit">';
              res += '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
              res += '</button>';
              res += '<input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="DELETE">';
              res += '</form></div>';
              res += '<div class="col-md-6 col-xs-6">';
              res += '<button class="btn-lengko btn-lengko-default pull-right" type="submit">';
              res += '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>';
              res += '</button>';
              res += '<input type="hidden" name="device-id" value="' + result.content[i].kode_perangkat + '" />';
              res += '<input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="PUT"></div></div></div></div></form>';
            }

            res += '<div id="device-card-' + result.content[i].kode_perangkat + '" class="col-md-3 col-sm-6 col-xs-12">';
            res += '<div class="device device-' + result.content[i].status_text + '">';
            res += '<div class="device-title row"><div class="col-md-12">';
            res += '' + result.content[i].nama_perangkat + '';
            res += '</div></div><span>(' + result.content[i].kode_perangkat + ')</span>';
            res += '<div class="row"><div class="col-md-12">';
            res += '<hr />Kapasitas: ' + result.content[i].jumlah_kursi_perangkat + ' Orang';
            res += '</div></div><div class="row">';
            res += '<div class="col-md-12">Status: ' + result.content[i].status_text_human + '';
            res += '<hr /></div></div>';
            if (result.auth == 'root') {
              res += '<div class="row"><div class="col-md-6 col-xs-6">';
              res += '<form action="/dashboard/delete/device/' + result.content[i].kode_perangkat + '" method="POST">';
              res += '<button class="btn-lengko btn-lengko-default pull-left" type="submit">';
              res += '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
              res += '</button><input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="DELETE">';
              res += '</form></div><div class="col-md-6 col-xs-6">';
              res += '<button class="btn-lengko btn-lengko-default pull-right" type="button" onclick="show_obj(\'device-card-change-' + result.content[i].kode_perangkat + '\'); hide_obj(\'device-card-' + result.content[i].kode_perangkat + '\');">';
              res += '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>';
              res += '</button>';
              res += '</div></div>';
            }
            res += '</div></div>';
          }
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Perangkat tidak ditemukan</div></div></div>';
        }
        $('#device-card-section').html(res);
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

  /* device */
  if ($('#device-add').length > 0) {
    $('#device-add').on('submit', function(e) {
      e.preventDefault();

      swal({
        title: "Tambah perangkat?",
        html: "Hanya tambahkan perangkat apabila <br />terdapat perangkat baru.",
        type: "question",
        timer: 10000,
        showCancelButton: true,
        confirmButtonText: 'Iya',
        confirmButtonColor: '#2c3e50',
        cancelButtonText: 'Tidak'
      }).then(function(result) {
        if (result.value) {
          var data = {
            'device-create-id' : $("input[name=device-create-id]").val(),
            'device-create-name' : $("input[name=device-create-name]").val(),
            'device-create-password' : $("input[name=device-create-password]").val(),
            'device-create-chair' : $("input[name=device-create-chair]").val(),
            '_method' : $("input[name=device-create-method]").val(),
            '_token' : $("input[name=device-create-token]").val()
          };

          $.ajax({
            type: "POST",
            url: "/dashboard/create/device",
            data: data,
            dataType: 'JSON',
            cache: false,
            success: function(result) {
              if (result.status == 400) {
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
              else if (result.status == 500) {
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
                swal({
                  title: "Berhasil menambah perangkat",
                  text: result.text,
                  type: "success",
                  timer: 30000
                }).then(function(result) {
                  if (result.value) {
                    window.location = '/dashboard/device/';
                  }
                });
              }
            },
            error: function(result){

            }
          });

        }
      });

    });
  }

  if ($('input[name=device-search-query]').length > 0) {
    $('input[name=device-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'device-search-query' : $("input[name=device-search-query]").val(),
        '_method' : $("input[name=device-search-method]").val(),
        '_token' : $("input[name=device-search-token]").val()
      };
      search_device(data);
    });
  }

  if ($('button[name=device-search-button]').length > 0) {
    $('button[name=device-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        'device-search-query' : $("input[name=device-search-query]").val(),
        '_method' : $("input[name=device-search-method]").val(),
        '_token' : $("input[name=device-search-token]").val()
      };
      search_device(data);
    });
  }

  /* filter device */
  if ($('select[name=device-search-status]')) {
    $('select[name=device-search-status]').on('change', function(e) {
      e.preventDefault();
      var data = {
        '_keyword' : $("select[name=device-search-status]").val(),
        '_method' : "post",
        '_token' : $("input[name=_token]").val()
      };

      filter_device(data);
    });
  }

  /* employee */

  if ($('form[name=employee-add]').length > 0) {
    $('form[name=employee-add]').on('submit', function(e) {
      e.preventDefault();

      swal({
        title: "Tambah pegawai?",
        html: "Hanya tambahkan pegawai apabila <br />terdapat pegawai baru.",
        type: "question",
        timer: 10000,
        showCancelButton: true,
        confirmButtonText: 'Iya',
        confirmButtonColor: '#2c3e50',
        cancelButtonText: 'Tidak'
      }).then(function(result) {
        if (result.value) {
          var data = {
            'employee-create-id' : $("input[name=employee-create-id]").val(),
            'employee-create-name' : $("input[name=employee-create-name]").val(),
            'employee-create-password' : $("input[name=employee-create-password]").val(),
            'employee-create-authority' : $("select[name=employee-create-authority]").val(),
            'employee-create-gender' : $("input[name=employee-create-gender]").val(),
            '_method' : $("input[name=employee-create-method]").val(),
            '_token' : $("input[name=employee-create-token]").val()
          };

          $.ajax({
            type: "POST",
            url: "/dashboard/create/employee",
            data: data,
            dataType: 'JSON',
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
                swal({
                  title: "Berhasil menambah pegawai",
                  text: result.text,
                  type: "success",
                  timer: 30000
                }).then(function(result) {
                  if (result.value) {
                    window.location = '/dashboard/employee/';
                  }
                });
              }
            },
            error: function(result){

            }
          });

        }
      });

    });
  }

  if ($('input[name=employee-search-query]').length > 0) {
    $('input[name=employee-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'employee-search-query' : $("input[name=employee-search-query]").val(),
        '_method' : $("input[name=employee-search-method]").val(),
        '_token' : $("input[name=employee-search-token]").val()
      };
      search_employee(data);
    });
  }

  if ($('button[name=employee-search-button]').length > 0) {
    $('button[name=employee-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        'employee-search-query' : $("input[name=employee-search-query]").val(),
        '_method' : $("input[name=employee-search-method]").val(),
        '_token' : $("input[name=employee-search-token]").val()
      };
      search_employee(data);
    });
  }


  /* material */
  if ($('input[name=material-search-query]').length > 0) {
    $('input[name=material-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'material-search-query' : $("input[name=material-search-query]").val(),
        '_method' : $("input[name=material-search-method]").val(),
        '_token' : $("input[name=material-search-token]").val()
      };
      search_material(data);
    });
  }

  if ($('button[name=material-search-button]').length > 0) {
    $('button[name=material-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        'material-search-query' : $("input[name=material-search-query]").val(),
        '_method' : $("input[name=material-search-method]").val(),
        '_token' : $("input[name=material-search-token]").val()
      };
      search_material(data);
    });
  }

  if ($('form[name=material-add]').length > 0) {
    $('form[name=material-add]').on('submit', function(e) {
      e.preventDefault();

      swal({
        title: "Tambah bahan baku?",
        html: "Pastikan hanya tambahkan bahan baku yang belum tersedia.",
        type: "question",
        timer: 10000,
        showCancelButton: true,
        confirmButtonText: 'Iya',
        confirmButtonColor: '#2c3e50',
        cancelButtonText: 'Tidak'
      }).then(function(result) {
        if (result.value) {
          var data = {
            'material-create-name' : $("input[name=material-create-name]").val(),
            'material-create-stock' : $("input[name=material-create-stock]").val(),
            'material-create-unit' : $("input[name=material-create-unit]").val(),
            'material-create-date' : $("input[name=material-create-date]").val(),
            '_method' : $("input[name=material-create-method]").val(),
            '_token' : $("input[name=material-create-token]").val()
          };

          $.ajax({
            type: "POST",
            url: "/dashboard/create/material",
            data: data,
            dataType: 'JSON',
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
                swal({
                  title: "Berhasil menambah bahan baku",
                  text: result.text,
                  type: "success",
                  timer: 30000
                }).then(function(result) {
                  if (result.value) {
                    window.location = '/dashboard/material/';
                  }
                });
              }
            },
            error: function(result){

            }
          });

        }
      });

    });
  }

  if ($('#btn-material-list-request').length > 0) {
    var inc = 0;
    $('#btn-material-list-request').click(function() {
      inc += 1;
      $.ajax({
        type: "GET",
        url: "/dashboard/generate/material/textbox",
        data: {inc: inc},
        success: function(result) {
          var field = '<div class="row padd-lr-15"><div class="col-md-offset-2 col-md-6 col-sm-offset-2 col-sm-5 col-xs-7">';
          field += '<input type="text" id="material-request-create-item-' + inc + '" name="material-request-create-item-' + inc + '" class="input-lengko-default block" placeholder="Nama Bahan Baku" /></div>';
          field += '<div class="col-md-4 col-sm-5 col-xs-5">';
          field += '';
          field += '<select id="material-list-' + inc + '" name="" class="select2" onchange="add_val(\'material-list-' + inc + '\', \'material-request-create-item-' + inc + '\');">';
          if (result.data.material.length > 0) {
            for (j = 0; j < result.data.material.length; j++) {
              field += '<option value="' + result.data.material[j].kode_bahan_baku + '">' + result.data.material[j].nama_bahan_baku + '</option>';
            }
          }
          else {
            field += '<option value="">Tidak tersedia</option>';
          }
          field +=  '</select>';
          field +=  '</div></div>';
          add_element('material-list-request', field);
          $('input[name=material-request-create-max]').val(inc + 1);
          ajax_init();
        }
      });

    });
  }

  /* menu */

  if ($('input[name=search-material-menu-query]').length > 0) {
    $('input[name=search-material-menu-query]').on('change', function(e) {
      e.preventDefault();

      var data = {
        'material-search-query' : $("input[name=search-material-menu-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=material-menu-search-token]").val()
      };
      search_material_menu(data);
    });
  }

  if ($('button[name=search-material-menu-button]').length > 0) {
    $('button[name=search-material-menu-button]').on('click', function(e) {
      e.preventDefault();

      var data = {
        'material-search-query' : $("input[name=search-material-menu-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=material-menu-search-token]").val()
      };
      search_material_menu(data);
    });
  }

  if ($('input[name=menu-search-query]').length > 0) {
    $('input[name=menu-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'menu-search-query' : $("input[name=menu-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=menu-search-token]").val(),
      };
      search_menu(data);
    });
  }

  if ($('button[name=menu-search-button]').length > 0) {
    $('button[name=menu-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        'menu-search-query' : $("input[name=menu-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=menu-search-token]").val(),
      };
      search_menu(data);
    });
  }

  /* order */

  if ($('input[name=order-search-query]').length > 0) {
    $('input[name=order-search-query]').on('change', function(e) {
      e.preventDefault();

      var data = {
        'order-search-query' : $("input[name=order-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };

      $.ajax({
        type: "POST",
        url: "/dashboard/search/order",
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
            if (result.content['order-confirmation'].length > 0) {
              var token = $('input[name=search_token]').val();
              res += '<table class="table"><tr>';
              res += '<th>Transaksi</th><th>Waktu</th>';
              res += '<th>Pembeli</th><th>Perangkat</th>';
              res += '<th>Konfirmasi</th></tr>';
              for (i = 0; i < result.content['order-confirmation'].length; i++) {
                res += '<tr onclick="show_obj(\'order-confirmation-' + i + '\');" class="cursor-pointer">';
                res += '<td>#' + result.content['order-confirmation'][i].kode_pesanan + '</td>';
                res += '<td>' + result.content['order-confirmation'][i].tanggal_pesanan + ' ' + result.content['order-confirmation'][i].waktu_pesanan + '</td>';
                res += '<td>' + result.content['order-confirmation'][i].pembeli_pesanan + '</td>';
                res += '<td>' + result.content['order-confirmation'][i].nama_perangkat + '</td><td>';
                res += '<form name="" action="/dashboard/confirm/order" method="post">';
                res += '<input type="hidden" name="_token" value="' + token + '">';
                res += '<input type="hidden" name="order-confirm-id" value="' + result.content['order-confirmation'][i].kode_pesanan + '" />';
                res += '<button type="submit" class="btn-lengko btn-lengko-warning" width="80px">';
                res += '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>';
                res += '</button></form></td></tr>';
                if (result.content[i]['order-confirmation-detail'].length > 0) {
                  res += '<tr id="order-confirmation-' + i + '" style="display:none; visibility: none;">';
                  res += '<td></td>';
                  res += '<td colspan="5">';
                  res += '<div class="table-responsive">';
                  res += '<table class="table table-hover table-striped">';
                  res += '<tr><th>Menu</th><th>Harga</th><th>Jumlah</th><th>Sub-Total</th></tr>';
                  for (j = 0; j < result.content[i]['order-confirmation-detail'].length; j++) {
                    res += '<tr><td>' + result.content[i]['order-confirmation-detail'][j].nama_menu + '</td>';
                    res += '<td>' + result.content[i]['order-confirmation-detail'][j].harga_menu + '</td>';
                    res += '<td>' + result.content[i]['order-confirmation-detail'][j].jumlah_pesanan_detil + '</td>';
                    res += '<td>' + result.content[i]['order-confirmation-detail'][j].harga_menu * result.content[i]['order-confirmation-detail'][j].jumlah_pesanan_detil + '</td>';
                    res += '</tr>';
                  }
                  res += '<tr><td colspan="3" class="text-right"><label>Total</label></td>';
                  res += '<td>Rp' + result.content['order-confirmation'][i].harga_pesanan + '</td>';
                  res += '</tr></table></div></td></tr></table>';
                }
              }//end loop
            }
            else {
              res = '<div class="row padd-lr-15"><div class="col-md-8">';
              res += '<div class="alert alert-warning">Pesanan tidak ditemukan</div></div></div>';
            }
            $('#order-card-section').html(res);
            swal({
              title: "Berhasil melakukan pencarian",
              html: result.text,
              type: "success",
              timer: 30000
            });
          }
        },
        error: function(result){

        }
      });

    });
  }

  /* transaction */

  if ($('input[name=transaction-search-query]').length > 0) {
    $('input[name=transaction-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'transaction-search-query' : $("input[name=transaction-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };
      search_transaction(data);
    });
  }

  if ($('button[name=transaction-search-button]').length > 0) {
    $('button[name=transaction-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        'transaction-search-query' : $("input[name=transaction-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };
      search_transaction(data);
    });
  }

  if ($('input[name=transaction-history-search-query]').length > 0) {
    $('input[name=transaction-history-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'transaction-history-search-query' : $("input[name=transaction-history-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };
      search_transaction_history(data);
    });
  }

  if ($('button[name=transaction-history-search-button]').length > 0) {
    $('button[name=transaction-history-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        'transaction-history-search-query' : $("input[name=transaction-history-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };
      search_transaction_history(data);
    });
  }

  if ($('input[name=review-search-query]').length > 0) {
    $('input[name=review-search-query]').on('change', function(e) {
      e.preventDefault();
      var data = {
        'review-search-query' : $("input[name=review-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };
      search_review(data);
    });
  }

  if ($('input[name=review-search-button]').length > 0) {
    $('input[name=review-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        'review-search-query' : $("input[name=review-search-query]").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };
      search_review(data);
    });
  }

  /* report */
  if ($('button[name=report-search-button]').length > 0) {
    $('button[name=report-search-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        '_type' : $("select[name=report-type").val(),
        '_start' : $("input[name=report-date-start").val(),
        '_end' : $("input[name=report-date-end").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };
      report_lookup(data);
    });
  }

  if ($('#material-management').length > 0) {
    $("#material-management").stacktable();
  }//endif


});
