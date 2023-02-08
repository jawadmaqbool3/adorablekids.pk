<div class="hero__categories">
    <div class="hero__categories__all">
        <i class="fa fa-bars"></i>
        <span>All Categories</span>
    </div>
    <ul>
        @foreach ($categories as $key => $category)
            @if ($key >= 5)
            @break
        @endif
        <li><a href="{{ route('category.show', $category->slug) }}">{{ ucwords(strtolower($category->name)) }}</a>
        </li>
    @endforeach
    @if ($categories->count() >= 5)
        <li><a href="{{ route('categories.index') }}">See More</a>
        </li>
    @endif
</ul>
</div>
