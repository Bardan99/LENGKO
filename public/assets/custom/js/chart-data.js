$(document).ready(function() {
  /* Chart settings */
  if ($('#device-statistic').length > 0) {
    var device_statistic = $('#device-statistic');
    var data_device_statistic = {
      datasets: [{
        data: [2, 2, 2],
        labels: ['Available', 'Unavailable', 'Disabled'],
        backgroundColor: [
          'rgba(39, 173, 96, 0.4)',
          'rgba(231, 76, 60, 0.4)',
          'rgba(127, 141, 142, 0.4)',
        ]
      }],

      labels: [ //tooltip
        'Tidak sedang digunakan',
        'Sedang digunakan',
        'Tidak diketahui'
      ]
    };
    var options_device_statistic = {};
    var chart_device_statistic = new Chart(device_statistic, {
      type: 'doughnut',
      data: data_device_statistic,
      options: options_device_statistic
    });
  }

  if ($('#employee-statistic').length > 0) {
    var employee_statistic = $('#employee-statistic');
    var data_employee_statistic = {
      datasets: [{
        data: [2, 2, 2, 2, 2, 2],
        labels: ['Administrator', 'Gudang', 'Kasir', 'Koki', 'Pelayan', 'Pelayanan Pelanggan'], //nanti ambil dari db
        backgroundColor: [
          'rgba(0, 0, 0, 0.4)',
          'rgba(210, 84, 0, 0.4)',
          'rgba(39, 173, 96, 0.4)',
          'rgba(231, 76, 60, 0.39)',
          'rgba(127, 141, 142, 0.4)',
          'rgba(41, 128, 185, 0.4)'
        ]
      }],
      labels: [ //tooltip
        'Administrator',
        'Gudang',
        'Kasir',
        'Koki',
        'Pelayan',
        'Pelayanan Pelanggan'
      ]
    };
    var options_employee_statistic = {
      legend: {
        position: 'right'
      }
    };

    var chart_employee_statistic = new Chart(employee_statistic, {
      type: 'pie',
      data: data_employee_statistic,
      options: options_employee_statistic
    });
  }

  /* End of Chart settings */
});
