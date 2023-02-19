    <div class="featured__item card  p-3" title="{{ $product->name }}">
        <div class=" featured__item__pic set-bg"
            data-setbg="{{ config('app.media_url') . '/assets/media/products/thumbs/' . $product->thumbnail }}">
            <ul class="featured__item__pic__hover">
                <li>
                    <form data-ajax="true" action="{{ route('toggle.wishlist.product', $product->uid) }}" method="post">
                        <a class="select-product 
                        @if (auth()->check() &&
                                auth()->user()->hasWishListProduct($product)) bg-primary text-white @endif"
                            onclick="$(this).parent('form').submit()"><i class="fa fa-heart"></i></a>
                    </form>
                </li>
                <li><a class="select-product"><i class="fa fa-retweet"></i></a></li>
                <li>
                    <form data-ajax="true" action="{{ route('toggle.cart.product', $product->uid) }}" method="post">
                        <a class="select-product 
                        @if (auth()->check() &&
                                auth()->user()->hasCartProduct($product)) bg-primary text-white @endif"
                            onclick="$(this).parent('form').submit()"><i class="fa fa-shopping-cart"></i></a>
                    </form>
                </li>
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

            <h6 style="overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;"
                class="p-0"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
            <h5>
                @if ($product->unit_price)
                    {{ $product->unit_price }} {{ config('app.currency') }}
                @else
                    NA
                @endif
            </h5>
        </div>
    </div>
