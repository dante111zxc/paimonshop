
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ !empty($dataSeo['site_name']) ? $dataSeo['site_name'] : config('app.name', 'Paimonshop') }}</title>
    <meta name="description" content="{{ !empty($dataSeo['meta_desc']) ? $dataSeo['meta_desc'] : '' }}">
    <meta name="keywords" content="{{ !empty($dataSeo['keyword_seo']) ? $dataSeo['keyword_seo'] : '' }}">
    <meta name="news_keywords" content="{{ !empty($dataSeo['keyword_seo']) ? $dataSeo['keyword_seo'] : '' }}">
    <meta name="og:type" content="{{ !empty($dataSeo['schema_type']) ? $dataSeo['schema_type'] : 'article' }}">
    <meta name="og:title" content="{{ !empty($dataSeo['site_name']) ? $dataSeo['site_name'] : '' }}">
    <meta name="og:description" content="{{ !empty($dataSeo['meta_desc']) ? $dataSeo['meta_desc'] : '' }}">
    <meta name="og:image" content="{{ !empty($dataSeo['logo']) ? getThumbnail($dataSeo['logo']): asset('/assets/img/og_img.png') }}">
    <meta name="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:description" content="{{ !empty($dataSeo['meta_desc']) ? $dataSeo['meta_desc'] : '' }}">
    <meta name="twitter:title" content="{{ !empty($dataSeo['site_name']) ? $dataSeo['site_name'] : '' }}">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:image" content="{{ !empty($dataSeo['logo']) ? getThumbnail($dataSeo['logo']): '' }}">
    <meta name="twitter:site" content="@paimonshop">
    <meta name="twitter:creator" content="@paimonshop">
    <meta name="robots" content="{{ !empty($dataSeo['robots']) ? $dataSeo['robots'] : 'noindex, nofollow' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <script>
        var homeUrl = '{{ url('/') }}';
    </script>
    <!-- Scripts -->
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" sizes="32x32">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700;1,800&display=swap"
          rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">


