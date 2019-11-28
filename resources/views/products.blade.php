@foreach($products->chunk(4) as $chunk)
    <div class="row">
        @foreach($chunk as $product)
            <div class="col-6 col-md-3">
                <!-- Product Item -->
                <div class="product_item is_new">
                    <div class="product_border"></div>
                    <div class="product_image d-flex flex-column align-items-center justify-content-center"><img
                                src="{{ $product->getThumbnail() }}" alt=""></div>
                    <div class="product_content">
                        @if($product->promo_price)
                            <div class="product_price discount">{{ $product->promoPriceText() }}
                                <span>{{ $product->priceText() }}</span></div>
                        @else
                            <div class="product_price">{{ $product->priceText() }}</div>
                        @endif
                        <div class="product_name">
                            <div><a href="#" tabindex="0">{{ $product->name }}</a></div>
                        </div>
                        <div class="product_extras">
                            <button class="product_cart_button">Add to Cart</button>
                        </div>

                    </div>
                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                    <ul class="product_marks">
                        <li class="product_mark product_new">new</li>
                        @if($product->promo_price)
                            <li class="product_mark product_discount">{{ round($product->discountText(), 2) }}%</li>
                        @endif
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endforeach