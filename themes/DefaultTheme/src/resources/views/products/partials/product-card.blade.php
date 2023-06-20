<div class="product-card mb-2 mx-res-0">
    @if($product->isSpecial())
        <div class="promotion-badge">
         {{ trans('front::messages.categories.special-sale') }}
        </div>
    @endif
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
            <i class="mdi mdi-star active"></i>
        </div>
        @if($product->discount)
            <div class="discount">
                <span>{{ $product->discount }}%</span>
            </div>
        @endif
    </div>
        <a class="product-thumb" href="{{ route('front.products.show', ['product' => $product]) }}">
            @if(option('show_image_optimize'))
                <img data-src="{{ $product->webp_image ? $product->webp_image : asset('/no-image-product.png') }}"
                     src="{{ theme_asset('images/600-600.png') }}" alt="{{ $product->title }}">
            @else
                <img data-src="{{ $product->image ? $product->image : asset('/no-image-product.png') }}"
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
                <div class="product-prices-div">
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
            </div>

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
