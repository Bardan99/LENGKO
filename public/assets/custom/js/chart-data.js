$(document).ready(function() {
  /* Chart settings */
  if ($('#device-statistic').length > 0) {

    $.ajax({
      type: "GET",
      url: "/dashboard/retrieve/device/",
      cache: false,
      success: function(result) {
        var data = [];
        var label = [];
        var color = [];
        for (i = 0; i < result.length; i++) {
          data[i] = result[i].res;
          if (result[i].stat === 0) {
            label[i] = 'Tidak Tersedia';
            color[i] = 'rgba(231, 76, 60, 0.4)';
          }
          else {
            label[i] = 'Tersedia';
            color[i] = 'rgba(39, 173, 96, 0.4)';
          }
        }
        var device_statistic = $('#device-statistic');
        var data_device_statistic = {
          datasets: [{
            data: data,
            labels: label,
            backgroundColor: color
          }],

          labels: label
        };
        var options_device_statistic = {};
        var chart_device_statistic = new Chart(device_statistic, {
          type: 'doughnut',
          data: data_device_statistic,
          options: options_device_statistic
        });
      }
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
          'rgba(231, 76, 60, 0.4)',
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

  if ($('#report-income-yearly').length > 0) {
    var report_income_yearly = $('#report-income-yearly');
    var data_report_income_yearly = {
      datasets: [{
        label: 'Statistik Pendapatan Tahun 2017',
        data: [
          135000000, 164832000, 128555000, 148555000,
          135000000, 148555000, 135000000, 135624000,
          148555000, 128555000, 100352000, 0
        ],
        backgroundColor: 'rgba(44, 62, 80, 0.6)',
      }],
      labels: [
        'Jan', 'Feb', 'Mar', 'Apr',
        'Mei', 'Jun', 'Jul', 'Agust',
        'Sept', 'Okt', 'Nov', 'Des'
      ]
    };
    var options_report_income_yearly = {};
    var chart_report_income_yearly = new Chart(report_income_yearly, {
      type: 'bar',
      data: data_report_income_yearly,
      options: options_report_income_yearly
    });
  }


  if ($('#report-transaction').length > 0) {
    var report_transaction = $('#report-transaction');
    var data_transaction = {
      datasets: [{
        label: 'Statistik Transaksi',
        data: [
          4, 3, 4, 2,
          5, 6, 3, 4,
          1, 5, 3, 0
        ],
        backgroundColor: 'rgba(39, 173, 96, 0.6)',
      }],
      labels: [
        'Jan', 'Feb', 'Mar', 'Apr',
        'Mei', 'Jun', 'Jul', 'Agust',
        'Sept', 'Okt', 'Nov', 'Des'
      ]
    };
    var options_transaction = {};
    var chart_transaction = new Chart(report_transaction, {
      type: 'line',
      data: data_transaction,
      options: options_transaction
    });
  }

  if ($('#customer-review').length > 0) {
    var customer_review = $('#customer-review');
    var data_customer_review = {
      labels: ["Restoran", "Pegawai", "Pelayanan", "Fasilitas", "Biaya"],
      datasets: [
          {
            label: "Minimum",
            backgroundColor: "rgba(255,99,132,0.2)",
            borderColor: "rgba(255,99,132,1)",
            pointBackgroundColor: "rgba(255,99,132,1)",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "rgba(255,99,132,1)",
            data: [3.5, 4.2, 3.3, 4.2, 3]
          },
          {
            label: "Maksimum",
            backgroundColor: "rgba(21, 133, 36, 0.2)",
            borderColor: "rgba(65, 204, 104, 1)",
            pointBackgroundColor: "rgba(49, 200, 78, 1)",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "rgba(68, 215, 109, 1)",
            data: [4.5, 4.7, 4.3, 4.6, 5]
          },
          {
            label: "Rata-Rata",
            backgroundColor: "rgba(221, 159, 21, 0.2)",
            borderColor: "rgba(214, 154, 39, 1)",
            pointBackgroundColor: "rgba(205, 139, 62, 1)",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "rgba(204, 172, 116, 1)",
            data: [4.2, 4.3, 4.1, 4, 4.6]
          }
      ]
    };
    var options_customer_review = {
      scale: {
          reverse: false,
          ticks: {
              beginAtZero: false,
              showLabelBackdrop: false,
              backdropColor: "rgba(255, 255, 255, 0)"
          }
      },
      legend: {
        position: 'left'
      }
    };
    var chart_customer_review = new Chart(customer_review, {
      type: 'radar',
      data: data_customer_review,
      options: options_customer_review
    });
  }

  /* End of Chart settings */
});
