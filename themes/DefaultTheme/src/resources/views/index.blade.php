@extends('front::layouts.master')

@push('meta')
    <meta name="description" content="{{ option('info_short_description') }}">
    <meta name="keywords" content="{{ option('info_tags') }}">

    <link rel="canonical" href="{{ url('/') }}" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "url": "{{ route('front.index') }}",
            "name": "{{ option('site_title') }}",
            "logo": "{{ option('info_logo') ? asset(option('info_logo')) : asset(config('front.asset_path') . 'img/logo.png') }}",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "{{ route('front.products.search') }}/?q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
@endpush
@section('content')
    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container-fluid main-container">
            @foreach ($widgets as $widget)
                @switch($widget->key)
                    @case('main-slider')
                        @include('front::widgets.main-slider')
                    @break

                    @case('products-default-block')
                        @include('front::widgets.products-default-block')
                    @break

                    @case('products-colorful-block')
                        @include('front::widgets.products-colorful-block')
                    @break

                    @case('middle-banners')
                        @include('front::widgets.middle-banners')
                    @break

                    @case('coworker-sliders')
                        @include('front::widgets.coworker-sliders')
                    @break

                    @case('sevices-sliders')
                        @include('front::widgets.sevices-sliders')
                    @break

                    @case('categories')
                        @include('front::widgets.categories')
                    @break

                    @case('posts')
                        @include('front::widgets.posts')
                    @break
                @endswitch
            @endforeach

        </div>

    </main>
    <!-- End main-content -->
@endsection

@push('scripts')
    @if (option('dt_index_popup_type') == 'image')
        <div id="image-popup-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <a href="{{ option('dt_index_popup_link') }}">
                            <div class="d-none d-md-block">
                                <img src="{{ asset(option('dt_index_popup_image')) }}" class="img-responsive w-100">
                            </div>
                            <div class="d-block d-md-none">
                                <img src="{{ asset(option('dt_index_popup_image_mobile')) }}" class="img-responsive w-100">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#image-popup-modal').modal('show');
        </script>
    @elseif (option('dt_index_popup_type') == 'text')
        <div id="text-popup-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <p>{!! option('dt_index_popup_text') !!}</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $('#text-popup-modal').modal('show');
        </script>
    @endif
@endpush
