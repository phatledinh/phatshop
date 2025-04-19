document.addEventListener("DOMContentLoaded", function () {
    const viewMoreLink = document.querySelector(".one");
    const viewLessLink = document.querySelector(".two");

    // Kiểm tra xem phần tử có tồn tại không trước khi gán sự kiện
    if (viewMoreLink && viewLessLink) {
        // Thêm sự kiện click cho liên kết "Xem thêm"
        viewMoreLink.addEventListener("click", function () {
            viewMoreLink.classList.add("d-none");
            viewLessLink.classList.remove("d-none");

            document
                .querySelector(".content_coll")
                .classList.remove("modal-close-content");
            document
                .querySelector(".content_coll")
                .classList.add("modal-open-content");
        });

        // Thêm sự kiện click cho liên kết "Thu gọn"
        viewLessLink.addEventListener("click", function () {
            viewLessLink.classList.add("d-none");
            viewMoreLink.classList.remove("d-none");

            document
                .querySelector(".content_coll")
                .classList.remove("modal-open-content");
            document
                .querySelector(".content_coll")
                .classList.add("modal-close-content");
        });
    }
});
