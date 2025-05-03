// Set font mặc định giống Bootstrap
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#292b2c";

// Biểu đồ Cột (Bar Chart) tiếng Việt
var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: [
            "Tháng 1",
            "Tháng 2",
            "Tháng 3",
            "Tháng 4",
            "Tháng 5",
            "Tháng 6",
        ],
        datasets: [
            {
                label: "Doanh thu (nghìn VNĐ)",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: [4215, 5312, 6251, 7841, 9821, 14984],
            },
        ],
    },
    options: {
        scales: {
            xAxes: [
                {
                    time: {
                        unit: "month",
                    },
                    gridLines: {
                        display: false,
                    },
                    ticks: {
                        maxTicksLimit: 6,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Tháng",
                    },
                },
            ],
            yAxes: [
                {
                    ticks: {
                        min: 0,
                        max: 15000,
                        maxTicksLimit: 5,
                        callback: function (value) {
                            return value + "k";
                        },
                    },
                    gridLines: {
                        display: true,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Doanh thu (nghìn VNĐ)",
                    },
                },
            ],
        },
        legend: {
            display: true,
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, chart) {
                    return "Doanh thu: " + tooltipItem.yLabel + " nghìn VNĐ";
                },
            },
        },
    },
});
