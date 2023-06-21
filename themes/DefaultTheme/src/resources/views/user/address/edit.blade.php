@extends('front::user.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/nice-select.css') }}">
@endpush

@section('user-content')
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
        <div class="px-3 px-res-0">
            <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                <h2>{{ trans('front::messages.user.edit-personal-information') }}</h2>
            </div>
            <div class="form-ui additional-info dt-sl dt-sn pt-4">
                <form id="profile-form" action="{{ route('front.address.update' , ['id' => $address->id]) }}" class="setting_form" method="POST">

                    <div class="row">
                        @php
                            if($address) {
                                $province_id = $address->province_id;
                                $cities = $address->province->cities;
                                $city_id = $address->city_id;
                            } else {
                                $province_id = null;
                                $cities = [];
                                $city_id = null;
                            }
                        @endphp

                        <div class="col-lg-6 mt-4">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.state') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <div class="custom-select-ui">
                                    <select class="right" name="province_id" id="province">
                                        <option value="">{{ trans('front::messages.user.select') }}</option>
                                        @foreach($provinces as $item)
                                            <option value="{{ $item->id }}" @if($item->id == $province_id) selected @endif>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.city') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <div class="custom-select-ui">
                                    <select class="right" name="city_id" id="city">
                                        <option value="">{{ trans('front::messages.user.select') }}</option>
                                        @foreach($cities as $item)
                                            <option value="{{ $item->id }}" @if($item->id == $city_id) selected @endif>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.postal-code') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <input type="text" class="input-ui pr-2" name="postal_code" value="{{ $address->postal_code }}">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="form-row-title">
                                <h4>
                                    {{ trans('front::messages.user.postal-address') }}
                                </h4>
                            </div>
                            <div class="form-row form-group">
                                <textarea name="address" class="input-ui pr-2 text-right" placeholder="{{ trans('front::messages.user.enter-recipient-address') }}">{{ $address->address }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-row mt-3 justify-content-center">
                        <button id="submit-btn" type="submit" class="btn-primary-cm btn-with-icon ml-2">
                            ساخت آدرس جدید
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/vendor/jquery.nice-select.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/localization/messages_fa.min.js') }}?v=2"></script>

    <script src="{{ theme_asset('js/pages/edit-profile.js?v=2') }}"></script>
@endpush
