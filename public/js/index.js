// Lấy các phần tử liên kết
const viewMoreLink = document.querySelector(".one");
const viewLessLink = document.querySelector(".two");

// Thêm sự kiện click cho liên kết "Xem thêm"
viewMoreLink.addEventListener("click", function () {
    // Ẩn "Xem thêm" và hiển thị "Thu gọn"
    viewMoreLink.classList.add("d-none");
    viewLessLink.classList.remove("d-none");

    // Thực hiện hành động mở rộng nội dung ở đây (nếu cần)
    document
        .querySelector(".content_coll")
        .classList.remove("modal-close-content");
    document.querySelector(".content_coll").classList.add("modal-open-content");
});

// Thêm sự kiện click cho liên kết "Thu gọn"
viewLessLink.addEventListener("click", function () {
    // Ẩn "Thu gọn" và hiển thị "Xem thêm"
    viewLessLink.classList.add("d-none");
    viewMoreLink.classList.remove("d-none");

    // Thực hiện hành động thu gọn nội dung ở đây (nếu cần)
    document
        .querySelector(".content_coll")
        .classList.remove("modal-open-content");
    document
        .querySelector(".content_coll")
        .classList.add("modal-close-content");
});
