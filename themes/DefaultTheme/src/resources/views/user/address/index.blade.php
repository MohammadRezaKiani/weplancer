@extends('front::user.layouts.master')

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">

        @if($address)

            <div class="row">
                <div class="col-12">
                    <div
                        class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                        <h2>لیست آدرس ها</h2>
                    </div>
                    <div class="dt-sl">
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>استان</th>
                                    <th>شهر</th>
                                    <th>کد پستی</th>
                                    <th>آدرس کامل</th>
                                    <th>{{ trans('front::messages.profile.details') }}</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($address as $addr)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ $addr->province->name}}</td>
                                        <td>{{ $addr->city->name}}</td>
                                        <td>{{ $addr->postal_code}}</td>
                                        <td>{{ $addr->address}}</td>
                                        <td>
                                            <a href='{{route('front.address.edit' , ['id' => $addr->id])}}'
                                               class='btn btn-success'>ویرایش</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="row">
                <div class="col-12">
                    <div class="page dt-sl dt-sn pt-3">
                        <p>{{ trans('front::messages.profile.there-nothing-show') }}</p>
                    </div>
                </div>
            </div>

        @endif
            <div class='add-new-addr-area mt-4 text-left'>
                <a href="{{route('front.address.create')}}" class='btn btn-primary'>افزودن آدرس جدید</a>
            </div>
    </div>
    <!-- End Content -->
@endsection
