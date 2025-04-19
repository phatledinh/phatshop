function removeItem(itemId) {
    if (confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?")) {
        fetch("/cart/remove/" + itemId, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    document
                        .getElementById("cart-item-" + itemId)
                        .parentElement.remove();
                    updateTotal(data.total);
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Có lỗi xảy ra khi xóa sản phẩm!");
            });
    }
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
                    document
                        .getElementById("cart-item-" + itemId)
                        .parentElement.remove();
                } else {
                    document.getElementById("qty-" + itemId).value =
                        data.quantity;
                }
                updateTotal(data.total);
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Có lỗi xảy ra khi cập nhật số lượng!");
        });
}

function clearCart() {
    if (confirm("Bạn có chắc muốn xóa toàn bộ giỏ hàng?")) {
        fetch("/cart/clear", {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    document.querySelector(".cart-info").innerHTML = "";
                    updateTotal(data.total);
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Có lỗi xảy ra khi xóa giỏ hàng!");
            });
    }
}

function updateTotal(total) {
    document.querySelector(".cart__summary_total").textContent =
        new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(total);
}
