@foreach ($products as $product)
    <div class="col-lg-3 col-md-4 col-sm-6 mix">
        <x-product-card :product="$product" />
    </div>
@endforeach
