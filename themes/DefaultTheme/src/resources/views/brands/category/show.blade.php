@extends('front::layouts.master', ['title' => $brandCategory->name])

@push('meta')
    <meta property="og:title" content="{{ $brandCategory->name }}" />
    {{--    <link rel="canonical" href="{{ route('front.brands.show', ['brand' => $brandCategory]) }}" />--}}
@endpush

@push('styles')
    .
@endpush
<style>
    .search-amazing-tab .product-card {
         padding-top: 0 !important;
    }
    .cat-brand-thumb {
        display: block;
        position: relative;
        overflow: hidden;
        margin-top: -13px;
    }

    .cat-brand-thumb img {
        display: block;
        /* height: 230px; */
        margin: 0 auto;
        max-width: 100%;
        object-fit: contain;
    }

    .cat-brand-title {
        height: 17px;
        margin: 0.75rem 0 0.125rem;
        font-size: 14px;
        font-weight: 700;
        overflow: hidden;
        position: relative;
    }

    }
</style>

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 search-card-res">
                    <!-- Start Content -->
                    <div class="title-breadcrumb-special dt-sl mb-3">
                        <div class="breadcrumb dt-sl">
                            <nav>
                                <a href="/">خانه</a>
                                <span>{{ $brandCategory->name }}</span>
                            </nav>
                        </div>
                    </div>
                    @if($listBrand->count())
                        <div class="dt-sl dt-sn px-0 search-amazing-tab">
                            <div class='row'>
                                <div class='col-12'>
                                    <div class='title-section' style='padding: 20px;font-weight: bold;font-size: 18px;'>
                                        <span>لیست برند های داخل دسته بندی {{$brandCategory->name}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 mx-0 px-res-0">
                                @foreach($listBrand as $brand)
                                    <div class='col-lg-2 col-md-2 col-sm-6'>

                                        <div class="product-card mb-2 mx-res-0">
                                            <a class="cat-brand-thumb"
                                               href="{{route('front.brands.show' , ['brand' => $brand->slug])}}">
                                                <img
                                                    data-src="{{ $brand->image ? asset($brand->image) : asset('/no-image-product.png') }}"
                                                    src="{{ theme_asset('images/600-600.png') }}"
                                                    alt="{{ $brand->title }}">
                                            </a>
                                            <div class="product-card-body text-center">
                                                <a href="{{route('front.brands.show' , ['brand' => $brand->slug])}}">
                                                    <h5 class="cat-brand-title">
                                                        {{ $brand->name }}
                                                    </h5>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                @endforeach
                            </div>
                        </div>
                    @else
                        @include('front::partials.empty')
                    @endif
                </div>
                <!-- End Content -->
            </div>

            @if ($brandCategory->description)
                <div class="row mt-2">
                    <div class="dt-sl dt-sn search-amazing-tab mb-3 mx-3">
                        <div class="row">
                            <div class="col-md-12 p-md-4">
                                {!! $brandCategory->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>
    <!-- End main-content -->

@endsection
