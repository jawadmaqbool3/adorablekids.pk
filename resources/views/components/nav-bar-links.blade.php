<ul>
    <li @if (Route::currentRouteName() == 'dashboard') class="active" @endif><a href="{{ route('dashboard') }}">Home</a></li>
    <li @if (Route::currentRouteName() == 'products.index') class="active" @endif><a href="{{ route('products.index') }}">Products</a></li>
    {{-- <li><a href="#">Pages</a>
        <ul class="header__menu__dropdown">
            <li><a href="./shop-details.html">Shop Details</a></li>
            <li><a href="./shoping-cart.html">Shoping Cart</a></li>
            <li><a href="./checkout.html">Check Out</a></li>
            <li><a href="./blog-details.html">Blog Details</a></li>
        </ul>
    </li> --}}
    <li @if (Route::currentRouteName() == 'categories.index') class="active" @endif><a href="{{ route('categories.index') }}">Categories</a>
    </li>
    <li @if (Route::currentRouteName() == 'contact.us') class="active" @endif><a href="#">Contact</a></li>
</ul>
