<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo.png" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div>

    <nav class="humberger__menu__nav mobile-menu">
        <x-nav-bar-links />
    </nav>
    <div id="mobile-menu-wrap"></div>

</div>

<header class="header">

    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="{{ route('dashboard') }}"><img
                            src="{{ config('app.media_url') . '/assets/media/small/logo/' }}/@setting(logo)"
                            alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 mt-4">
                <nav class="header__menu">
                    <x-nav-bar-links />
                </nav>
            </div>
            <div class="col-lg-4 mt-4">
                <div class="header__cart">
                    @if (auth()->check())
                        <ul>
                            <li><a title="Favourite" href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                            <li><a title="Cart" href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a>
                            </li>
                            <li><a title="Profile" href="#"><i class="fa fa-user"></i> <span>1</span></a></li>
                        </ul>
                        <div class="header__cart__price">item: <span>$150.00</span></div>
                    @else
                        <ul>
                            <li><a title="sigin in" href="#"><i class="fa fa-sign-in"></i> <span></span></a></li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
