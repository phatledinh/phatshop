document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".js-remove-item-cart").forEach((button) => {
        button.addEventListener("click", () => {
            const itemId = button.dataset.itemId;
            removeItem(itemId);
        });
    });

    const clearCartButton = document.querySelector(".btn-clearcart");
    if (clearCartButton) {
        clearCartButton.addEventListener("click", clearCart);
        clearCartButton.textContent = "Xóa đã chọn";
    }
});

function removeItem(itemId) {
    if (!itemId) {
        console.error("Invalid itemId:", itemId);
        Swal.fire({
            icon: "error",
            title: "Lỗi",
            text: "Không thể xóa sản phẩm do ID không hợp lệ.",
        });
        return;
    }

    const itemElement = document.getElementById(`cart-item-${itemId}`);
    if (!itemElement) {
        console.error(`Cart item with ID cart-item-${itemId} not found`);
        Swal.fire({
            icon: "error",
            title: "Lỗi",
            text: "Không tìm thấy sản phẩm trong giỏ hàng.",
        });
        return;
    }

    const button = itemElement.querySelector(".js-remove-item-cart");
    if (!button) {
        console.error(
            `Button with class .js-remove-item-cart not found for item ${itemId}`
        );
        Swal.fire({
            icon: "error",
            title: "Lỗi",
            text: "Không tìm thấy nút xóa sản phẩm.",
        });
        return;
    }

    Swal.fire({
        title: "Xác nhận xóa",
        text: "Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
    }).then((result) => {
        if (result.isConfirmed) {
            button.disabled = true;
            button.textContent = "Đang xóa...";

            fetch(`/cart/remove/${itemId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Failed to remove item");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        itemElement.remove();
                        updateCartDisplay(data);

                        // Làm mới danh sách checkbox và selectedItems
                        const checkboxes =
                            document.querySelectorAll(".item-checkbox");
                        checkboxes.forEach((checkbox) => {
                            if (checkbox.value === itemId) {
                                checkbox.checked = false; // Bỏ chọn checkbox của sản phẩm đã xóa
                            }
                        });

                        // Log để kiểm tra
                        const selectedItems = Array.from(
                            document.querySelectorAll(".item-checkbox:checked")
                        ).map((cb) => cb.value);
                        console.log(
                            "Updated selectedItems after remove:",
                            selectedItems
                        );

                        Swal.fire({
                            icon: "success",
                            title: "Thành công",
                            text:
                                data.message ||
                                "Sản phẩm đã được xóa khỏi giỏ hàng!",
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi",
                            text:
                                data.message ||
                                "Có lỗi xảy ra khi xóa sản phẩm!",
                        });
                    }
                    button.disabled = false;
                    button.textContent = "Xóa";
                })
                .catch((error) => {
                    console.error("Error:", error);
                    button.disabled = false;
                    button.textContent = "Xóa";
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi",
                        text: "Có lỗi xảy ra khi xóa sản phẩm!",
                    });
                });
        }
    });
}

function clearCart() {
    const selectedCheckboxes = document.querySelectorAll(
        ".item-checkbox:checked"
    );
    const selectedItemIds = Array.from(selectedCheckboxes).map(
        (checkbox) => checkbox.value
    );

    if (selectedItemIds.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "Thông báo",
            text: "Vui lòng chọn ít nhất một sản phẩm để xóa.",
        });
        return;
    }

    const button = document.querySelector(".btn-clearcart");
    if (!button) {
        console.error("Clear cart button with class .btn-clearcart not found");
        Swal.fire({
            icon: "error",
            title: "Lỗi",
            text: "Không tìm thấy nút xóa giỏ hàng.",
        });
        return;
    }

    // Hiển thị thông báo xác nhận xóa
    Swal.fire({
        title: "Xác nhận xóa",
        text: `Bạn có chắc muốn xóa ${selectedItemIds.length} sản phẩm đã chọn khỏi giỏ hàng?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
    }).then((result) => {
        if (result.isConfirmed) {
            button.disabled = true;
            button.textContent = "Đang xóa...";

            fetch("/cart/remove-selected", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ itemIds: selectedItemIds }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Failed to remove selected items");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        selectedItemIds.forEach((itemId) => {
                            const itemElement = document.getElementById(
                                `cart-item-${itemId}`
                            );
                            if (itemElement) {
                                itemElement.remove();
                            }
                        });
                        updateCartDisplay(data);
                        Swal.fire({
                            icon: "success",
                            title: "Thành công",
                            text:
                                data.message ||
                                "Đã xóa các sản phẩm được chọn.",
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi",
                            text:
                                data.message ||
                                "Có lỗi xảy ra khi xóa các sản phẩm!",
                        });
                    }
                    button.disabled = false;
                    button.textContent = "Xóa đã chọn";
                })
                .catch((error) => {
                    console.error("Error:", error);
                    button.disabled = false;
                    button.textContent = "Xóa đã chọn";
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi",
                        text: "Có lỗi xảy ra khi xóa các sản phẩm!",
                    });
                });
        }
    });
}

