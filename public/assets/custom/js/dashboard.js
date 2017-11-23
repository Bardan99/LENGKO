$(document).ready(function() {

  /* device */
  if ($('#device-add').length > 0) {
    $('#device-add').on('submit', function(e) {

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
      e.preventDefault();
    });
  }


  /*
    swal({
      title: "Oops terjadi kesalahan",
      html: "",
      type: "warning",
      timer: 10000,
      showCancelButton: false,
      confirmButtonText: 'Iya',
      confirmButtonColor: '#2c3e50',
    });
    */
});
