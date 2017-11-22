function call_waiter(device) {
  swal({
    title: "Butuh bantuan?",
    text: "Jangan sungkan, kami siap membantu (^_^)/",
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
        title: "Segera ke sana!",
        text: "Lagi gak ada siapa-siapa ya sayang? OTW!",
        icon: "success",
        timer: 30000
      });
      break;
      default:
    }
  });
}
