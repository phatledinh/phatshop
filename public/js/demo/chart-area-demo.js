// Cài đặt font mặc định giống Bootstrap
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#292b2c";

// Biểu đồ dạng đường (Area Chart)
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "1 Tháng 3",
            "2 Tháng 3",
            "3 Tháng 3",
            "4 Tháng 3",
            "5 Tháng 3",
            "6 Tháng 3",
            "7 Tháng 3",
            "8 Tháng 3",
            "9 Tháng 3",
            "10 Tháng 3",
            "11 Tháng 3",
            "12 Tháng 3",
            "13 Tháng 3",
        ],
        datasets: [
            {
                label: "Lượt truy cập",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: [
                    10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259,
                    25849, 24159, 32651, 31984, 38451,
                ],
            },
        ],
    },
    options: {
        scales: {
            xAxes: [
                {
                    gridLines: {
                        display: false,
                    },
                    ticks: {
                        maxTicksLimit: 7,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Ngày",
                    },
                },
            ],
            yAxes: [
                {
                    ticks: {
                        min: 0,
                        max: 40000,
                        maxTicksLimit: 5,
                        callback: function (value) {
                            return value.toLocaleString("vi-VN"); // thêm dấu chấm ngăn cách nghìn
                        },
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, .125)",
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Lượt truy cập",
                    },
                },
            ],
        },
        legend: {
            display: true,
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem) {
                    return (
                        "Lượt truy cập: " +
                        tooltipItem.yLabel.toLocaleString("vi-VN")
                    );
                },
            },
        },
    },
});
