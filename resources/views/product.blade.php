@extends('partials.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/product_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/product_responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <style type="text/css">
        .slick-slide {
            outline: none;
        }

        .slick-slide img {
            width: 100%;
        }

        .slider button, .slider ul {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="single_product">
        <div class="container">
            <div class="row">
                <!-- Images -->
                <div class="col-lg-5">
                    <div class="slider slider-for">
                        <div>
                            <img src="{{ $product->getPicture() }}">
                        </div>
                        @if(count($product->pictures) > 0)
                            @foreach($product->pictures as $picture)
                                <div>
                                    <img src="{{ URL::to($picture->picture->filename) }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="slider slider-nav">
                        @if(count($product->pictures) > 0)
                            <div>
                                <img src="{{ $product->getPicture() }}">
                            </div>
                            @foreach($product->pictures as $picture)
                                <div>
                                    <img src="{{ URL::to($picture->picture->filename) }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="col-lg-5 order-3">
                    <div class="product_description">
                        <div class="product_category">{{ $product->category->title }}</div>
                        <div class="product_name">{{ $product->name }}</div>
                        <div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>
                        <div class="product_text">{!! $product->description !!}</div>
                        <div class="order_info d-flex flex-row">
                            <form action="#">
                                <div class="clearfix" style="z-index: 1000;">

                                    <!-- Product Quantity -->
                                    <div class="product_quantity clearfix">
                                        <span>Quantity: </span>
                                        <input id="quantity_input" type="text" pattern="[0-9]*" value="1">
                                        <div class="quantity_buttons">
                                            <div id="quantity_inc_button" class="quantity_inc quantity_control"><i
                                                    class="fas fa-chevron-up"></i></div>
                                            <div id="quantity_dec_button" class="quantity_dec quantity_control"><i
                                                    class="fas fa-chevron-down"></i></div>
                                        </div>
                                    </div>

                                    @if($product->type == 'Вариация')
                                        <ul class="product_color">
                                            <li>
                                                <span>{{ $product->variation->name }}: </span>
                                                <div class="color_mark_container">
                                                    <div id="selected_variation">избери</div>
                                                </div>
                                                <div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>

                                                <ul class="variation_list">
                                                    @foreach($product->variation->subVariations as $subVariations)
                                                        <li>{{ $subVariations->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                    @endif

                                </div>

                                @if($product->promo_price)
                                    <div class="product_price discount">{!! $product->promoPriceText() !!}
                                        <span>{!! $product->priceText() !!}</span></div>
                                @else
                                    <div class="product_price">{!! $product->priceText() !!}</div>
                                @endif
                                <div class="button_container">
                                    <button type="button" class="button cart_button">Добави в количката</button>
                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::to('js/product_custom.js') }}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: true,
            centerMode: true,
            focusOnSelect: true
        });
    </script>
@endsection