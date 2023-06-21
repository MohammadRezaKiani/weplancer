@extends('front::layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/nice-select.css') }}">
@endpush

@section('wrapper-classes', 'shopping-page')

@section('content')
    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <form id="checkout-form" data-price-action="{{ route('front.checkout.prices') }}"
                  action="{{ route('front.orders.store') }}" class="setting_form" method="POST">
                @csrf
                <div class="row">

                    <div class="cart-page-content col-xl-9 col-lg-8 col-12 px-0">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if(!$discount_status['status'])
                            <div class="alert alert-danger" role="alert">
                                <p>{{ trans('front::messages.cart.discount-code-is-invalid') }}</p>
                                <span>{{ $discount_status['message'] }}</span>
                            </div>
                        @endif
                        <div class="section-title text-sm-title title-wide no-after-title-wide mb-0 px-res-1">
                            <h2>{{ trans('front::messages.cart.order-delivery-address') }}</h2>
                        </div>
                        <section class="page-content dt-sl">
                            <div class="form-ui dt-sl pt-4 pb-4 checkout-div">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div id="order-reserve-container"
                                             data-action="{{ route('front.reserve-cart') }}"
                                             class="checkout-shipment mt-2 mb-3">
                                            @if (option('reserve_orders_enabled'))
                                                <div class="custom-control custom-radio pr-0 pl-3">
                                                    <input type="radio" class="custom-control-input" name="reserve"
                                                           id="reserve1"
                                                           value="reserve" {{ $cart->reserved() ? 'checked' : '' }}>
                                                    <label for="reserve1" class="custom-control-label">
                                                        رزرو سفارش (نگهداری در انبار)
                                                        @if (option('reserve_orders_page_link'))
                                                            <small>
                                                                <a target="_blank"
                                                                   href="{{ option('reserve_orders_page_link') }}">اطلاعات
                                                                    بیشتر</a>
                                                            </small>
                                                        @endif
                                                    </label>
                                                </div>
                                            @endif

                                            @php
                                                $reserved_orders = auth()->user()->orders()->paid()->reserved()->get();
                                            @endphp

                                            @if (option('reserve_orders_enabled') || $reserved_orders->count())
                                                @if ($reserved_orders->count())
                                                    <div class="custom-control custom-radio  pr-0 pl-3">
                                                        <input type="radio" class="custom-control-input" name="reserve"
                                                               id="reserve2"
                                                               value="send_reserved_orders" {{ $cart->send_reserved_orders ? 'checked' : '' }}>
                                                        <label for="reserve2" class="custom-control-label">
                                                            ارسال سفارشات قبلی بهمراه این سفارش
                                                            ({{ $reserved_orders->count() }} سفارش)
                                                        </label>
                                                    </div>

                                                    @if ($cart->send_reserved_orders)
                                                        <div class="my-3">
                                                            @foreach ($reserved_orders as $reserved_order)
                                                                <a target="_blank"
                                                                   href="{{ route('front.orders.show', ['order' => $reserved_order]) }}">
                                                                    <span
                                                                        class="mx-2">سفارش شماره {{ $reserved_order->id }}</span>
                                                                </a>{{ $loop->last ? '' : ' و ' }}
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endif

                                                <div class="custom-control custom-radio pr-0 pl-3">
                                                    <input type="radio" class="custom-control-input" name="reserve"
                                                           id="reserve3" value="no-reserve">
                                                    <label for="reserve3" class="custom-control-label">
                                                        ادامه فرایند سفارش
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <div class="form-row-title">
                                            <h4>
                                                {{ trans('front::messages.cart.fname-and-lname') }} <sup
                                                    class="text-danger">*</sup>
                                            </h4>
                                        </div>
                                        <div class="form-row form-group">
                                            <input class="input-ui pr-2 text-right"
                                                   type="text"
                                                   name="name" value="{{ old('name') ?: auth()->user()->fullname }}"
                                                   placeholder="{{ trans('front::messages.cart.enter-your-name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <div class="form-row-title">
                                            <h4>
                                                {{ trans('front::messages.cart.phone-number') }} <sup
                                                    class="text-danger">*</sup>
                                            </h4>
                                        </div>
                                        <div class="form-row form-group">
                                            <input
                                                class="input-ui pl-2 dir-ltr text-left"
                                                type="text"
                                                name="mobile" value="{{ old('mobile') ?: auth()->user()->username }}"
                                                placeholder="09xxxxxxxxx">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2 mb-2">
                                        <div class="form-row-title">
                                            <h4>
                                                {{ trans('front::messages.cart.order-description') }}
                                            </h4>
                                        </div>
                                        <div class="form-row">
                                                <textarea
                                                    class="input-ui pr-2 text-right"
                                                    name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>


                                    @if (option('site_rules_page_link'))
                                        <div class="col-md-12 mb-2">
                                            <div class="checkout-invoice">
                                                <div class="checkout-invoice-headline">
                                                    <div class="custom-control custom-checkbox pr-0 form-group">
                                                        <input id="agreement" name="agreement" type="checkbox"
                                                               class="custom-control-input" required>
                                                        <label for="agreement"
                                                               class="custom-control-label">{{ trans('front::messages.cart.site-rules') }}</label>
                                                        <small>
                                                            <a target="_blank"
                                                               href="{{ option('site_rules_page_link') }}">اطلاعات
                                                                بیشتر</a>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>

                            <div
                                class="section-title no-reletive text-sm-title title-wide no-after-title-wide mb-0 px-res-1 mt-4">
                                <h2 class="mt-2">انتخاب آدرس</h2>
                            </div>

                            <div class="form-ui dt-sl pt-4 pb-4 checkout-div">

                                @if(is_null($address))
                                    <div class='alert alert-danger'>
                                        <span>هنوز آدرس مورد نظر خود را مشخص نکرده اید</span>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select id="level" class="form-control valid" name="level"
                                                    aria-invalid="false">
                                                @foreach($address as $addr)
                                                    <option value="{{$addr->id}}">{{$addr->address}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif


                            </div>

                            @if ($cart->hasPhysicalProduct())
                                <div id="carriers-main-container"
                                     style="{{ $cart->reserved() ? 'display: none' : '' }}">
                                    <div
                                        class="section-title no-reletive text-sm-title title-wide no-after-title-wide mb-0 px-res-1">
                                        <h2 class="mt-2">{{ trans('front::messages.cart.choose-how-to-send') }}</h2>
                                    </div>

                                    @include('front::partials.carriers-container', ['cart' => $cart])

                                </div>
                            @endif

                            <section class="page-content dt-sl pt-2">
                                <div class="section-title text-sm-title title-wide no-after-title-wide mb-0 px-res-1">
                                    <h2> {{ trans('front::messages.cart.choose-payment-method') }}</h2>
                                </div>

                                <div class="dt-sn pt-3 pb-3 mb-4">
                                    <div class="checkout-pack">
                                        <div class="row">
                                            <div class="checkout-time-table checkout-time-table-time">

                                                @if ($wallet->balance)
                                                    <div class="col-12 wallet-select">
                                                        <div class="radio-box custom-control custom-radio pl-0 pr-3">
                                                            <input type="radio" class="custom-control-input"
                                                                   name="gateway" id="wallet" value="wallet">
                                                            <label for="wallet" class="custom-control-label">
                                                                <i class="mdi mdi-credit-card-multiple-outline checkout-additional-options-checkbox-image"></i>
                                                                <div class="content-box">
                                                                    <div
                                                                        class="checkout-time-table-title-bar checkout-time-table-title-bar-city">
                                                                        <span
                                                                            class="has-balance">{{ trans('front::messages.cart.pay-with-wallet') }}</span>
                                                                        <span class="increase-balance"
                                                                              style="display: none;">{{ trans('front::messages.cart.increase-and-pay-with-kyiv') }}</span>
                                                                    </div>
                                                                    <ul class="checkout-time-table-subtitle-bar">
                                                                        <li id="wallet-balance"
                                                                            data-value="{{ $wallet->balance }}">
                                                                            {{ trans('front::messages.cart.inventory') }}{{ trans('front::messages.currency.prefix') }}{{ number_format($wallet->balance) }}{{ trans('front::messages.currency.suffix') }}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif

                                                @foreach ($gateways as $gateway)

                                                    <div class="col-12">
                                                        <div class="radio-box custom-control custom-radio pl-0 pr-3">
                                                            <input type="radio" class="custom-control-input"
                                                                   name="gateway" id="{{ $gateway->key }}"
                                                                   value="{{ $gateway->key }}" {{ $loop->first ? 'checked' : '' }}>
                                                            <label for="{{ $gateway->key }}"
                                                                   class="custom-control-label">
                                                                <i class="mdi mdi-credit-card-outline checkout-additional-options-checkbox-image"></i>
                                                                <div class="content-box">
                                                                    <div
                                                                        class="checkout-time-table-title-bar checkout-time-table-title-bar-city">
                                                                        {{ trans('front::messages.cart.internet-payment') }} {{ $gateway->name }}
                                                                    </div>
                                                                    <ul class="checkout-time-table-subtitle-bar">
                                                                        <li>
                                                                            {{ trans('front::messages.cart.online-with-cards') }}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>

                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </section>

                        </section>

                    </div>

                    @include('front::partials.checkout-sidebar')

                </div>
            </form>


            <div class="mt-5">
                <a href="{{ route('front.cart') }}" class="float-right border-bottom-dt"><i
                        class="mdi mdi-chevron-double-right"></i>{{ trans('front::messages.cart.return-to-cart') }}</a>
            </div>
        </div>
    </main>
    <!-- End main-content -->
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/vendor/wNumb.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/ResizeSensor.min.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/jquery.nice-select.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/localization/messages_fa.min.js') }}?v=2"></script>

    <script src="{{ theme_asset('js/pages/cart.js') }}?v=3"></script>
    <script src="{{ theme_asset('js/pages/checkout.js') }}?v=14"></script>
@endpush
