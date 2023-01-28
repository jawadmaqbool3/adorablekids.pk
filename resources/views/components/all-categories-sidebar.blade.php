<div class="hero__categories">
    <div class="hero__categories__all">
        <i class="fa fa-bars"></i>
        <span>All Categories</span>
    </div>
    <ul>
        @foreach ($categories as $category)
            <li><a href="{{route('category.show', $category->slug)}}">{{ ucwords(strtolower($category->name)) }}</a></li>
        @endforeach
    </ul>
</div>