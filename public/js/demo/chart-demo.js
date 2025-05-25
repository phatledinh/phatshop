document.addEventListener("DOMContentLoaded", function () {
    // Biểu đồ Doanh thu theo Tháng (Biểu đồ Cột)
    const ctxBar = document.getElementById("myBarChart").getContext("2d");
    const revenueData = window.revenueData; // Sử dụng biến window.revenueData
    new Chart(ctxBar, {
        type: "bar",
        data: {
            labels: [
                "Th1",
                "Th2",
                "Th3",
                "Th4",
                "Th5",
                "Th6",
                "Th7",
                "Th8",
                "Th9",
                "Th10",
                "Th11",
                "Th12",
            ],
            datasets: [
                {
                    label: "Doanh thu (VND)",
                    data: revenueData, // Dữ liệu doanh thu từ window.revenueData
                    backgroundColor: "rgba(75, 192, 192, 0.6)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Doanh thu (VND)",
                    },
                    ticks: {
                        callback: function (value) {
                            return value.toLocaleString("vi-VN") + " ₫";
                        },
                    },
                },
                x: {
                    title: {
                        display: true,
                        text: "Tháng",
                    },
                },
            },
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Doanh thu theo Tháng (2024)",
                },
            },
        },
    });

    // Biểu đồ Top 10 Khách hàng Tiềm năng (Biểu đồ Cột Ngang)
    const ctxTopCustomers = document
        .getElementById("topCustomersChart")
        .getContext("2d");
    const customerData = window.topCustomers; // Sử dụng biến window.topCustomers
    new Chart(ctxTopCustomers, {
        type: "bar",
        data: {
            labels: customerData.map((customer) => customer.name), // Tên khách hàng
            datasets: [
                {
                    label: "Tổng mua hàng (VND)",
                    data: customerData.map(
                        (customer) => customer.total_purchase
                    ), // Tổng giá trị mua hàng
                    backgroundColor: "rgba(255, 159, 64, 0.6)",
                    borderColor: "rgba(255, 159, 64, 1)",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            indexAxis: "y", // Biểu đồ cột ngang
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Tổng mua hàng (VND)",
                    },
                    ticks: {
                        callback: function (value) {
                            return value.toLocaleString("vi-VN") + " ₫";
                        },
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: "Khách hàng",
                    },
                },
            },
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Top 10 Khách hàng Tiềm năng (Tháng này)",
                },
            },
        },
    });
});
