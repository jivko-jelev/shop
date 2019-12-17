@extends('partials.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/product_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/product_responsive.css') }}">
@endsection

@section('content')
    <div class="single_product">
        <div class="container">
            <div class="row">
                <!-- Images -->
                <div class="col-lg-2 order-lg-1 order-2">
                    @if(count($product->pictures) > 0)
                        <ul class="image_list">
                            @foreach($product->pictures as $picture)
                                @foreach($picture->thumbnails as $thumbnail)
                                    <li data-image="{{ URL::to($thumbnail->filename) }}"><img src="{{ URL::to($thumbnail->filename) }}" alt=""></li>
                                @endforeach
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Selected Image -->
                <div class="col-lg-5 order-lg-2 order-1">
                    <div class="image_selected"><img src="{{ $product->getPicture() }}" alt=""></div>
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
                                            <div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
                                            <div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
                                        </div>
                                    </div>

                                    @if($product->type == 'Вариация')
                                        <ul class="product_color">
                                            <li>
                                                <span>{{ $product->variation->name }}: </span>
                                                <div class="color_mark_container">
                                                    <div id="selected_color" class="color_mark"></div>
                                                </div>
                                                <div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>

                                                <ul class="color_list">
                                                    @foreach($product->variation->subVariations as $subVariations)
                                                        <li>{{ $subVariations->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                    @endif

                                </div>

                                <div class="product_price">{{ $product->realPrice() }}</div>
                                <div class="button_container">
                                    <button type="button" class="button cart_button">Add to Cart</button>
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

@push('js')
    <script src="{{ URL::to('js/product_custom.js') }}"></script>
@endpush