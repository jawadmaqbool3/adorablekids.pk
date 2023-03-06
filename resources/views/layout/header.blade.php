<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
    </div>
    <div class="humberger__menu__cart ">
        <ul>
            @if (auth()->check())
                <li><a href="{{ route('wishlist.index') }}"><i class="fa fa-heart"></i>
                        <span>{{ auth()->user()->wishlistProducts->count() }}</span></a></li>
                <li><a href="{{ route('cart.index') }}"><i class="fa fa-shopping-bag"></i>
                        <span>{{ auth()->user()->cartProducts->count() }}</span></a></li>
                <li>
                    <form data-ajax="true" action="{{ route('logout') }}" method="post"><a title="sigin in"
                            onclick="$(this).parent('form').submit()"><i class="fa fa-sign-out"></i>
                            <span></span></a>
                    </form>
                </li>
            @else
                <li>
                    <a title="sigin in" href="{{ route('login.form') }}"><i class="fa fa-sign-in"></i> <span></span></a>
                </li>
            @endif
        </ul>
    </div>

    <nav class="humberger__menu__nav mobile-menu">
        <x-nav-bar-links />
    </nav>
    <div id="mobile-menu-wrap"></div>

</div>

<header class="header mb-4">

    <div class="container">
        <div class="row">
            <div class="col-lg-1">
                <div class="header__logo">
                    <a  href="{{ route('dashboard') }}"><img
                        class="rounded"     src="{{ config('app.media_url') . '/assets/media/small/logo/' }}/@setting(logo)"
                            alt=""></a>
                </div>
            </div>
            <div class="col-lg-7">
                <nav class="header__menu">
                    <x-nav-bar-links />
                </nav>
            </div>
            <div class="col-lg-4">
                <div class="header__cart d-none d-lg-block">
                    <ul>
                        @if (auth()->check())
                            <li><a href="{{ route('wishlist.index') }}"><i class="fa fa-heart"></i>
                                    <span>{{ auth()->user()->wishlistProducts->count() }}</span></a></li>
                            <li><a href="{{ route('cart.index') }}"><i class="fa fa-shopping-bag"></i>
                                    <span>{{ auth()->user()->cartProducts->count() }}</span></a></li>
                            <li>
                                <form data-ajax="true" action="{{ route('logout') }}" method="post"><a
                                        title="sigin in" onclick="$(this).parent('form').submit()"><i
                                            class="fa fa-sign-out"></i> <span></span></a>
                                </form>
                            </li>
                        @else
                            <li>
                                <a title="sigin in" href="{{ route('login.form') }}"><i class="fa fa-sign-in"></i>
                                    <span></span></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
