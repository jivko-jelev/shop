<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shop</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="OneTech shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/bootstrap4/bootstrap.min.css') }}">
    <link href="{{ URL::to('plugins/fontawesome-free-5.0.1/css/fontawesome-all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/OwlCarousel2-2.2.1/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/jquery-ui-1.12.1.custom/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/shop_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/responsive.css') }}">

</head>

<body>

<div class="super_container">

    <!-- Header -->

    <header class="header">

        <!-- Top Bar -->

        <div class="top_bar">
            <div class="container">
                <div class="row">
                    <div class="col d-flex flex-row">
                        <div class="top_bar_contact_item">
                            <div class="top_bar_icon"><img src="{{ URL::to('images/phone.png') }}" alt=""></div>
                            +38 068 005 3570
                        </div>
                        <div class="top_bar_contact_item">
                            <div class="top_bar_icon"><img src="{{ URL::to('images/mail.png') }}" alt=""></div>
                            <a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a></div>
                        <div class="top_bar_content ml-auto">
                            <div class="top_bar_menu">
                                <ul class="standard_dropdown top_bar_dropdown">
                                    <li>
                                        <a href="#">English<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="#">Italian</a></li>
                                            <li><a href="#">Spanish</a></li>
                                            <li><a href="#">Japanese</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">$ US dollar<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="#">EUR Euro</a></li>
                                            <li><a href="#">GBP British Pound</a></li>
                                            <li><a href="#">JPY Japanese Yen</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="top_bar_user">
                                <div class="user_icon"><img src="{{ URL::to('images/user.svg') }}" alt=""></div>
                                <div><a href="#">Register</a></div>
                                <div><a href="#">Sign in</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Main -->

        <div class="header_main">
            <div class="container">
                <div class="row">

                    <!-- Logo -->
                    <div class="col-lg-2 col-sm-3 col-3 order-1">
                        <div class="logo_container">
                            <div class="logo"><a href="#">OneTech</a></div>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                        <div class="header_search">
                            <div class="header_search_content">
                                <div class="header_search_form_container">
                                    <form action="#" class="header_search_form clearfix">
                                        <input type="search" required="required" class="header_search_input" placeholder="Търсене...">
                                        <div class="custom_dropdown">
                                            <div class="custom_dropdown_list">
                                                <span class="custom_dropdown_placeholder clc">Всички категории</span>
                                                <i class="fas fa-chevron-down"></i>
                                                <ul class="custom_list clc">
                                                    <li><a class="clc" href="#">Всички категории</a></li>
                                                    @foreach(\App\Category::whereNull('parent_id')->get() as $category)
                                                        <li><a class="clc" href="#">{{ $category->title }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <button type="submit" class="header_search_button trans_300" value="Submit"><img
                                                    src="{{ URL::to('images/search.png') }}" alt=""></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist -->
                    <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                        <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                            <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                                <div class="wishlist_icon"><img src="{{ URL::to('images/heart.png') }}" alt=""></div>
                                <div class="wishlist_content">
                                    <div class="wishlist_text"><a href="#">Любими</a></div>
                                    <div class="wishlist_count">115</div>
                                </div>
                            </div>

                            <!-- Cart -->
                            <div class="cart">
                                <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                    <div class="cart_icon">
                                        <img src="{{ URL::to('images/cart.png') }}" alt="">
                                        <div class="cart_count"><span>10</span></div>
                                    </div>
                                    <div class="cart_content">
                                        <div class="cart_text"><a href="#">Количка</a></div>
                                        <div class="cart_price">85 лв.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->

        <nav class="main_nav">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <div class="main_nav_content d-flex flex-row">

                            <!-- Categories Menu -->

                            <div class="cat_menu_container">
                                <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                                    <div class="cat_burger"><span></span><span></span><span></span></div>
                                    <div class="cat_menu_text">категории</div>
                                </div>

                                <ul class="cat_menu">
                                    {{--                                    <li><a href="#">Computers & Laptops <i class="fas fa-chevron-right ml-auto"></i></a></li>--}}
                                    {{--                                    <li><a href="#">Cameras & Photos<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                    <li class="hassubs">--}}
                                    {{--                                        <a href="#">Hardware<i class="fas fa-chevron-right"></i></a>--}}
                                    {{--                                        <ul>--}}
                                    {{--                                            <li class="hassubs">--}}
                                    {{--                                                <a href="#">Menu Item<i class="fas fa-chevron-right"></i></a>--}}
                                    {{--                                                <ul>--}}
                                    {{--                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                                </ul>--}}
                                    {{--                                            </li>--}}
                                    {{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                        </ul>--}}
                                    {{--                                    </li>--}}
                                    {{--                                    <li><a href="#">Smartphones & Tablets<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                    <li><a href="#">TV & Audio<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                    <li><a href="#">Gadgets<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                    <li><a href="#">Car Electronics<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                    <li><a href="#">Video Games & Consoles<i class="fas fa-chevron-right"></i></a></li>--}}
                                    {{--                                    <li><a href="#">Accessories<i class="fas fa-chevron-right"></i></a></li>--}}
                                </ul>
                            </div>

                            <!-- Main Nav Menu -->

                            <div class="main_nav_menu ml-auto">
                                <ul class="standard_dropdown main_nav_dropdown">
                                    <li><a href="#">Home<i class="fas fa-chevron-down"></i></a></li>
                                    <li class="hassubs">
                                        <a href="#">Super Deals<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li>
                                                <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>
                                                <ul>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="hassubs">
                                        <a href="#">Featured Brands<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li>
                                                <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>
                                                <ul>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="hassubs">
                                        <a href="#">Pages<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="shop.html">Shop<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="product.html">Product<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="blog.html">Blog<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="blog_single.html">Blog Post<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="regular.html">Regular Post<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="cart.html">Cart<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li><a href="blog.html">Blog<i class="fas fa-chevron-down"></i></a></li>
                                    <li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>
                                </ul>
                            </div>

                            <!-- Menu Trigger -->

                            <div class="menu_trigger_container ml-auto">
                                <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                    <div class="menu_burger">
                                        <div class="menu_trigger_text">menu</div>
                                        <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Menu -->

        <div class="page_menu">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <div class="page_menu_content">

                            <div class="page_menu_search">
                                <form action="#">
                                    <input type="search" required="required" class="page_menu_search_input" placeholder="Search for products...">
                                </form>
                            </div>
                            <ul class="page_menu_nav">
                                <li class="page_menu_item has-children">
                                    <a href="#">Language<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">English<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Italian<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Spanish<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Japanese<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children">
                                    <a href="#">Currency<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">US Dollar<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">EUR Euro<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">GBP British Pound<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">JPY Japanese Yen<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item">
                                    <a href="#">Home<i class="fa fa-angle-down"></i></a>
                                </li>
                                <li class="page_menu_item has-children">
                                    <a href="#">Super Deals<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Super Deals<i class="fa fa-angle-down"></i></a></li>
                                        <li class="page_menu_item has-children">
                                            <a href="#">Menu Item<i class="fa fa-angle-down"></i></a>
                                            <ul class="page_menu_selection">
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children">
                                    <a href="#">Featured Brands<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Featured Brands<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children">
                                    <a href="#">Trending Styles<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Trending Styles<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item"><a href="blog.html">blog<i class="fa fa-angle-down"></i></a></li>
                                <li class="page_menu_item"><a href="contact.html">contact<i class="fa fa-angle-down"></i></a></li>
                            </ul>

                            <div class="menu_contact">
                                <div class="menu_contact_item">
                                    <div class="menu_contact_icon"><img src="{{ URL::to('images/phone_white.png') }}" alt=""></div>
                                    +38 068 005 3570
                                </div>
                                <div class="menu_contact_item">
                                    <div class="menu_contact_icon"><img src="{{ URL::to('images/mail_white.png') }}" alt=""></div>
                                    <a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <!-- Home -->

    <div class="home">
        <div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ URL::to('images/shop_background.jpg') }}"></div>
        <div class="home_overlay"></div>
        <div class="home_content d-flex flex-column align-items-center justify-content-center">
            <h2 class="home_title">Smartphones & Tablets</h2>
        </div>
    </div>

    <!-- Shop -->

    <div class="shop">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    <!-- Shop Sidebar -->
                    <div class="shop_sidebar">
                        <div class="sidebar_section filter_by_section">
                            <div class="sidebar_title">Filter By</div>
                            <div class="sidebar_subtitle">Price</div>
                            <div class="filter_price">
                                <div id="slider-range" class="slider_range"></div>
                                <p>Диапазон: </p>
                                <p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
                            </div>
                        </div>
                        <div class="sidebar_section">
                            <div class="sidebar_subtitle color_subtitle">Color</div>
                            <ul class="colors_list">
                                <li class="color"><a href="#" style="background: #b19c83;"></a></li>
                                <li class="color"><a href="#" style="background: #000000;"></a></li>
                                <li class="color"><a href="#" style="background: #999999;"></a></li>
                                <li class="color"><a href="#" style="background: #0e8ce4;"></a></li>
                                <li class="color"><a href="#" style="background: #df3b3b;"></a></li>
                                <li class="color"><a href="#" style="background: #ffffff; border: solid 1px #e1e1e1;"></a></li>
                            </ul>
                        </div>
                        <form action="" id="properties">
                            @foreach ($properties as $prop)
                                <div class="sidebar_section">
                                    <div class="sidebar_subtitle brands_subtitle">{{ $prop->name }}</div>
                                    <ul class="brands_list">
                                        @foreach ($prop->subProperties as $subProperty)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $subProperty->id }}"
                                                       id="check[{{ $subProperty->id }}]" name="check[{{ $subProperty->id }}]">
                                                <label class="form-check-label" for="check[{{ $subProperty->id }}]">{{ $subProperty->name }}</label>
                                            </div>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                            <input type="hidden" name="order-by" id="order-by" value="price-asc">
                            <input type="hidden" name="per-page" id="per-page" value="20">
                            <input type="hidden" name="min_price" id="min-price" value="{{ round($prices->min_price) }}">
                            <input type="hidden" name="max_price" id="max-price" value="{{ round($prices->max_price) }}">
                        </form>
                    </div>

                </div>

                <div class="col-lg-9">

                    <!-- Shop Content -->

                    <div class="shop_content">
                        <div class="shop_bar clearfix">
                            <div class="shop_product_count">
                                <span id="num-products">{{ $products_count }}</span> {{ $products_count > 1 ? 'намерени продукта' : 'намерен продукт' }}
                            </div>
                            <div class="shop_sorting">
                                <span>Подреди по:</span>
                                <ul>
                                    <li>
                                        <span class="sorting_text">цена възх.<i class="fas fa-chevron-down"></i></span>
                                        <ul>
                                            <li class="shop_sorting_button" data-sort-by='rating'>най-високо оценени</li>
                                            <li class="shop_sorting_button" data-sort-by='name-asc'>име възх.</li>
                                            <li class="shop_sorting_button" data-sort-by='name-desc'>име низх.</li>
                                            <li class="shop_sorting_button" data-sort-by='price-asc'>цена възх.</li>
                                            <li class="shop_sorting_button" data-sort-by='price-desc'>цена низх.</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop_sorting">
                                <span>Продукти на страница:</span>
                                <ul>
                                    <li>
                                        <span class="sorting_text">20<i class="fas fa-chevron-down"></i></span>
                                        <ul>
                                            <li class="shop_sorting_button" data-per-page='20'>20</li>
                                            <li class="shop_sorting_button" data-per-page='50'>50</li>
                                            <li class="shop_sorting_button" data-per-page='100'>100</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="product_grid">
                            @include('products')
                        </div>
                        <div class="d-flex justify-content-end" id="paginator">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Brands -->

            <div class="brands">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="brands_slider_container">

                                <!-- Brands Slider -->

                                <div class="owl-carousel owl-theme brands_slider">
                                    <div class="owl-item">
                                        <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ URL::to('images/brands_1.jpg') }}"
                                                                                                                alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ URL::to('images/brands_2.jpg') }}"
                                                                                                                alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ URL::to('images/brands_3.jpg') }}"
                                                                                                                alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ URL::to('images/brands_4.jpg') }}"
                                                                                                                alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ URL::to('images/brands_5.jpg') }}"
                                                                                                                alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ URL::to('images/brands_6.jpg') }}"
                                                                                                                alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ URL::to('images/brands_7.jpg') }}"
                                                                                                                alt="">
                                        </div>
                                    </div>
                                    <div class="owl-item">
                                        <div class="brands_item d-flex flex-column justify-content-center"><img src="{{ URL::to('images/brands_8.jpg') }}"
                                                                                                                alt="">
                                        </div>
                                    </div>

                                </div>

                                <!-- Brands Slider Navigation -->
                                <div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
                                <div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Newsletter -->

            <div class="newsletter">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                                <div class="newsletter_title_container">
                                    <div class="newsletter_icon"><img src="{{ URL::to('images/send.png') }}" alt=""></div>
                                    <div class="newsletter_title">Sign up for Newsletter</div>
                                    <div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
                                </div>
                                <div class="newsletter_content clearfix">
                                    <form action="#" class="newsletter_form">
                                        <input type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
                                        <button class="newsletter_button">Subscribe</button>
                                    </form>
                                    <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->

            <footer class="footer">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-3 footer_col">
                            <div class="footer_column footer_contact">
                                <div class="logo_container">
                                    <div class="logo"><a href="#">OneTech</a></div>
                                </div>
                                <div class="footer_title">Got Question? Call Us 24/7</div>
                                <div class="footer_phone">+38 068 005 3570</div>
                                <div class="footer_contact_text">
                                    <p>17 Princess Road, London</p>
                                    <p>Grester London NW18JR, UK</p>
                                </div>
                                <div class="footer_social">
                                    <ul>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        <li><a href="#"><i class="fab fa-google"></i></a></li>
                                        <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 offset-lg-2">
                            <div class="footer_column">
                                <div class="footer_title">Find it Fast</div>
                                <ul class="footer_list">
                                    <li><a href="#">Computers & Laptops</a></li>
                                    <li><a href="#">Cameras & Photos</a></li>
                                    <li><a href="#">Hardware</a></li>
                                    <li><a href="#">Smartphones & Tablets</a></li>
                                    <li><a href="#">TV & Audio</a></li>
                                </ul>
                                <div class="footer_subtitle">Gadgets</div>
                                <ul class="footer_list">
                                    <li><a href="#">Car Electronics</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="footer_column">
                                <ul class="footer_list footer_list_2">
                                    <li><a href="#">Video Games & Consoles</a></li>
                                    <li><a href="#">Accessories</a></li>
                                    <li><a href="#">Cameras & Photos</a></li>
                                    <li><a href="#">Hardware</a></li>
                                    <li><a href="#">Computers & Laptops</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="footer_column">
                                <div class="footer_title">Customer Care</div>
                                <ul class="footer_list">
                                    <li><a href="#">My Account</a></li>
                                    <li><a href="#">Order Tracking</a></li>
                                    <li><a href="#">Wish List</a></li>
                                    <li><a href="#">Customer Services</a></li>
                                    <li><a href="#">Returns / Exchange</a></li>
                                    <li><a href="#">FAQs</a></li>
                                    <li><a href="#">Product Support</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </footer>

            <!-- Copyright -->

            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col">

                            <div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
                                <div class="copyright_content"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                                    All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a
                                            href="https://colorlib.com" target="_blank">Colorlib</a>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                </div>
                                <div class="logos ml-sm-auto">
                                    <ul class="logos_list">
                                        <li><a href="#"><img src="{{ URL::to('images/logos_1.png') }}" alt=""></a></li>
                                        <li><a href="#"><img src="{{ URL::to('images/logos_2.png') }}" alt=""></a></li>
                                        <li><a href="#"><img src="{{ URL::to('images/logos_3.png') }}" alt=""></a></li>
                                        <li><a href="#"><img src="{{ URL::to('images/logos_4.png') }}" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::to('bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::to('styles/bootstrap4/popper.js') }}"></script>
<script src="{{ URL::to('styles/bootstrap4/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('plugins/greensock/TweenMax.min.js') }}"></script>
<script src="{{ URL::to('plugins/greensock/TimelineMax.min.js') }}"></script>
<script src="{{ URL::to('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
<script src="{{ URL::to('plugins/greensock/animation.gsap.min.js') }}"></script>
<script src="{{ URL::to('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
<script src="{{ URL::to('plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
<script src="{{ URL::to('plugins/easing/easing.js') }}"></script>
<script src="{{ URL::to('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ URL::to('plugins/jquery-ui-1.12.1.custom/jquery-ui.js') }}"></script>
<script src="{{ URL::to('plugins/parallax-js-master/parallax.min.js') }}"></script>
<script src="{{ URL::to('js/shop_custom.js') }}"></script>
<script>
    function productStyles() {
        $('.product_item').hover(
            function () {
                $(this).find('.product_border').hide();
                $(this).find('.product_cart_button').css('visibility', 'visible').css('opacity', '1');
                $(this).find('.product_image, .product_price, .product_name').css('position', 'relative').css('top', '-34px');
            },
            function () {
                $(this).find('.product_border').show();
                $(this).find('.product_cart_button').css('visibility', 'hidden').css('opacity', '0');
                $(this).find('.product_image, .product_price, .product_name').css('position', 'initial').css('top', '0px');
            });
    }

    productStyles();

    function initPriceSlider(min_price, max_price, selected_min_price, selected_max_price) {
        if($("#slider-range").length)
        {
            $("#slider-range").slider(
                {
                    range: true,
                    min: 0,
                    max: 1000,
                    values: [ 0, 500 ],
                    slide: function( event, ui )
                    {
                        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    }
                });

            $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
            $('.ui-slider-handle').on('mouseup', function()
            {
                $('.product_grid').isotope({
                    filter: function()
                    {
                        var priceRange = $('#amount').val();
                        var priceMin = parseFloat(priceRange.split('-')[0].replace('$', ''));
                        var priceMax = parseFloat(priceRange.split('-')[1].replace('$', ''));
                        var itemPrice = $(this).find('.product_price').clone().children().remove().end().text().replace( '$', '' );

                        return (itemPrice > priceMin) && (itemPrice < priceMax);
                    },
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });
            });
        }
    }

    function reloadProducts() {
        $.ajax({
            url: '{{ route('products.index', $categoryName) }}',
            data: $('#properties').serialize(),
            dataType: "json",
            success: function (data) {
                $('#num-products').html(data.products_count);
                $('.product_grid').html(`${data.view}`);
                productStyles();
                initPriceSlider({{ $prices->min_price }}, {{ $prices->max_price }});
            },
            error: function (data) {
            }
        })
    }

    $('.form-check-input').change(function () {
        reloadProducts();
    });

    initPriceSlider({{ $prices->min_price }}, {{ $prices->max_price }}, {{ $prices->min_price }}, {{ $prices->max_price }});
    function initIsotope() {
        $('.shop_sorting_button').on('click', function () {
            $(this).parent().parent().find('.sorting_text').html($(this).text() + '<i class="fas fa-chevron-down"></i>');
            if ($(this).data('sort-by')) {
                $('#order-by').val($(this).data('sort-by'));
            } else {
                $('#per-page').val($(this).data('sort-by'));
            }
            reloadProducts();
        });
    }
</script>
</body>

</html>