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
        '_token' : $('input[name="_token"]').val()
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
  console.log(max);
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
          '_token' : $('input[name="_token"]').val()
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
      html: "Lakukan pembayaran pesanan?",
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
                  swal({
                    title: "Cetak nota pembayaran",
                    text: "Silahkan cetak nota pembayaran",
                    type: "info",
                    timer: 30000
                  }).then(function(result) {
                    if (result.value) {
                      if ($('#transaction-print-' + id).length > 0) {
                        show_obj('transaction-print-' + id);
                      }
                      else {
                        window.location = '/dashboard/transaction/';
                      }
                    }
                  });
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

function change_review(id) {
  data = {
    '_id' : id,
    '_method' : "get",
    '_token' : $('input[name="search_token"]').val()
  };
  $.ajax({
    type: "POST",
    url: "/dashboard/update/review/" + id,
    data: data,
    cache: false,
    success: function(result) {
      if (result.status == 200) {
        swal({
          title: "Berhasil mengubah status kuisioner",
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
    }
  });
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
          var token = $('input[name=_token]').val();
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
            if (result.auth == 'root') {
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
            if (result.auth != 'root') {
              res += ' readonly ';
            }
            res += '>' + result.content.menu[i].deskripsi_menu + '</textarea>';
            res += '</div></div>';
            if (result.auth == 'root') {
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
        if (result.content && result.content.transaction.length > 0) {
          var token = $('input[name=search_token]').val();
          res += '<div class="row padd-lr-15">';
          res += '<div class="col-md-5 col-sm-6 col-xs-6">';
          res += '<i class="material-icons md-18">arrow_drop_down</i>';
          res += '<label>Transaksi</label></div>';
          res += '<div class="col-md-7 col-sm-6 col-xs-6">';
          res += '<label>Waktu</label></div></div>';

          res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
          res += '<div class="seperator"></div></div></div>';
          for (i = 0; i < result.content.transaction.length; i++) {
            res += '<div onclick="show_obj(\'transaction-' + i + '\');" class="cursor-pointer padd-tb-10 padd-lr-15">';
            res += '<div class="row"><div class="col-md-5 col-sm-6 col-xs-6">';
            res += '#' + result.content.transaction[i].kode_pesanan + ' ' + result.content.transaction[i].pembeli_pesanan + '';
            res += ' [' + result.content.transaction[i].nama_perangkat + ']';
            res += '</div>';
            res += '<div class="col-md-7 col-sm-6 col-xs-6">';
            res += '' + result.content.transaction[i].tanggal_pesanan + ' ' + result.content.transaction[i].waktu_pesanan + '';
            res += '</div></div></div>';
            if (result.content[i]['transaction-detail'].length > 0) {
              res += '<div class="row">';
              res += '<div class="col-md-12 col-sm-12 col-xs-12">';
              res += '<div id="transaction-' + i + '" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">';
              res += '<table class="table table-hover table-striped">';
              res += '<tr><th>Pesanan</th><th>Harga</th>';
              res += '<th>Jumlah</th><th>Sub-Total</th></tr>';
              for (j = 0; j < result.content[i]['transaction-detail'].length; j++) {
                res += '<tr>';
                res += '<td>' + result.content[i]['transaction-detail'][j].nama_menu + '</td>';
                res += '<td>' + result.content[i]['transaction-detail'][j].harga_menu + '</td>';
                res += '<td>' + result.content[i]['transaction-detail'][j].jumlah_pesanan_detil + '</td>';
                res += '<td>' + result.content[i]['transaction-detail'][j].harga_menu * result.content[i]['transaction-detail'][j].jumlah_pesanan_detil + '</td>';
                res += '</tr>';
              }
              res += '<tr>';
              res += '<td colspan="3" class="text-right"><label>Total</label></td>';
              res += '<td>' + result.content.transaction[i].harga_pesanan + '</td>';
              res += '</tr><tr>';
              res += '<td colspan="3" class="text-right"><label>Tunai</label></td>';
              res += '<td width="170px">';
              res += '<input type="number" id="transaction-cash-' + result.content.transaction[i].kode_pesanan + '" name="transaction-cash-' + result.content.transaction[i].kode_pesanan + '"';
              res += ' min="' + result.content.transaction[i].harga_pesanan + '" step="5000" class="input-lengko-default block" placeholder="0" value="' + result.content.transaction[i].harga_pesanan + '"';
              res += ' onchange="cash_back(\'transaction-cash-' + result.content.transaction[i].kode_pesanan + '\', \'transaction-cash-back-' + result.content.transaction[i].kode_pesanan + '\', ' + result.content.transaction[i].harga_pesanan + ', \'Rp\');" />';
              res += '</td></tr>';
              res += '<tr><td colspan="3" class="text-right"><label>Kembali</label></td>';
              res += '<td><input type="text" id="transaction-cash-back-' + result.content.transaction[i].kode_pesanan + '" class="input-lengko-default block" value="0" disabled="disabled" disabled />';
              res += '</td></tr></table>';
              res += '<div class="row padd-tb-10">';
              res += '<div class="col-md-offset-1 col-md-10 col-sm-offset-2 col-sm-8">';
              res += '<button type="button" class="btn-lengko btn-lengko-success pull-right block" onclick="done_transaction(\'' + result.content.transaction[i].kode_pesanan + '\', ' + result.content.transaction[i].harga_pesanan + ');">';
              res += '<span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Bayar';
              res += '</button></div></div></div></div></div>';
            }//endif
            res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
            res += '<div class="seperator"></div></div></div>';

            //print dialog
            res += '<div id="transaction-print-' + result.content.transaction[i].kode_pesanan + '" class="print-overlay" style="display:none; visibility: none;">';
            res += '<div class="row print-overlay-content"><div class="col-md-12">';
            res += '<div class="row">';
            res += '<div class="col-md-offset-11 col-md-1" style="font-size:20pt;">';
            res += '<span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj(\'transaction-print-' + result.content.transaction[i].kode_pesanan + '\'); window.location = \'/dashboard/transaction/\';"></span>';
            res += '</div></div>';

            res += '<div class="row mrg-t-20">';
            res += '<div class="col-md-3">';
            res += '<h2>Transaksi #' + result.content.transaction[i].kode_pesanan + '</h2>';
            res += '<div class="row">';
            res += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
            res += '<button type="button" name="" class="btn-lengko btn-lengko-warning block" onclick="print_dialog(\'transaction\', ' + result.content.transaction[i].kode_pesanan + ');">';
            res += '<span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</button></div>';
            res += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
            res += '<a href="/dashboard/transaction/report/' + result.content.transaction[i].kode_pesanan + '" target="_blank">';
            res += '<button type="button" name="" class="btn-lengko btn-lengko-default block">';
            res += '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>';
            res += 'Lihat</button></a></div></div></div>';
            res += '<div class="col-md-9 mrg-t-20 fluidMedia">';
            res += '<iframe id="transaction-print" src="/dashboard/transaction/report/' + result.content.transaction[i].kode_pesanan + '" width="100%" scrolling="yes"></iframe>';
            res += '</div></div></div></div></div>';
            //print dialog

          }//endfor
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
        if (result.content && result.content['transaction-history'].length > 0) {
          var token = $('input[name=search_token]').val();
          res += '<div class="row padd-lr-15">';
          res += '<div class="col-md-5 col-sm-6 col-xs-6">';
          res += '<i class="material-icons md-18">arrow_drop_down</i>';
          res += '<label>Transaksi</label></div>';
          res += '<div class="col-md-7 col-sm-6 col-xs-6">';
          res += '<label>Waktu</label></div></div>';

          res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
          res += '<div class="seperator"></div></div></div>';
          for (i = 0; i < result.content['transaction-history'].length; i++) {
            res += '<div onclick="show_obj(\'transaction-' + i + '\');" class="cursor-pointer padd-tb-10 padd-lr-15">';
            res += '<div class="row"><div class="col-md-5 col-sm-6 col-xs-6">';
            res += '#' + result.content['transaction-history'][i].kode_pesanan + ' ' + result.content['transaction-history'][i].pembeli_pesanan + '';
            res += ' [' + result.content['transaction-history'][i].nama_perangkat + ']';
            res += '</div>';
            res += '<div class="col-md-7 col-sm-6 col-xs-6">';
            res += '' + result.content['transaction-history'][i].tanggal_pesanan + ' ' + result.content['transaction-history'][i].waktu_pesanan + '';
            res += '</div></div></div>';
            if (result.content[i]['transaction-history-detail'].length > 0) {
              res += '<div class="row">';
              res += '<div class="col-md-12 col-sm-12 col-xs-12">';
              res += '<div id="transaction-' + i + '" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">';
              res += '<table class="table table-hover table-striped">';
              res += '<tr><th>Pesanan</th><th>Harga</th>';
              res += '<th>Jumlah</th><th>Sub-Total</th></tr>';
              for (j = 0; j < result.content[i]['transaction-history-detail'].length; j++) {
                res += '<tr>';
                res += '<td>' + result.content[i]['transaction-history-detail'][j].nama_menu + '</td>';
                res += '<td>' + result.content[i]['transaction-history-detail'][j].harga_menu + '</td>';
                res += '<td>' + result.content[i]['transaction-history-detail'][j].jumlah_pesanan_detil + '</td>';
                res += '<td>' + result.content[i]['transaction-history-detail'][j].harga_menu * result.content[i]['transaction-history-detail'][j].jumlah_pesanan_detil + '</td>';
                res += '</tr>';
              }
              res += '<tr>';
              res += '<td colspan="3" class="text-right"><label>Total</label></td>';
              res += '<td>' + result.content['transaction-history'][i].harga_pesanan + '</td>';
              res += '</tr><tr>';
              res += '<td colspan="3" class="text-right"><label>Tunai</label></td>';
              res += '<td width="170px">' + result.content['transaction-history'][i].harga_pesanan + '</td></tr></table>';

              res += '<div class="row padd-tb-10">';
              res += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
              res += '<button type="button" name="" class="btn-lengko btn-lengko-warning block" onclick="show_obj(\'transaction-history-print-' + result.content['transaction-history'][i].kode_pesanan + '\');">';
              res += '<span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</button></div>';
              res += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
              res += '<a href="/dashboard/transaction/report/' + result.content['transaction-history'][i].kode_pesanan + '" target="_blank">';
              res += '<button type="button" name="" class="btn-lengko btn-lengko-default block">';
              res += '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>';
              res += 'Lihat</button></a></div></div>';

            }//endif
            res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
            res += '<div class="seperator"></div></div></div>';

            //print dialog
            res += '<div id="transaction-history-print-' + result.content['transaction-history'][i].kode_pesanan + '" class="print-overlay" style="display:none; visibility: none;">';
            res += '<div class="row print-overlay-content"><div class="col-md-12">';
            res += '<div class="row">';
            res += '<div class="col-md-offset-11 col-md-1" style="font-size:20pt;">';
            res += '<span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj(\'transaction-history-print-' + result.content['transaction-history'][i].kode_pesanan + '\');"></span>';
            res += '</div></div>';

            res += '<div class="row mrg-t-20">';
            res += '<div class="col-md-3">';
            res += '<h2>Transaksi #' + result.content['transaction-history'][i].kode_pesanan + '</h2>';
            res += '<div class="row">';
            res += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
            res += '<button type="button" name="" class="btn-lengko btn-lengko-warning block" onclick="print_dialog(\'transaction-history\', ' + result.content['transaction-history'][i].kode_pesanan + ');">';
            res += '<span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</button></div>';
            res += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
            res += '<a href="/dashboard/transaction/report/' + result.content['transaction-history'][i].kode_pesanan + '" target="_blank">';
            res += '<button type="button" name="" class="btn-lengko btn-lengko-default block">';
            res += '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>';
            res += 'Lihat</button></a></div></div></div>';
            res += '<div class="col-md-9 mrg-t-20 fluidMedia">';
            res += '<iframe id="transaction-history-print" src="/dashboard/transaction/report/' + result.content['transaction-history'][i].kode_pesanan + '" width="100%" scrolling="yes"></iframe>';
            res += '</div></div></div></div></div>';
            //print dialog
          }//endfor
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
          res += '<div class="row padd-lr-15 open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Klik untuk melihat detil kuisioner">';
          res += '<div class="col-md-3 col-sm-3 col-xs-4">';
          res += '<i class="material-icons md-18">arrow_drop_down</i>';
          res += '<label>Responden</label></div>';
          res += '<div class="col-md-5 col-sm-5 col-xs-4">';
          res += '<label>Kritik & Saran</label></div>';
          res += '<div class="col-md-4 col-sm-4 col-xs-4">';
          res += '<label>Waktu</label></div></div>';

          res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><div class="seperator"></div></div></div>';
          for (i = 0; i < result.content['review-device'].length; i++) {
            res += '<div onclick="show_obj(\'review-' + i + '\');" class="cursor-pointer padd-tb-10 padd-lr-15">';
            res += '<div class="row"><div class="col-md-3 col-sm-3 col-xs-4">';
            res += '#' + result.content['review-device'][i].kode_kuisioner_perangkat + ' (' + result.content['review-device'][i].pembeli_kuisioner_perangkat + ')</div>';
            res += '<div class="col-md-5 col-sm-5 col-xs-4">' + result.content['review-device'][i].pesan_kuisioner_perangkat + '</div>';
            res += '<div class="col-md-4 col-sm-4 col-xs-4">';
            res += '' + result.content['review-device'][i].tanggal_kuisioner_perangkat + ' ' + result.content['review-device'][i].waktu_kuisioner_perangkat + '</div></div></div>';
            if (result.content[i]['review-detail'].length > 0) {
              res += '<div class="row">';
              res += '<div class="col-md-12 col-sm-12 col-xs-12">';
              res += '<div id="review-' + i + '" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">';
              res += '<table class="table table-hover table-striped">';
              res += '<tr><th>Kuisioner</th><th>Poin</th></tr>';
              for (j = 0; j < result.content[i]['review-detail'].length; j++) {
                res += '<tr><td> [' + result.content[i]['review-detail'][j].judul_kuisioner + '] ' + result.content[i]['review-detail'][j].isi_kuisioner + ' </td>';
                res += '<td><select id="customer-reviews-' + result.content[i]['review-detail'][j].kode_kuisioner_detil + '" class="barrating-readonly">';
                for (k = 1; k <= 5; k++) {
                  res += '<option value="' + k + '"';
                  if (k === result.content[i]['review-detail'][j].poin_kuisioner_detil) {
                      res += 'selected';
                  }//endif
                  res += '>' + k + '</option>';
                }//endofr
                res += '</select></td></tr>';
              }//endfor

              res += '</table>';
              res += '<div class="row padd-tb-10"><div class="col-md-6">';
              res += '<button class="btn-lengko btn-lengko-danger block" type="button" onclick="delete_review_device(\'' + result.content['review-device'][i].kode_kuisioner_perangkat + '\');">';
              res += '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</button></div>';
              res += '<div class="col-md-6">';
              res += '<form method="post" action="/dashboard/update/reviewdevice">';
              res += '<input type="hidden" name="_id" value="' + result.content['review-device'][i].kode_kuisioner_perangkat + '">';
              res += '<input type="hidden" name="_token" value="' + token + '">';
              res += '<input type="hidden" name="_method" value="put">';
              if (result.content['review-device'][i].status_kuisioner_perangkat === 1) {
                res += '<button class="btn-lengko btn-lengko-default block" type="submit">';
                res += '<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> Sembunyikan';
                res += '</button>';
              }
              else if (result.content['review-device'][i].status_kuisioner_perangkat === 0) {
                res += '<button class="btn-lengko btn-lengko-default block" type="submit">';
                res += '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Tampilkan';
                res += '</button>';
              }//endif
              res += '</form></div></div></div></div></div>';
            }//endif
            res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><div class="seperator"></div></div></div>';
          }//endloop
        }
        else {
          res = '<div class="row padd-lr-15"><div class="col-md-8">';
          res += '<div class="alert alert-warning">Kuisioner tidak ditemukan</div></div></div>';
        }
        $('#review-card-section').html(res);
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
              res += '<div class="row"><div class="col-md-12"></div></div>';
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

function report_print(data) {
  if (data._start && data._end) {
    type = 'date/' + data._start + '/' + data._end;
  }
  else {
    type = data._type;
  }
  swal({
    title: "Cetak laporan pendapatan?",
    type: "question",
    timer: 10000,
    showCancelButton: true,
    confirmButtonText: 'Iya',
    confirmButtonColor: '#2c3e50',
    cancelButtonText: 'Tidak'
  }).then(function(result) {
    if (result.value) {
      var res = '';
      res += '<div id="report-card-print" class="print-overlay">';
      res += '<div class="row print-overlay-content"><div class="col-md-12"><div class="row">';
      res += '<div class="col-md-offset-11 col-md-1" style="font-size:20pt;">';
      res += '<span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj(\'report-card-print\');"></span>';
      res += '</div></div>';

      res += '<div class="row mrg-t-20"><div class="col-md-3">';
      res += '<h2>Laporan Pendapatan</h2>';
      res += '<div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
      res += '<button type="button" name="" class="btn-lengko btn-lengko-warning block" onclick="print_dialog(\'report-income\', \'\');">';
      res += '<span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</button></div>';
      res += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
      res += '<a href="/dashboard/report/income/' + type + '" target="_blank">';
      res += '<button type="button" name="" class="btn-lengko btn-lengko-default block">';
      res += '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>Lihat</button></a>';
      res += '</div></div></div>';
      res += '<div class="col-md-9 mrg-t-20 fluidMedia">';
      res += '<iframe id="report-income-print" src="/dashboard/report/income/' + type + '" width="100%" height="250px" scrolling="yes"></iframe>';
      res += '</div></div></div></div></div>';
      $('#report-card-print-section').html(res);
      show_obj('report-card-print');
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

function refresh_confirmation_order() {
  if ($('#order-confirmation-panel').length > 0) {
    var data = {
      '_method' : "POST",
      '_token' : $('meta[name="csrf-token"]').attr('content'),
    };
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: "POST",
      url: "/dashboard/refresh/confirmationorder",
      data: data,
      cache: false,
      success: function(result) {
        if (result.status == 200) {
          var res = '';
          var token = $("input[name=_token]").val();
          if (result.content['order-confirmation'].length > 0) {
            res += '<div class="row">';
            res += '<div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6">';
            res += '<div class="input-group">';
            res += '<input type="text" name="order-search-query" class="form-control input-lengko-default" placeholder="Cari Pesanan" />';
            res += '<span class="input-group-btn">';
            res += '<button class="btn btn-default" type="button">';
            res += '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>';
            res += '</button></span></div></div>  </div>';

            res += '<div class="row">';
            res += '<div class="col-md-12">';
            res += '<div id="order-card-section" class="padd-tb-10">';
            res += '<div class="row padd-lr-15 open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Klik untuk melihat detil pesanan">';
            res += '<div class="col-md-3 col-sm-3 col-xs-3"><label>Transaksi</label></div>';
            res += '<div class="col-md-3 col-sm-3 col-xs-3"><label>Waktu</label></div>';
            res += '<div class="col-md-3 col-sm-3 col-xs-3"><label>Catatan</label></div>';
            res += '<div class="col-md-3 col-sm-3 col-xs-3"><label>Perangkat</label></div></div>';

            res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
            res += '<div class="seperator"></div></div></div>';

            for (i = 0; i < result.content['order-confirmation'].length; i++) {
              res += '<div onclick="show_obj(\'order-confirmation-' + i + '\');" class="row cursor-pointer padd-tb-10 padd-lr-15">';
              res += '<div class="col-md-3 col-sm-3 col-xs-3">';
              res += '[#' + result.content['order-confirmation'][i].kode_pesanan + '] ' + result.content['order-confirmation'][i].pembeli_pesanan + '</div>';
              res += '<div class="col-md-3 col-sm-3 col-xs-3">';
              res += '' + result.content['order-confirmation'][i].tanggal_pesanan + ' ' + result.content['order-confirmation'][i].waktu_pesanan + '</div>';
              res += '<div class="col-md-3 col-sm-3 col-xs-3">';
              res += '' + result.content['order-confirmation'][i].catatan_pesanan + '</div>';
              res += '<div class="col-md-3 col-sm-3 col-xs-3">';
              res += '' + result.content['order-confirmation'][i].nama_perangkat + '</div></div>';
              if (result.content[i]['order-confirmation-detail'].length > 0) {
                res += '<div class="row">';
                res += '<div class="col-md-12 col-sm-12 col-xs-12">';
                res += '<div id="order-confirmation-' + i + '" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">';
                res += '<table class="table table-hover table-striped">';
                res += '<tr><th>Pesanan</th><th>Harga</th><th>Jumlah</th><th>Sub-Total</th></tr>';
                for (j = 0; j < result.content[i]['order-confirmation-detail'].length; j++) {
                  res += '<tr><td>' + result.content[i]['order-confirmation-detail'][j].nama_menu + '</td>';
                  res += '<td>Rp' + result.content[i]['order-confirmation-detail'][j].harga_menu + '</td>';
                  res += '<td>' + result.content[i]['order-confirmation-detail'][j].jumlah_pesanan_detil + '</td>';
                  res += '<td>Rp' + (result.content[i]['order-confirmation-detail'][j].harga_menu * result.content[i]['order-confirmation-detail'][j].jumlah_pesanan_detil) + '</td></tr>';
                }//endfor
                res += '<tr><td colspan="3" class="text-right"><label>Total</label></td>';
                res += '<td' + result.content['order-confirmation'][i].harga_pesanan + '</td></tr></table>';

                res += '<div class="row">';
                res += '<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 padd-tb-10 padd-lr-15">';
                res += '<form name="" action="/dashboard/confirm/order" method="post">';
                res += '<input type="hidden" name="_token" value="' + token + '">';
                res += '<input type="hidden" name="order-confirm-id" value="' + result.content['order-confirmation'][i].kode_pesanan + '" />';
                res += '<button type="submit" class="btn-lengko btn-lengko-success block" width="80px">';
                res += '<i class="material-icons md-18">done_all</i> Konfirmasi Pesanan</button></form>';
                res += '</div></div></div></div></div>';
              }//endif
              res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
              res += '<div class="seperator"></div></div></div>';
            }//endfor

            res += '</div><hr /></div></div>';
          }
          else {
            res += '<div class="row"><div class="col-md-4">';
            res += '<img src="/files/images/jokes/patrick-skripsi.png" width="250px" height="250px" />';
            res += '</div>';
            res += '<div class="col-md-8"><div class="alert alert-warning">';
            res += 'Belum ada pesanan baru;<br />Relax and enjoy yourlife!</div></div></div>';
          }//endif
          $('#order-confirmation-panel').html(res);
        }
        else {
          window.location = "dashboard/order";
        }//endif
      },
      error: function(result) {

      }
    });
  }//panel dom available
}

function refresh_queue_order() {
  if ($('#order-queue-panel').length > 0) {
    var data = {
      '_method' : "POST",
      '_token' : $('meta[name="csrf-token"]').attr('content'),
    };
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: "POST",
      url: "/dashboard/refresh/queueorder",
      data: data,
      cache: false,
      success: function(result) {
        if (result.status == 200) {
          var res = '';
          var token = $("input[name=_token]").val();

          if (result.content.order.length > 0) {
            res += '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
            for (i = 0; i < result.content.order.length; i++) {
              res += '<div class="panel panel-default ';
              if (i === 0) {
                res += 'panel-custom';
              }
              res += ' ">';
              res += '<div class="panel-heading" role="tab" id="head-order-' + result.content.order[i].kode_pesanan + '" style="height: 50px;">';
              res += '<h4 class="panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#order-' + result.content.order[i].kode_pesanan + '" aria-expanded="true" aria-controls="order-' + result.content.order[i].kode_pesanan + '"  style="height: 50px;">';
              res += '#' + result.content.order[i].kode_pesanan + ' [' + result.content.order[i].nama_perangkat + ']</h4></div>';

              res += '<div id="order-' + result.content.order[i].kode_pesanan + '" class="panel-collapse collapse';
              if (i === 0) {
                res += 'in';
              }
              res += '" role="tabpanel" aria-labelledby="head-order-' + result.content.order[i].kode_pesanan + '">';
              res += '<div class="panel-body"><div class="';
              if (i > 0) {
                res += 'overlay';
              }
              res += ' "><div class="row"><div class="col-md-12">';
              res += '<h3 class="text-center">#' + result.content.order[i].kode_pesanan + ' (' + result.content.order[i].nama_perangkat + ')</h3>';
              res += '<hr /></div></div>';

              res += '<div class="row"><div class="col-md-4 col-sm-4 col-xs-6"><label>Waktu:</label> <br />';
              res += '' + result.content.order[i].tanggal_pesanan + ' ' + result.content.order[i].waktu_pesanan + '</div>';
              res += '<div class="col-md-5 col-sm-5 col-xs-6"><label>Catatan:</label><br />';
              res += '' + result.content.order[i].catatan_pesanan + '</div>';
              res += '<div class="col-md-3 col-sm-3 col-xs-12">';
              res += '<button type="button" class="btn-lengko btn-lengko-success block" onclick="done_order(' + result.content.order[i].kode_pesanan + ');" title="Tandai sudah selesai semua">';
              res += '<i class="material-icons md-18">done_all</i> Selesai semua</button></div></div>';

              res += '<div class="row padd-tb-0"><div class="col-md-12">';
              res += '<hr /></div></div>';

              res += '<div class="row"><div class="col-md-6 col-sm-6">';

              res += '<div class="row"><div class="col-md-offset-4 col-md-4">';
              res += '<h3 class="text-center border-btm">Makanan</h3></div></div>';
              res += '<div class="row"><div class="col-md-12">';
              if (result.content[i]['order-detail-food'].length > 0) {
                for (j = 0; j < result.content[i]['order-detail-food'].length; j++) {
                  res += '<div class="row padd-tb-10"><div class="col-md-9 col-sm-9">';
                  res += '' + result.content[i]['order-detail-food'][j].nama_menu + ' (' + result.content[i]['order-detail-food'][j].jumlah_pesanan_detil + ')</div>';
                  res += '<div class="col-md-3 col-sm-3">';
                  if (result.content[i]['order-detail-food'][j].status_pesanan_detil == 'P') {
                    res += '<button type="button" class="btn-lengko btn-lengko-success block" onclick="done_menu(' + result.content[i]['order-detail-food'][j].kode_pesanan_detil + ')" style="font-size: 10px;">';
                    res += '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    res += '</button>';
                  }
                  else if (result.content[i]['order-detail-food'][j].status_pesanan_detil == 'D') {
                    res += '<button type="button" class="btn-lengko btn-lengko-warning block" style="font-size: 10px;">';
                    res += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    res += '</button>';
                  }
                  res += '</div></div>';
                }//endfor
              }
              else {
                res += '<div class="row"><div class="col-md-12">';
                res += '<div class="alert alert-warning">Tidak pesan makanan</div></div></div>';
              }//endif

              res += '</div></div>  </div>';

              res += '<div class="col-md-6 col-sm-6"><div class="row">';
              res += '<div class="col-md-offset-4 col-md-4">';
              res += '<h3 class="text-center border-btm">Minuman</h3></div></div>';

              res += '<div class="row">';
              res += '<div class="col-md-12">';
              if (result.content[i]['order-detail-drink'].length > 0) {
                for (k = 0; k < result.content[i]['order-detail-drink'].length; k++) {
                  res += '<div class="row padd-tb-10"><div class="col-md-9 col-sm-9">';
                  res += '' + result.content[i]['order-detail-drink'][k].nama_menu + ' (' + result.content[i]['order-detail-drink'][k].jumlah_pesanan_detil + ')</div>';
                  res += '<div class="col-md-3 col-sm-3">';
                  if (result.content[i]['order-detail-drink'][k].status_pesanan_detil == 'P') {
                    res += '<button type="button" class="btn-lengko btn-lengko-success block" onclick="done_menu('+ result.content[i]['order-detail-drink'][k].kode_pesanan_detil + ')" style="font-size: 10px;">';
                    res += '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    res += '</button>';
                  }
                  else if (result.content[i]['order-detail-drink'][k].status_pesanan_detil == 'D') {
                    res += '<button type="button" class="btn-lengko btn-lengko-warning block" style="font-size: 10px;">';
                    res += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    res += '</button>';
                  }
                  res += '</div></div>';
                }
              }
              else {
                res += '<div class="row"><div class="col-md-12">';
                res += '<div class="alert alert-warning">Tidak pesan minuman</div></div></div>';
              }

              res += '</div></div></div></div>';

              res += '<div class="row padd-tb-0">';
              res += '<div class="col-md-12"><hr /></div></div>';

              res += '</div></div></div></div>';
            }
            res += '</div>';
          }
          else {
            res += '<div class="row"><div class="col-md-8">';
            res += '<div class="alert alert-warning">Belum ada pesanan baru;';
            res += '<br />Relax and enjoy yourlife!</div></div>';
            res += '<div class="col-md-4"><img src="/files/images/jokes/i-see-what-u-did.jpg" width="250px" height="250px" />';
            res += '</div></div>';
          }//endif
          $('#order-queue-panel').html(res);
        }
        else {
          window.location = "dashboard/order";
        }//endif
      },
      error: function(result) {

      }
    });
  }//panel dom available
}

function refresh_transaction() {
  if ($('#transaction-panel').length > 0) {
    var data = {
      '_method' : "POST",
      '_token' : $('meta[name="csrf-token"]').attr('content'),
    };
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: "POST",
      url: "/dashboard/refresh/transaction",
      data: data,
      cache: false,
      success: function(result) {
        if (result.status == 200) {
          var res = '';
          var token = $('meta[name="csrf-token"]').attr('content');
          if (result.content.transaction.length > 0) {
            res += '<div class="row"><div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6">';
            res += '<div class="input-group padd-tb-10">';
            res += '<input type="text" name="transaction-search-query" class="form-control input-lengko-default" placeholder="Cari Transaksi" />';
            res += '<span class="input-group-btn">';
            res += '<button class="btn btn-default" name="transaction-search-button" type="button">';
            res += '<span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>';
            res += '</span></div></div></div>';

            res += '<div class="row">';
            res += '<div class="col-md-3  text-center">';
            res += '<i class="material-icons md-180 desktop-only">attach_money</i>';
            res += '<h3 class="desktop-only mrg-t-0">Transaksi</h3>';
            res += '</div>';

            res += '<div class="col-md-9"><div id="transaction-card-section" class="padd-tb-10">';
            res += '<div class="row padd-lr-15"><div class="col-md-5 col-sm-6 col-xs-6">';
            res += '<i class="material-icons md-18">arrow_drop_down</i><label>Transaksi</label></div>';
            res += '<div class="col-md-7 col-sm-6 col-xs-6"><label>Waktu</label></div></div>';

            res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
            res += '<div class="seperator"></div></div></div>';
            for (i = 0; i < result.content.transaction.length; i++) {
              res += '<div onclick="show_obj(\'transaction-' + i + '\');" class="cursor-pointer padd-tb-10 padd-lr-15">';
              res += '<div class="row"><div class="col-md-5 col-sm-6 col-xs-6">';
              res += '#' + result.content.transaction[i].kode_pesanan + ' ' + result.content.transaction[i].pembeli_pesanan;
              res += '[' + result.content.transaction[i].nama_perangkat + '</div>';
              res += '<div class="col-md-7 col-sm-6 col-xs-6">';
              res += '' + result.content.transaction[i].tanggal_pesanan + ' ' + result.content.transaction[i].waktu_pesanan + '</div></div></div>';
              if (result.content[i]['transaction-detail'].length > 0) {
                res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
                res += '<div id="transaction-' + i + '" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">';
                res += '<table class="table table-hover table-striped">';
                res += '<tr><th>Pesanan</th><th>Harga</th><th>Jumlah</th><th>Sub-Total</th></tr>';
                for (j = 0; j < result.content[i]['transaction-detail'].length; j++) {
                  res += '<tr><td>' + result.content[i]['transaction-detail'][j].nama_menu + '</td>';
                  res += '<td>Rp' + result.content[i]['transaction-detail'][j].harga_menu + '</td>';
                  res += '<td>' + result.content[i]['transaction-detail'][j].jumlah_pesanan_detil + '</td>';
                  res += '<td>Rp' + (result.content[i]['transaction-detail'][j].harga_menu * result.content[i]['transaction-detail'][j].jumlah_pesanan_detil) + '</td></tr>';
                }//endfor
                res += '<tr><td colspan="3" class="text-right"><label>Total</label></td>';
                res += '<td>Rp' + result.content.transaction[i].harga_pesanan + '</td></tr>';
                res += '<tr><td colspan="3" class="text-right"><label>Tunai</label></td>';
                res += '<td width="170px"><input type="number" id="transaction-cash-' + result.content.transaction[i].kode_pesanan + '" name="transaction-cash-' + result.content.transaction[i].kode_pesanan + '" min="' + result.content.transaction[i].harga_pesanan + '" step="5000" class="input-lengko-default block" placeholder="0" value="' + result.content.transaction[i].harga_pesanan;
                res += '" onchange="cash_back(\'transaction-cash-' + result.content.transaction[i].kode_pesanan + '\', \'transaction-cash-back-' + result.content.transaction[i].kode_pesanan + '\', ' + result.content.transaction[i].harga_pesanan + ', \'Rp\');" />';
                res += '</td></tr>';
                res += '<tr><td colspan="3" class="text-right"><label>Kembali</label></td>';
                res += '<td><input type="text" id="transaction-cash-back-' + result.content.transaction[i].kode_pesanan + '" class="input-lengko-default block" value="0" disabled="disabled" disabled />';
                res += '</td></tr></table>';

                res += '<div class="row padd-tb-10">';
                res += '<div class="col-md-offset-1 col-md-10 col-sm-offset-2 col-sm-8">';
                res += '<button type="button" class="btn-lengko btn-lengko-success pull-right block" onclick="done_transaction(' + result.content.transaction[i].kode_pesanan + ', ' + result.content.transaction[i].harga_pesanan + ');">';
                res += '<span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Bayar</button>';
                res += '</div></div></div></div></div>';
              }//endif

              res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
              res += '<div class="seperator"></div></div></div>';

              res += '<div id="transaction-print-' + result.content.transaction[i].kode_pesanan + '" class="print-overlay" style="display:none; visibility: none;">';
              res += '<div class="row print-overlay-content"><div class="col-md-12">';

              res += '<div class="row">';
              res += '<div class="col-md-offset-11 col-md-1" style="font-size:20pt;">';
              res += '<span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj(\'transaction-print-' + result.content.transaction[i].kode_pesanan + '\'); window.location = \'/dashboard/transaction/\';"></span>';
              res += '</div></div>';

              res += '<div class="row mrg-t-20"><div class="col-md-3">';
              res += '<h2>Transaksi #' + result.content.transaction[i].kode_pesanan + '</h2>';
              res += '<div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
              res += '<button type="button" name="" class="btn-lengko btn-lengko-warning block" onclick="print_dialog(\'transaction\', ' + result.content.transaction[i].kode_pesanan + ');">';
              res += '<span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</button></div>';

              res += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
              res += '<a href="/dashboard/transaction/report/' + result.content.transaction[i].kode_pesanan + '" target="_blank">';
              res += '<button type="button" name="" class="btn-lengko btn-lengko-default block">';
              res += '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>Lihat</button></a>';
              res += '</div></div></div>';

              res += '<div class="col-md-9 mrg-t-20 fluidMedia">';
              res += '<iframe id="transaction-print" src="transaction/report/' + result.content.transaction[i].kode_pesanan + '" width="100%" height="250px" scrolling="yes"></iframe>';
              res += '</div></div></div></div></div>';

            }//endfor
            res += '</div></div></div>';
          }
          else {
              res += '<div class="row"><div class="col-md-8">';
              res += '<div class="alert alert-warning">Belum ada Transaksi baru, relax and be happy!';
              res += '</div></div></div>';
          }//endif
          $('#transaction-panel').html(res);
        }
        else {
          window.location = "dashboard/transaction";
        }//endif
      },
      error: function(result) {

      }
    });
  }//panel dom available
}

var interval = 5000;
var lastnotif = 0;
var inc = 0;
function notifier() {
  var data = {
    '_method' : "POST",
    '_token' : $('meta[name="csrf-token"]').attr('content'),
  };
  $.ajax({
    type: 'POST',
    url: '/dashboard/get/notification',
    data: data,
    dataType: 'json',
    cache: false,
    success: function (data) {
      $('#notifs').html(data.content.length);
      $('#notifnavs').html('Beranda (' + data.content.length + ') ');
      inc++;
    },
    complete: function (data) {
      //console.dir(data); //good way thanks stackoverflow ^^
      data = data.responseJSON;
      if (data) {
        if (data.content.length > 0) {
          if (lastnotif != data.content[0].kode_pemberitahuan && inc > 1) {
            refresh_confirmation_order();
            refresh_queue_order();
            refresh_transaction();
            generate_toast({
              'heading': 'Pemberitahuan',
              'text': data.content[0].isi_pemberitahuan,
              'icon': 'info',
              'bgColor': '#141414',
              'textColor': '#ecf0f1',
              'loader': false,
              'loaderBg': '#3498db',
              'allowToastClose': true,
              'hideAfter': false,
              'stack': 7
            });
          }
          lastnotif = data.content[0].kode_pemberitahuan;
        }
      }
      setTimeout(notifier, interval);//reschedule
    }
  });
}
setTimeout(notifier, interval);

function print_dialog(type, id) {
  var iframe ='';
  switch (type) {
    case 'transaction':
      iframe = $("#transaction-print");
    break;
    case 'transaction-history':
      iframe = $("#transaction-history-print");
    break;
    case 'report-income':
      iframe = $("#report-income-print");
    break;
    default:
  }
  iframe.get(0).contentWindow.print();
}



$(document).ready(function() {
  notifier();

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
              res += '<div class="row padd-lr-15 open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Klik untuk melihat detil pesanan">';
              res += '<div class="col-md-3 col-sm-3 col-xs-3"><label>Transaksi</label></div>';
              res += '<div class="col-md-3 col-sm-3 col-xs-3"><label>Waktu</label></div>';
              res += '<div class="col-md-3 col-sm-3 col-xs-3"><label>Pembeli</label></div>';
              res += '<div class="col-md-3 col-sm-3 col-xs-3"><label>Perangkat</label></div>';
              res += '</div>';

              res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><div class="seperator"></div></div></div>';

              for (i = 0; i < result.content['order-confirmation'].length; i++) {
                res += '<div onclick="show_obj(\'order-confirmation-' + i + '\');" class="row cursor-pointer padd-tb-10 padd-lr-15">';
                res += '<div class="col-md-3 col-sm-3 col-xs-3">#' + result.content['order-confirmation'][i].kode_pesanan + '</div>';
                res += '<div class="col-md-3 col-sm-3 col-xs-3">' + result.content['order-confirmation'][i].tanggal_pesanan + ' ' + result.content['order-confirmation'][i].waktu_pesanan + '</div>';
                res += '<div class="col-md-3 col-sm-3 col-xs-3">' + result.content['order-confirmation'][i].pembeli_pesanan + '</div>';
                res += '<div class="col-md-3 col-sm-3 col-xs-3">' + result.content['order-confirmation'][i].nama_perangkat + '</div>';
                res += '</div>';
                if (result.content[i]['order-confirmation-detail'].length > 0) {
                res += '  <div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
                res += '<div id="order-confirmation-' + i + '" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">';
                res += '<table class="table table-hover table-striped">';
                res += '<tr><th>Pesanan</th><th>Harga</th><th>Jumlah</th><th>Sub-Total</th></tr>';
                for (j = 0; j < result.content[i]['order-confirmation-detail'].length; j++) {
                  res += '<tr><td>' + result.content[i]['order-confirmation-detail'][j].nama_menu + '</td>';
                  res += '<td>' + result.content[i]['order-confirmation-detail'][j].harga_menu + '</td>';
                  res += '<td>' + result.content[i]['order-confirmation-detail'][j].jumlah_pesanan_detil + '</td>';
                  res += '<td>' + result.content[i]['order-confirmation-detail'][j].harga_menu * result.content[i]['order-confirmation-detail'][j].jumlah_pesanan_detil + '</td></tr>';
                }//endfor
                res += '<tr><td colspan="3" class="text-right"><label>Total</label></td>';
                res += '<td>Rp' + result.content['order-confirmation'][i].harga_pesanan + '</td></tr></table>';

                res += '<div class="row">';
                res += '<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 padd-tb-10 padd-lr-15">';
                res += '<form name="" action="/dashboard/confirm/order" method="post">';
                res += '<input type="hidden" name="_token" value="' + token + '">';
                res += '<input type="hidden" name="order-confirm-id" value="' + result.content['order-confirmation'][i].kode_pesanan + '" />';
                res += '<button type="submit" class="btn-lengko btn-lengko-warning block" width="80px">Konfirmasi Pesanan</button>';
                res += '</form></div></div></div></div></div>';
                }//endif
                res += '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><div class="seperator"></div></div></div>';
              }//endloop
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

  if ($('button[name=report-print-button]').length > 0) {
    $('button[name=report-print-button]').on('click', function(e) {
      e.preventDefault();
      var data = {
        '_type' : $("select[name=report-type").val(),
        '_start' : $("input[name=report-date-start").val(),
        '_end' : $("input[name=report-date-end").val(),
        '_method' : "post",
        '_token' : $("input[name=search_token]").val()
      };
      report_print(data);
    });
  }


  if ($('#material-management').length > 0) {
    $("#material-management").stacktable();
  }

  if ($('#transaction-management').length > 0) {
    $("#transaction-management").stacktable();
  }

  if ($('#transaction-history-management').length > 0) {
    $("#transaction-history-management").stacktable();
  }

  if ($('.stackable'.length > 0)) {
    $('.stackable').stacktable();
  }

});
