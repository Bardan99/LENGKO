function call_waiter(device) {
  swal({
    title: "Butuh bantuan?",
    text: "Jangan sungkan, kami siap membantu anda (^_^)/",
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
      swal({
        title: "Berhasil",
        text: "Kami akan segera membantu anda, tunggu kami di situ; awas jangan salting ya!",
        icon: "success",
        timer: 30000
      });
      break;
      default:
    }
  });
}
