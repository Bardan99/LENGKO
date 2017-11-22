
if ($('#dash-employee-profile').length > 0) {
  $('#dash-employee-profile').submit(function(event) {
    swal({
      title: "Ubah profil?",
      text: "",
      icon: "info",
      buttons: {
        cancel: {
          text: "Tidak",
          value: false,
          visible: true,
          closeModal: true
        },
        confirm: {
          text: "Iya",
          value: true,
          visible: true,
          closeModal: true
        }
      },
      closeOnClickOutside: false,
      closeOnEsc: false,

    })
    .then((value) => {
      switch (value) {
        case true:
          $.ajax({
            type: "POST",
            url: "/dashboard/update/profile/root",
            //data: {inc: inc},
            success: function(result) {
              if (result) {
                swal({
                  title: "Berhasil mengubah profil",
                  text: "",
                  icon: "success",
                  timer: 30000
                });
              }
              else {
                swal({
                  title: "Gagal mengubah profil",
                  text: "Oops, sepertinya ada yang salah!",
                  icon: "danger",
                  timer: 30000
                });
              }
              console.log(result);
            }
          });
        break;
        default:
      }
    });

    event.preventDefault();
  });
}
