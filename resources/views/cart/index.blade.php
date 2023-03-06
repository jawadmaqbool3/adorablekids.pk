@extends('layout.basic')
@section('page_title', 'Cart')
@section('meta_description', 'Thousands of Products for your adorable kids are available here')
@section('meta_keywords', 'Products, Adorables, Kids, Diapers, Blankets, Toys and Much More')
@section('content')
    <section class="hero">
        <div class="container">

            <div class="row">
                <x-bread-crumbs :links="[
                    'Home' => route('dashboard'),
                    'Wishlist' => route('wishlist.index'),
                ]" />

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="">My Cart</h2>
                            <div class="border-bottom mb-5  mt-3 pb-0">
                                All your favorites are here.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <x-cart />
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="shoping__checkout">
                                <h5>Cart Total</h5>
                                <ul>
                                    <li>Subtotal <span>$454.98</span></li>
                                    <li>Total <span>$454.98</span></li>
                                </ul>
                                <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jsOutSide')
    <script>
        getCartItems();

        function getCartItems() {
            $.ajax({
                url: "{{ route('cart.items') }}",
                type: "GET",
                success: function(response) {
                    $('#list_wrapper').empty();
                    for (let index = 0; index < response.cartItems.length; index++) {
                        const item = response.cartItems[index];
                        $('#list_wrapper').append(`
                    <tr title="${item.name}">
            <td class="shoping__cart__item">
                <img style="width: 100px"
                    src="{{ config('app.media_url') . '/assets/media/products/thumbs/' }}${item.thumbnail}"
                    alt="">
                <h5
                    style="text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden; max-width:300px">
                ${item.name}
                    </h5>
            </td>
            <td class="shoping__cart__price">
                ${item.unit_price} {{ config('app.currency') }}
            </td>
            <td class="shoping__cart__quantity">
                <div class="quantity">
                                            <div class="pro-qty"><span class="dec qtybtn">-</span>
                                                <input type="text" value="1">
                                            <span class="inc qtybtn">+</span></div>
                                        </div>
            </td>
            <td class="shoping__cart__total">
                ${item.unit_price}  {{ config('app.currency') }}
            </td>
            <td class="shoping__cart__item__close">
                <form data-ajax="true" action="{{ url('cart') }}/${item.uid}" method="post">
                    <a class="select-product"
                        onclick="$(this).parent('form').submit()"><i class="fa fa-times"></i></a>
                </form>
            </td>
        </tr>
                    `);
                    }

                }
            });
        }

        document.addEventListener("product_added_to_wishlist", function() {
            getCartItems();
        });
        document.addEventListener("product_removed_from_wishlist", function() {
            getCartItems();
        });
        document.addEventListener("product_added_to_cart", function() {
            getCartItems();
        });
        document.addEventListener("product_removed_from_cart", function() {
            getCartItems();
        });
    </script>
@endsection
