<div class="card">
    <div class="categories__item set-bg"
        data-setbg="{{ config('app.media_url') . '/assets/media/categories/thumbs/' . $category->thumbnail }}">
        <h5><a
                href="{{ route('category.show', $category->slug) }}">{{ ucwords(strtolower($category->name)) }}</a>
        </h5>
    </div>
</div>