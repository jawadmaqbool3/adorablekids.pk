<div class="col-lg-4 col-md-4 col-sm-6 mix" title="{{ $product->name }}">
    <div class="featured__item card shadow p-3">
        <div class=" featured__item__pic set-bg"
            data-setbg="{{ config('app.media_url') . '/assets/media/products/thumbs/' . $product->thumbnail }}">
            <ul class="featured__item__pic__hover">
                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
            <div class="col-5 p-0">
                @if ($product->stock == 0)
                    <div class="product-status 
            bg-danger w-40 p-1 text-white mt-2 fs-2 rounded">
                        <small>Out of Stock</small>
                    </div>
                @elseif($product->stock < 5)
                    <div class="product-status 
                bg-warning w-40 p-1 text-white mt-2 fs-2 rounded">
                        <small>Low Stock</small>
                    </div>
                @endif
            </div>
        </div>
        <div class="featured__item__text">

            <h6  style="overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;" class="p-0"><a 
                    href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
            <h5>
                @if ($product->unit_price)
                    {{ $product->unit_price }} {{ config('app.currency') }}
                @else
                    NA
                @endif
            </h5>
        </div>
    </div>
</div>