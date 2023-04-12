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
                                    {{-- <li>Subtotal <span>$454.98</span></li> --}}
                                    <li>Total <span id="cart_total">0 {{ config('app.currency') }}</span></li>
                                </ul>
                                <a href="#" id="btn_checkout" class="primary-btn">PROCEED TO CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
                <form style="display: none" action="{{ route('orders.confirm') }}" id="confirmation_form" method="post">
                </form>
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
                    <tr data-stock="${item.stock}" data-id="${item.uid}" data-price="${item.unit_price}" data-name="${item.name}" title="${item.name}">
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
                                                <input type="text" value="${item.stock?1:0}">
                                            <span class="inc qtybtn">+</span></div>
                                        </div>
            </td>
            <td data-total="${item.stock?item.unit_price:0}" class="shoping__cart__total">
                ${item.stock?item.unit_price:0}  {{ config('app.currency') }}
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
                    calculateTotal();

                }
            });

        }

        // document.addEventListener("product_added_to_wishlist", function() {
        //     getCartItems();
        // });
        // document.addEventListener("product_removed_from_wishlist", function() {
        //     getCartItems();
        // });
        document.addEventListener("product_added_to_cart", function() {
            getCartItems();
        });
        document.addEventListener("product_removed_from_cart", function() {
            getCartItems();
        });

        function calculatePrice(selector) {
            let quantity = Number(selector.find('.quantity input').val());
            let price = Number(selector.data('price'));
            let stock = Number(selector.data('stock'));

            if (quantity > stock) {
                selector.find('.quantity input').val(stock);
                toastr.warning(
                    "Stock ended",
                    "warning", {
                        timeOut: 5000,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0
                    }
                );
            } else {
                selector.find('.shoping__cart__total').text((quantity * price) + " {{ config('app.currency') }}").data(
                    'total', (quantity * price));
            }
        }

        function calculateTotal() {
            let total = 0;
            $('.shoping__cart__total').each(function() {
                total += $(this).data('total') ? $(this).data('total') : 0;
            })
            $('#cart_total').text(total + "{{ config('app.currency') }}");
        }

        $(document).on('change', '.shoping__cart__quantity .quantity input', function() {
            calculatePrice($(this).parents('tr'));
            calculateTotal();
        });

        $(document).on("click", "#btn_checkout", function() {
            let products = [];
            let quantities = [];
            $("#list_wrapper tr").each(function() {
                if ($(this).data("stock") > 0) {
                    products.push($(this).data("id"));
                    quantities.push($(this).find(".pro-qty input").val());
                }
            });
            let order = {
                products: products,
                quantities: quantities
            }
            $("#confirmation_form").html(
                `@csrf<textarea name="order" >${JSON.stringify(order)}</textarea>`).submit();

        });
    </script>
@endsection
