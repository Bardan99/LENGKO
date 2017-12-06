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

  }//endif

  if ($('#employee-statistic').length > 0) {
    $.ajax({
      type: "GET",
      url: "/dashboard/retrieve/employee/",
      cache: false,
      success: function(result) {
        var data = [];
        var label = [];
        for (i = 0; i < result.length; i++) {
          data[i] = result[i].res;
          label[i] = result[i].title;
        }

        var employee_statistic = $('#employee-statistic');
        var data_employee_statistic = {
          datasets: [{
            data: data,
            labels: label,
            backgroundColor: [
              'rgba(0, 0, 0, 0.4)',
              'rgba(210, 84, 0, 0.4)',
              'rgba(39, 173, 96, 0.4)',
              'rgba(231, 76, 60, 0.4)',
              'rgba(127, 141, 142, 0.4)',
              'rgba(41, 128, 185, 0.4)'
            ]
          }],
          labels: label
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
    });

  }


  if ($('#report-transaction').length > 0) {
    $.ajax({
      type: "GET",
      url: "/dashboard/retrieve/income/",
      cache: false,
      success: function(result) {
        var data = [];
        var label = [];
        for (i = 0; i < result.length; i++) {
          data[i] = result[i].pendapatan;
          label[i] = result[i].tanggal;
        }
        var report_transaction = $('#report-transaction');
        var data_transaction = {
          datasets: [{
            label: 'Statistik Pendapatan (Rp)',
            data: data,
            backgroundColor: 'rgba(44, 62, 80, 0.6)',
          }],
          labels: label
        };
        var options_transaction = {};
        var chart_transaction = new Chart(report_transaction, {
          type: 'line',
          data: data_transaction,
          options: options_transaction
        });

      }
    });
  }//ENDIF

  if ($('#customer-review').length > 0) {
    $.ajax({
      type: "GET",
      url: "/dashboard/retrieve/review/",
      cache: false,
      success: function(result) {

        var point = {'min' : [], 'max' : [], 'avg' : []};
        var labels = ['Tidak Tersedia'];
        if (result.min.length > 0 && result.max.length > 0 && result.avg.length > 0) {
          for (i = 0; i < result.labels.length; i++) {
            labels[i] = result.labels[i].judul_kuisioner;
            if (labels[i] == result.min[i].judul_kuisioner) {
              if (result.min[i].status_kuisioner == 1) {
                point.min[i] = Number(result.min[i].poin_kuisioner);
              }
              else {
                point.min[i] = 0;
              }
            }
            else {
              point.min[i] = 0;
            }

            if (labels[i] == result.max[i].judul_kuisioner) {
              if (result.max[i].status_kuisioner == 1) {
                point.max[i] = Number(result.max[i].poin_kuisioner);
              }
              else {
                point.max[i] = 0;
              }
            }
            else {
              point.max[i] = 0;
            }

            if (labels[i] == result.avg[i].judul_kuisioner) {
              if (result.min[i].status_kuisioner == 1) {
                point.avg[i] = Number(result.avg[i].poin_kuisioner);
              }
              else {
                point.avg[i] = 0;
              }
            }
            else {
              point.avg[i] = 0;
            }
          }//endfor
        }

        var customer_review = $('#customer-review');
        var data_customer_review = {
          labels: labels,
          datasets: [
              {
                label: "Minimum",
                backgroundColor: "rgba(255,99,132,0.2)",
                borderColor: "rgba(255,99,132,1)",
                pointBackgroundColor: "rgba(255,99,132,1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(255,99,132,1)",
                data: point.min
              },
              {
                label: "Maksimum",
                backgroundColor: "rgba(21, 133, 36, 0.2)",
                borderColor: "rgba(65, 204, 104, 1)",
                pointBackgroundColor: "rgba(49, 200, 78, 1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(68, 215, 109, 1)",
                data: point.max
              },
              {
                label: "Rata-Rata",
                backgroundColor: "rgba(221, 159, 21, 0.2)",
                borderColor: "rgba(214, 154, 39, 1)",
                pointBackgroundColor: "rgba(205, 139, 62, 1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(204, 172, 116, 1)",
                data: point.avg
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
    });

  }//endif

  /* End of Chart settings */
});
