<div class="categories__slider owl-carousel">
    @foreach ($categories as $category)
        <div class="col-lg-3">
            <x-category-card :category="$category" />
        </div>
    @endforeach
</div>
