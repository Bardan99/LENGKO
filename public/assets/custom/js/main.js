function call_waiter(device) {
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
      swal({
        title: 'Segera ke sana!',
        text: 'Kalau disamperin jangan salting ya >_<',
        type: 'success',
        timer: 3000
      });
    // result.dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
    }
  });
}
