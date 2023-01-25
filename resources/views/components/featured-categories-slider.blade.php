<div class="categories__slider owl-carousel">
    @foreach ($categories as $category)
        <div class="col-lg-3">
            <div class="categories__item set-bg"
                data-setbg="{{ config('app.media_url') . '/assets/media/categories/thumbs/' . $category->thumbnail }}">
                <h5><a href="{{route('category.show', $category->slug)}}">{{ $category->name }}</a></h5>
            </div>
        </div>
    @endforeach
</div>