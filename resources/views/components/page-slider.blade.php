<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<style>
    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    .swiper {
        width: 100%;
        height: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
    }

    .mySwiper2 {
        height: 80%;
        width: 100%;
    }

    .mySwiper {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .mySwiper .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
    <div class="swiper-wrapper">
        @foreach ($images as $key => $image)
            <div class="swiper-slide">
                <img alt="{{ $prefix . ' ' . $key }}"
                    src="{{ config('app.media_url') . '/assets/media/products/images/' . $image }}" />
            </div>
        @endforeach
    </div>
    @if (sizeof($images) > 1)
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    @endif
</div>
@if (sizeof($images) > 1)
    <div thumbsSlider="" class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($images as $key => $image)
                <div class="swiper-slide">
                    <img alt="{{ $prefix . ' ' . $key }}"
                        src="{{ config('app.media_url') . '/assets/media/products/images/' . $image }}" />
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
</script>