function updateQuantity(itemId, change) {
    const input = document.getElementById("qty-" + itemId);
    let quantity = parseInt(input.value) + change;
    if (quantity < 1) quantity = 1;
    updateCartItem(itemId, quantity);
}

function manualQuantity(itemId) {
    const input = document.getElementById("qty-" + itemId);
    let quantity = parseInt(input.value);
    if (isNaN(quantity) || quantity < 1) {
        quantity = 1;
        input.value = quantity;
    }
    updateCartItem(itemId, quantity);
}

function updateCartItem(itemId, quantity) {
    fetch("/cart/update/" + itemId, {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ quantity: quantity }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                if (data.deleted) {
                    const itemElement = document.getElementById(
                        "cart-item-" + itemId
                    );
                    if (itemElement) {
                        itemElement.remove();
                    }
                    Swal.fire({
                        icon: "success",
                        title: "Thành công",
                        text:
                            data.message ||
                            "Sản phẩm đã được xóa vì số lượng bằng 0!",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                } else {
                    const input = document.getElementById("qty-" + itemId);
                    input.value = data.quantity;
                    const checkbox = document.getElementById("item-" + itemId);
                    if (checkbox && data.price) {
                        checkbox.setAttribute(
                            "data-price",
                            data.price * data.quantity
                        );
                    }
                    Swal.fire({
                        icon: "success",
                        title: "Thành công",
                        text:
                            data.message ||
                            "Số lượng sản phẩm đã được cập nhật!",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                }
                updateCartDisplay(data);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Lỗi",
                    text:
                        data.message || "Có lỗi xảy ra khi cập nhật số lượng!",
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "Lỗi",
                text: "Có lỗi xảy ra khi cập nhật số lượng!",
            });
        });
}

function updateCartDisplay(data) {
    const totalPriceElement = document.getElementById("totalPrice");
    const selectedCountElement = document.getElementById("selectedCount");
    const cartInfo = document.querySelector(".js-cart-info");
    const emptyCartMessage = document.querySelector(".js-empty-cart-message");
    const cartCountElement = document.querySelector(".js-cart-count");

    if (totalPriceElement) {
        totalPriceElement.textContent =
            (data.total || 0).toLocaleString("vi-VN") + "₫";
    }

    if (selectedCountElement) {
        selectedCountElement.textContent = data.count || 0;
    }

    if (cartCountElement) {
        cartCountElement.textContent = data.count || 0;
    } else {
        console.warn("Cart count element (.js-cart-count) not found in DOM");
        document.dispatchEvent(
            new CustomEvent("updateCartCount", {
                detail: { count: data.count || 0 },
            })
        );
    }

    if (data.count === 0) {
        if (cartInfo) cartInfo.style.display = "none";
        if (emptyCartMessage) emptyCartMessage.style.display = "block";
    } else {
        if (cartInfo) cartInfo.style.display = "flex";
        if (emptyCartMessage) emptyCartMessage.style.display = "none";
    }

    document.dispatchEvent(new Event("updateSummary"));
    // Làm mới danh sách checkbox nếu cần
    const selectedCheckboxes = document.querySelectorAll(
        ".item-checkbox:checked"
    );
    if (selectedCheckboxes.length === 0 && data.count > 0) {
        document.getElementById("selectAll").checked = false;
    }
}
