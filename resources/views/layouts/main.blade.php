<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhatShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Import Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Import CSS tùy chỉnh -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Import Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Import Slick -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>

<body>

    @include('layouts.header')

    @include('layouts.nav')
    <main>
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
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.home-slide').slick({
                dots: false,
                initialSlide: 0,
                autoplaySpeed: 3000,
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                arrows: true,
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownMenu = document.querySelector(".dropdown-menu");
            const dropdownButton = document.querySelector(".dropdown button");

            if (window.location.pathname !== "/" && window.location.pathname !== "/home") {
                dropdownMenu.classList.remove("show"); // Ẩn danh mục
                dropdownButton.classList.add("dropdown-toggle")
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
        });
    </script>
    <script src="{{ asset('js/index.js') }}"></script>

</body>

</html>
