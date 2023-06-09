@extends('back.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb no-border">
                                    <li class="breadcrumb-item">مدیریت
                                    </li>
                                    <li class="breadcrumb-item">لیست برند ها</li>
                                    <li class="breadcrumb-item active">دسته بندی های برند
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div id="save-changes" class="spinner-border text-success" role="status" style="display: none">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">ّ
                <!-- Categories -->
                <section id="description" class="card">
                    <div class="card-header">
                        <h4 class="card-title">مدیریت دسته بندی های برند</h4>
                    </div>
                    <div id="main-block" class="card-content">
                        <div class="card-body">
                            <!-- Categories -->
                            <div class="col-12 offset-xl-2">
                                <form id="create-category" action="{{ route('admin.brands.category.save') }}"
                                      method="POST"
                                      enctype='multipart/form-data'
                                >
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <input type="hidden" name="type" value="productcat">
                                            <div class="col-md-5 col-sm-10 col-10">
                                                <input id="title" type="text" class="form-control" name="title"
                                                       placeholder="افزودن عنوان دسته بندی جدید...">
                                                <br>
                                                <fieldset class="form-group">
                                                    <label>تصویر شاخص</label>
                                                    <div class="custom-file">
                                                        <input id="image" type="file" accept="image/*" name="image"
                                                               class="custom-file-input">
                                                        <label class="custom-file-label" for="image"></label>
                                                        <p><small>بهترین اندازه <span
                                                                    class="text-danger">600 * 600</span> پیکسل
                                                                میباشد.</small></p>
                                                    </div>
                                                </fieldset>

                                                <div class='form-group'>
                                                    <textarea name="description" id="description" cols="15"
                                                              class='form-control' rows="5"
                                                              placeholder='توضیحات دسته بندی برند را اینجا وارد کنید'></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                                    افزودن
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- List categories -->


                            @if($categories->count())
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="text-center">تصویر</th>
                                            <th>عنوان</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($categories as $category)
                                            <tr id="brand-{{ $category->id }}-tr">
                                                <td class="text-center">
                                                    <img class="post-thumb"
                                                         src="{{ $category->image ? asset($category->image) : asset('/empty.jpg') }}"
                                                         alt="image">
                                                </td>
                                                <td>
                                                        <span class="d-flex">
                                                            <span>{{ $category->name }}</span>
                                                            @if (Route::has('front.brands.category.show'))
                                                                <a href="{{ route('front.brands.category.show', ['slug' => $category->slug]) }}"
                                                                   target="_blank"><i
                                                                        class="feather icon-external-link ml-1"></i></a>
                                                            @endif
                                                        </span>
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('admin.brands.edit', ['brand' => $category]) }}"
                                                       class="btn btn-success mr-1 waves-effect waves-light">ویرایش</a>

                                                    <button type="button" data-id="{{ $category->id }}"
                                                            data-action="{{ route('admin.brands.destroy', ['brand' => $category]) }}"
                                                            class="btn btn-danger mr-1 waves-effect waves-light btn-delete"
                                                            data-toggle="modal" data-target="#delete-modal">حذف
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @else

                                <p>چیزی برای نمایش وجود ندارد!</p>

                            @endif
                            <!-- END List categories -->
                            <p class="card-text mt-3"><i class="feather icon-info mr-1 align-middle"></i><span
                                    class="text-info">برای ایجاد زیر دسته، دسته بندی مورد نظر را به  سمت چپ بکشید.</span>
                            </p>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade text-left" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف این دسته بندی تمامی زیر دسته های آن حذف خواهند شد، آیا برای حذف
                    مطمئن هستید؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر
                    </button>
                    <button id="confirm-delete" type="button" class="btn btn-danger waves-effect waves-light">بله حذف
                        شود
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Delete Modal -->

    <!-- Edit Modal -->
    <div class="modal fade text-left" id="modal-edit" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ویرایش دسته بندی </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit-form" action="#">
                    @method('put')
                    <div class="modal-body">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">
                            انصراف
                        </button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">ذخیره</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Edit Modal -->

@endsection
