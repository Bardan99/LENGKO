$(document).ready(function() {
  var element_radar_summary = document.getElementById("radar-summary");

  if (element_radar_summary) {
    var data = {
          labels: ["System Experience", "Task Experience", "Frequency of Use", "Task Importance", "System Use"],
          datasets: [
              {
                label: "Minimum",
                backgroundColor: "rgba(255,99,132,0.2)",
                borderColor: "rgba(255,99,132,1)",
                pointBackgroundColor: "rgba(255,99,132,1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(255,99,132,1)",
                data: [0, 0, 0, 1, 5]
              },
              {
                label: "Maksimum",
                backgroundColor: "rgba(21, 133, 36, 0.2)",
                borderColor: "rgba(65, 204, 104, 1)",
                pointBackgroundColor: "rgba(49, 200, 78, 1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(68, 215, 109, 1)",
                data: [3, 3, 3, 5, 5]
              },
              {
                label: "Rata-Rata",
                backgroundColor: "rgba(221, 159, 21, 0.2)",
                borderColor: "rgba(214, 154, 39, 1)",
                pointBackgroundColor: "rgba(205, 139, 62, 1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(204, 172, 116, 1)",
                data: [1.5, 1.3, 2.1, 3, 5]
              }
          ]
  	};

    var options = {
        scale: {
            reverse: false,
            ticks: {
                beginAtZero: false,
                showLabelBackdrop: false,
                backdropColor: "rgba(255, 255, 255, 0)"
            }
        }
    };

  	var radar_summary = new Chart(element_radar_summary, {
          type: 'radar',
          data: data,
          options: options
  	});
  }
});
