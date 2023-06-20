<div class="item">
    <div class="product-card mb-3">
        <div class="product-head">
            @if ($product->labels->count())
                <div class="row">
                    <div class="btn-group" role="group">
                        @foreach ($product->labels as $label)
                            <div class="fild_products">
                                <span>{{ $label->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="rating-stars">
                <i class="mdi mdi-star active"></i>
                <i class="mdi mdi-star active"></i>
                <i class="mdi mdi-star active"></i>
                <i class="mdi mdi-star active"></i>
                <i class="mdi mdi-star"></i>
            </div>
            @if($product->discount)
                <div class="discount">
                    <span>{{ $product->discount }}%</span>
                </div>
            @endif

        </div>
        <a class="product-thumb" href="{{ route('front.products.show', ['product' => $product]) }}">
            @if(option('show_image_optimize'))
                <img
                    data-src="{{ $product->webp_image ? asset($product->webp_image) : asset('/no-image-product.png') }}"
                    src="{{ theme_asset('images/600-600.png') }}" alt="{{ $product->title }}">
            @else
                <img data-src="{{ $product->image ? asset($product->image) : asset('/no-image-product.png') }}"
                     src="{{ theme_asset('images/600-600.png') }}" alt="{{ $product->title }}">
            @endif
        </a>
        <div class="product-card-body">
            @if($product->prices[0]->is_show_price)
                <h5 class="product-title">
                    <a href="{{ route('front.products.show', ['product' => $product]) }}">{{ $product->title }}</a>
                </h5>
                <a class="product-meta"
                   href="{{ $product->category ? $product->category->link : '#' }}">{{ $product->category ? $product->category->title :  trans('front::messages.partials.no-category') }}</a>
            @else
                <h5 class="product-title"  style="margin-bottom: 27px;">
                    <a href="{{ route('front.products.show', ['product' => $product]) }}">{{ $product->title }}</a>
                </h5>
            @endif
            <div class="price-index-h">
                @if(!$product->prices[0]->is_show_price)
                    <a href='' class='btn btn-danger w-100'><i class="mdi mdi-phone"></i> تماس برای قیمت</a>
                @endif
                @if($product->prices[0]->is_show_price)
                    <span class="product-price">{{ $product->getLowestPrice() }}</span>
                    @if($product->getLowestDiscount())
                        <del class="product-price-del">{{ $product->getLowestDiscount() }}</del>
                    @endif
                @endif
            </div>
            @if ($product->isSpecial() && $product->special_end_date && $product->special_end_date->diffInHours(now()) <= 24)
                <div class="countdown-timer mt-4 text-muted product-special-end-date" countdown
                     data-date="{{ $product->special_end_date->format('D M d Y H:i:s O') }}">
                    <span data-seconds="">0</span> :
                    <span data-minutes="">0</span> :
                    <span data-hours="">0</span>
                    <i class="mdi mdi-clock"></i>
                </div>
            @endif
            @if ($product->prices[0]->is_show_price && $product->isSinglePrice())
                <div class="cart">
                    <a data-action="{{ route('front.cart.store', ['product' => $product]) }}"
                       class="d-flex align-items-center add-to-cart-single" href="javascript:void(0)"><i
                            class="mdi mdi-plus px-2"></i>
                        <span>{{ trans('front::messages.partials.add-to-cart') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
