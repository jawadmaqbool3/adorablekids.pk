@if ($products->count())
    <div class="container">

        <div class="row">
           
            @foreach ($products as $product)
                <div class="col-lg-4 col-md-4 col-sm-6 mix">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="float-right">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@else
    <h5>Unfortunately, there are currently no products available for you. Please check back at a later time.</h5>
@endif
