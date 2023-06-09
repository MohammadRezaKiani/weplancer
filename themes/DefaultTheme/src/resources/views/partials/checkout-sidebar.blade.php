
<div id="checkout-sidebar" class="col-xl-3 col-lg-4 col-12 w-res-sidebar sticky-sidebar">
    @if ($cart->discount)

        <div class="col-md-12 col-12 px-0 mb-4">
            <div class="dt-sn pt-3 pb-3 px-res-1">
                <div class="section-title text-sm-title title-wide no-after-title-wide mb-0">
                    <h2>{{ trans('front::messages.cart.registered-discount-code') }}</h2>
                </div>
                <div class="form-ui">
                    <form action="{{ route('front.discount.destroy') }}" method="POST">
                        @csrf
                        @method('delete')
                        <div class="row text-center">
                            <div class="col-xl-6">
                                <h3>{{ $cart->discount->code }}</strong>
                            </div>
                            <div class="col-xl-6 text-left">
                                <button type="submit"
                                        class="btn btn-danger mt-res-1">{{ trans('front::messages.cart.remove-discount-code') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="col-sm-12 col-12 px-0 mb-4" style='margin-top: 12%'>
            <div class="dt-sn pt-3 pb-3 px-res-1">
                <div class="section-title text-sm-title title-wide no-after-title-wide mb-0">
                    <h2>{{ trans('front::messages.cart.discount-code') }}</h2>
                </div>
                <div class="form-ui">
                    <form id="discount-create-form"
                          action="{{ route('front.discount.store') }}">
                        @csrf
                        <div class="row text-center">
                            <div class="col-xl-12 col-lg-12">
                                <div class="form-row">
                                    <input type="text" name="code" class="input-ui pr-2"
                                           placeholder="{{ trans('front::messages.cart.enter-discount-code') }}"
                                           required style='margin-right: 6%'>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 text-left mt-3">
                                <button type="submit"
                                        class="btn btn-primary mt-res-1">{{ trans('front::messages.cart.register-discount-code') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="dt-sn mb-2 details">
        <ul class="checkout-summary-summary">
            <li>
                <span>{{ trans('front::messages.partials.total-amount') }}</span><span>{{ trans('front::messages.currency.prefix') }}{{ number_format($cart->price) }} {{ trans('front::messages.currency.suffix') }}</span>
            </li>

            @if($cart->totalDiscount())
                <li class="checkout-summary-discount">
                    <span>{{ trans('front::messages.partials.discount') }}</span><span> {{ trans('front::messages.currency.prefix') }}{{ number_format($cart->totalDiscount()) }} {{ trans('front::messages.currency.suffix') }}</span>
                </li>
            @endif

            @if ($cart->carrier_id && $cart->hasPhysicalProduct())
                <li>
                    <span>{{ trans('front::messages.partials.shipping-cost') }}</span>
                    <span>
                        {{ $cart->shippingCost() }}
                    </span>
                </li>
            @endif

        </ul>
        <div class="checkout-summary-devider">
            <div></div>
        </div>
        <div class="checkout-summary-content">
            <div class="checkout-summary-price-title">{{ trans('front::messages.partials.the-amount-payable') }}</div>
            <div class="checkout-summary-price-value">
                <span id="final-price" data-value="{{ $cart->finalPrice() }}" class="checkout-summary-price-value-amount">
                    {{ trans('front::messages.currency.prefix') }}{{ number_format($cart->finalPrice()) }}
                </span>
                {{ trans('front::messages.currency.suffix') }}
            </div>

            <button data-action="{{ route('front.cart') }}" data-redirect="{{ route('front.checkout') }}" id="checkout-link" type="button" class="btn-primary-cm btn-with-icon w-100 text-center pr-0 checkout_link">
                <i class="mdi mdi-arrow-left"></i>
                {{ trans('front::messages.partials.continue-order-registration') }}
            </button>

            <div>
                <span>
                    {{ trans('front::messages.partials.unregistered-goods') }}
                </span>
                <span class="help-sn" data-toggle="tooltip" data-html="true" data-placement="bottom"  title="<div class='help-container is-right'><div class='help-arrow'></div><p class='help-text'>{{ trans('front::messages.partials.products-in-cart') }}</p></div>">
                    <span class="mdi mdi-information-outline"></span>
                </span>
            </div>
        </div>
    </div>

</div>
