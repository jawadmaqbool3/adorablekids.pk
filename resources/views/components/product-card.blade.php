<div class="col-lg-3 col-md-4 col-sm-6 mix">
    <div class="featured__item">
        <div class="featured__item__pic set-bg"
            data-setbg="{{ config('app.media_url') . '/assets/media/products/thumbs/' . $product->thumbnail }}">
            <ul class="featured__item__pic__hover">
                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
        </div>
        <div class="featured__item__text">
            <h6><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
            <h5>{{ $product->unit_price }} {{ config('app.currency') }}</h5>
        </div>
    </div>
</div>