<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PhatShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Import Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Import CSS tùy chỉnh -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" rel="stylesheet">
    <!-- Import Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>

<body>

    @include('layouts.header')

    @include('layouts.nav')
    <main>
        <button id="scrollToTopBtn" class="btn btn-warning me-auto">↑</button>
        @yield('content')
    </main>
    @include('layouts.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- ElevateZoom-Plus -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>
    <!-- Fancybox (Lightbox) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navDropdownMenu = document.querySelector("#nav-dropdown-menu");
            const navDropdownButton = document.querySelector("#dropdownMenuButton1");
            const isHomePage = window.location.pathname === "/" || window.location.pathname === "/home";
            if (isHomePage) {
                navDropdownMenu.classList.add("show");
                navDropdownButton.classList.remove("dropdown-toggle");
            } else {
                navDropdownMenu.classList.remove("show");
                navDropdownButton.classList.add("dropdown-toggle");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Khởi tạo ElevateZoom với Gallery
            $("#zoom_09").elevateZoom({
                gallery: "gallery_09",
                galleryActiveClass: "active",
                zoomType: "inner",
                cursor: "crosshair"
            });

            // Kích hoạt Fancybox (Lightbox)
            $("#gallery_09 a").fancybox();

            // Khi click vào thumbnail, đổi ảnh zoom
            $("#gallery_09 a").on("click", function(e) {
                e.preventDefault();
                var zoomInstance = $("#zoom_09").data('elevateZoom');

                $("#zoom_09").attr("src", $(this).data("image"))
                    .data("zoom-image", $(this).data("zoom-image"));

                zoomInstance.swaptheimage($(this).data("image"), $(this).data("zoom-image"));
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#carousel-1").owlCarousel({
                loop: false,
                rewind: true,
                margin: 10,
                nav: true,
                dots: false,
                autoplay: false,
                autoplayTimeout: 3000,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            });
            $("#carousel-2").owlCarousel({
                loop: true,
                rewind: true,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });
        });
    </script>
    <script>
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#scrollToTopBtn').fadeIn();
            } else {
                $('#scrollToTopBtn').fadeOut();
            }
        });

        $('#scrollToTopBtn').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 'slow');
            return false;
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
    <script>
        const slider = document.getElementById('range-slider');
        const display = document.getElementById('range-values');

        // Hàm định dạng tiền VNĐ
        function formatCurrency(value) {
            return parseInt(value).toLocaleString('vi-VN') + 'Đ';
        }

        noUiSlider.create(slider, {
            start: [300000, 20000000], // giá trị bắt đầu
            connect: true,
            step: 100000, // bước nhảy
            range: {
                min: 300000,
                max: 50000000
            },
            format: {
                to: value => formatCurrency(value),
                from: value => Number(value.replace(/[^\d]/g, '')) // loại bỏ chữ và dấu chấm phẩy
            }
        });

        slider.noUiSlider.on('update', (values, handle, unencoded) => {
            display.textContent = `${formatCurrency(unencoded[0])} - ${formatCurrency(unencoded[1])}`;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add_to_cart').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');

                    fetch('{{ route('cart') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: 1
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                // TODO: cập nhật số lượng giỏ hàng ở header nếu muốn
                            } else {
                                alert('Thêm vào giỏ hàng thất bại.');
                            }
                        })
                        .catch(error => console.error('Lỗi:', error));
                });
            });
        });
    </script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
</body>

</html>
