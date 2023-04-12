        <tr data-id="{{ $product->uid }}" data-stock="{{ $product->stock }}" title="{{ $product->name }}">
            <td class="shoping__cart__item">
                <img style="width: 100px"
                    src="{{ config('app.media_url') . '/assets/media/products/thumbs/' . $product->thumbnail }}"
                    alt="">
                <h5
                    style="text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden; max-width:300px">
                    {{ $product->name }}</h5>
            </td>
            <td class="shoping__cart__price">
                @if ($product->unit_price)
                    {{ $product->unit_price }} {{ config('app.currency') }}
                @else
                    NA
                @endif
            </td>
            <td class="shoping__cart__quantity">
                <div class="quantity">
                    <div class="pro-qty">
                        <input type="text" value="1">
                    </div>
                </div>
            </td>
            <td class="shoping__cart__total">
                @if ($product->unit_price)
                    {{ $product->unit_price }} {{ config('app.currency') }}
                @else
                    NA
                @endif
            </td>
            <td class="shoping__cart__item__close">
                <form data-ajax="true" action="{{ route('toggle.cart.product', $product->uid) }}" method="post">
                    <a class="select-product 
                    @if (auth()->check() &&
                            auth()->user()->hasCartProduct($product)) text-dark @endif"
                        onclick="$(this).parent('form').submit()"><i class="fa fa-times"></i></a>
                </form>
            </td>
        </tr>
