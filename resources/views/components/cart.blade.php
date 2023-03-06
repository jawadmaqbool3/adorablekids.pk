@if ($products->count())
    <section class="shoping-cart spad pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <x-card-product-cart :product="$product" />
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{ route('dashboard') }}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- <div class="container">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-12 mix">
                    <x-card-product-cart :product="$product" />
                </div>
            @endforeach
        </div>
    </div> --}}
@else
    <h5>You don't have any product in wishlist</h5>
@endif
