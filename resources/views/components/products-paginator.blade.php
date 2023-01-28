
<div class="container">
    <div class="row">
        @foreach ($products as $product)
            <x-product-card :product="$product" />
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