{{--    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=366654317181054&autoLogAppEvents=1" nonce="gqlSpKW7"></script>--}}
</head>
<body>
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "102221568248663");
        chatbox.setAttribute("attribution", "biz_inbox");

        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v12.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <header>
        <div class="container">
            <div class="row no-gutters align-items-center">
                <div class="col-12 col-md-3 col-xl-2">
                    <a class="logo" href="{{ url('/') }}">
                        <img class="lazy" src="{{ asset('assets/img/logo.png') }}">
                    </a>
                </div>
                <div class="col-12 col-md-9 col-xl-10">
                    @php
                        $menuHeader = getMenu('menu_header');
                    @endphp
                    <a href="javascript:void (0)" class="toggle-menu icon-menu"><i class="bi bi-list"></i></a>
                    @if(!Auth::check())
                        <a class="login-mobile" href="{{ route('login') }}">
                            <i class="bi bi-person-circle"></i><span>????ng nh???p / ????ng k??</span>
                        </a>

                        @else

                        <a class="profile-mobile" href="{{ route('profile') }}">
                            <i class="bi bi-person-circle"></i><span>{{ showName(Auth::user()->name) }} - {{ showCoin(Auth::user()->pcoin) }}</span>
                        </a>
                    @endif


                    <nav id="menuMobile">
                            <ul>
                                @if($menuHeader)
                                    @foreach($menuHeader as $item)
                                        <li>
                                            <a href="{{ getMenuItemUrl($item) }}">{{ $item->title }}</a>
                                            @if($item->recursiveMenu->count() > 0)
                                                <ul>
                                                    @foreach ($item->recursiveMenu as $subMenu)
                                                        @include('public.partial.submenu-mobile', ['subMenu' => $subMenu])
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                                @if(!Auth::check())
                                    <li><a href="{{ route('login') }}"><i class="bi bi-person-circle"></i> ????ng nh???p</a></li>
                                    <li><a href="{{ route('register') }}"><i class="bi bi-person-plus-fill"></i> ????ng k??</a></li>

                                    @else
                                    <li><a href="{{ route('profile') }}"><i class="bi bi-person-circle"></i> {{ Auth::user()->name }}</a></li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-left"></i> ????ng xu???t</a>
                                    </li>
                                @endif
                                <li><a href="{{ route('show_cart') }}"><i class="bi bi-bag-fill"></i> Gi??? h??ng</a></li>
                            </ul>
                        </nav>

                    <div class="d-xl-flex justify-content-xl-between">

                        @if($menuHeader)
                            <nav class="main-nav">
                                <ul class="main-menu">
                                    @foreach($menuHeader as $item)
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ getMenuItemUrl($item) }}">{{ $item->title }}</a>
                                            @if($item->recursiveMenu->count() > 0)
                                                <ul class="sub-menu">
                                                    @foreach ($item->recursiveMenu as $subMenu)
                                                        @include('public.partial.submenu', ['subMenu' => $subMenu])
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                        @endif
                        <div class="icon-header">
                            <a class="search-icon" data-toggle="modal" data-target="#search-modal" href="javascript:void (0)">
                                <i class="bi bi-search"></i>
                            </a>
                            @if(!Auth::check())
                            <a class="login" href="{{ route('login') }}">
                                <i class="bi bi-person-circle"></i><span>????ng nh???p / ????ng k??</span>
                            </a>
                            @else
                                <a href="{{ route('profile') }}"><i class="bi bi-wallet"></i> N???p Pcoin</a>
                            <div class="profile dropdown">
                                <a href="javascript:void (0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <span>
                                        {!! showRankImg(getTotalOrderAmountByUserId(\Illuminate\Support\Facades\Auth::user()->id)) !!}
                                        {{ showName(Auth::user()->name) }}
                                    </span>
                                </a>

                                <div class="dropdown-menu">
                                    <div class="user-info"><a href="{{ route('profile') }}">Th??ng tin t??i kho???n</a></div>
                                    <div class="user-info"><a href="javascript:void(0)">T???ng ti???n h??ng: {!! showMoney(getTotalOrderAmountByUserId(\Illuminate\Support\Facades\Auth::user()->id)) !!}</a></div>
                                    <div class="user-info"><a href="{{ route('profile') }}">S??? d??: {{ showCoin(Auth::user()->pcoin) }}</a></div>
                                    <div class="user-logout"><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">????ng xu???t</a></div>
                                    <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                        {{ csrf_field() }}
                                    </form>

                                </div>
                            </div>
                            @endif
                            <div class="cart">
                                <div class="cart-icon" href="{{ route('show_cart') }}">
                                    <i class="bi bi-bag-fill"></i>
                                    <span>Gi??? h??ng</span>
                                </div>
                                <div class="cart-list-item">
                                    @include('public.ajax.cart')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="widget-footer">
                        <h2 class="widget-title">Paimonshop</h2>
                        <ul>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/tong-quan/gioi-thieu-paimon-shop">V??? ch??ng t??i</a></li>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/tong-quan/ly-do-nen-su-dung-dich-vu-tai-paimon-shop">D???ch v??? c???a ch??ng t??i</a></li>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/cac-chinh-sach/dieu-khoan-dich-vu">??i???u kho???n d???ch v???</a></li>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/cac-chinh-sach/chinh-sach-bao-mat">Ch??nh s??ch b???o m???t</a></li>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/cac-chinh-sach/chinh-sach-vip">Ch??nh s??ch VIP Member</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="widget-footer">
                        <h2 class="widget-title">H?????ng d???n</h2>
                        <ul>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/huong-dan-mua-hang/huong-dan-tao-tai-khoan">H?????ng d???n mua h??ng?</a></li>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/huong-dan-mua-hang/huong-dan-tao-tai-khoan/quan-ly-tai-khoan">H?????ng d???n t???o t??i kho???n</a></li>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/huong-dan-mua-hang/huong-dan-nap-tien">H?????ng d???n n???p ti???n</a></li>
                            <li><a href="https://paimon-shop.gitbook.io/paimon/huong-dan-mua-hang/huong-dan-thanh-toan">H?????ng d???n thanh to??n</a></li>
                            <li><a href="{{ route('register') }}">????ng k?? t??i kho???n</a></li>
                            <li><a href="{{ route('login') }}">????ng nh???p</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="widget-footer">
                        <h2 class="title">Fanpage PaimonShop</h2>
                        <div class="fb-page" data-href="https://www.facebook.com/PaimonTopup/" data-tabs="timeline" data-height="200" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/PaimonTopup/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/PaimonTopup/">Paimon Shop</a></blockquote></div>
{{--                        <div class="social-icon">--}}
{{--                            <a href="#"><i class="bi bi-facebook"></i></a>--}}
{{--                            <a href="#"><i class="bi bi-twitter"></i></a>--}}
{{--                            <a href="#"><i class="bi bi-youtube"></i></a>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="copy-right">?? 2021 Pimonshop.com. All Rights Reserved</div>
    <div class="modal fade" id="search-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="search-form">
                    <h2>Nh???p t??n t???a game b???n mu???n t??m ki???m</h2>
                    <form method="GET" action="{{ route('search') }}">
                        @csrf
                        <input type="text" name="search_keyword" class="form-control" placeholder="T??m ki???m...">
                        <button type="submit"><i class="bi bi-search"></i></button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="overlay fade">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</body>
</html>
