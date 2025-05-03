window.addEventListener("DOMContentLoaded", (event) => {
    const datatablesSimple = document.getElementById("datatablesSimple");
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            autoWidth: false,
            labels: {
                placeholder: "Tìm kiếm...", // placeholder cho ô tìm kiếm
                perPage: "Số dòng mỗi trang",
                noRows: "Không có dữ liệu", // khi không có dòng nào
                info: "Hiển thị {start} đến {end} trong tổng số {rows} mục", // thông tin tổng quan
                noResults: "Không tìm thấy kết quả phù hợp", // khi tìm kiếm không có kết quả
                loading: "Đang tải dữ liệu...", // khi đang tải
            },
        });
    }
});
