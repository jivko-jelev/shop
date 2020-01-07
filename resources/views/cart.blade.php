@php
    $carts = App\Cart::where('user_id', Auth::id())
    ->select(['carts.*', 'variations.name as variation_name', 'sub_variations.name as subvariation_name', 'products.name', 'thumbnails.filename'])
    ->selectRaw('IFNULL(products.promo_price, products.price) as price')
    ->join('products', 'carts.product_id', 'products.id')
    ->leftjoin('variations', 'variations.product_id', 'carts.product_id')
    ->leftjoin('sub_variations', 'sub_variations.id', 'carts.subvariation_id')
    ->leftjoin('thumbnails', function($join){
        $join->on('thumbnails.picture_id', 'products.picture_id')
        ->where('size', 0);
        })
    ->get();
@endphp
@extends('partials.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="styles/cart_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/cart_responsive.css">
@endsection

@section('content')
    <!-- Cart -->

    <div class="cart_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cart_container">
                        <div class="cart_title">Shopping Cart</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <th>Снимка</th>
                                <th>Име</th>
                                <th>Вариация</th>
                                <th>Брой</th>
                                <th class="text-right">Ед. цена</th>
                                <th class="text-right">Общо</th>
                                </thead>
                                <tbody>
                                @foreach($carts as $cart)
                                    <tr>
                                        <td><img src="{{ $cart->filename }}" alt=""></td>
                                        <td>{{ $cart->name }}</td>
                                        <td>{!! isset($cart->variation_name) ? "{$cart->variation_name}: <strong>{$cart->subvariation_name}</strong>" : 'N / A' !!}</td>
                                        <td>{{ $cart->quantity }}</td>
                                        <td class="text-right">{!! \App\Functions::priceText($cart->price) !!}</td>
                                        <td class="text-right">{!! \App\Functions::priceText($cart->quantity * $cart->price) !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Order Total -->
                        <div class="order_total">
                            <div class="order_total_content text-md-right">
                                <div class="order_total_title">Обща стойност на поръчката:</div>
                                <div class="order_total_amount">{!! App\Cart::total($carts) !!}</div>
                            </div>
                        </div>

                        <div class="cart_buttons">
                            <button type="button" class="button cart_button_clear">Add to Cart</button>
                            <button type="button" class="button cart_button_checkout">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection