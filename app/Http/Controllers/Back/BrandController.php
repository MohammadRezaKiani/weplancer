<?php

namespace App\Http\Controllers\Back;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:products.brands');
    }

    public function index()
    {
        $brands = Brand::detectLang()->latest()->paginate(10);

        return view('back.brands.index', compact('brands'));
    }

    public function create()
    {

        $categories = BrandCategory::all();
        return view('back.brands.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'lang' => app()->getLocale(),
            'slug' => 'required|unique:brands,slug',
            'description' => 'nullable|string',
            'image' => 'image|max:2048',
            'category_id' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->image;
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $request->image->storeAs('brands', $name);

            $data['image'] = '/uploads/brands/' . $name;
        }

        $brand = Brand::create($data);
        $brand->categories()->sync($data['category_id']);

        toastr()->success('برند با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(Brand $brand)
    {
        $categories = BrandCategory::all();
        return view('back.brands.edit', compact('brand' , 'categories'));
    }

    public function update(Brand $brand, Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $brand->id,
            'description' => 'nullable|string',
            'category_id' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $file = $request->image;
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $request->image->storeAs('brands', $name);

            $data['image'] = '/uploads/brands/' . $name;
        }

        $brand->update($data);
        $brand->categories()->sync($data['category_id']);


        toastr()->success('برند با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        return response('success');
    }

    public function ajax_get(Request $request)
    {
        if ($request->term) {
            $brands = Brand::where('name', 'like', '%' . $request->term . '%')->pluck('name')->toArray();

            return $brands;
        }
    }

    public function category(Request $request)
    {
        $categories = BrandCategory::latest()->get();
        return view('back.brands.category.categories', compact('categories'));
    }

    public function saveCategory(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|unique:brand_category,name',
            'description' => 'nullable|string'
        ]);

        $brandCategory = new BrandCategory();
        $brandCategory->name = $request->title;
        $brandCategory->slug = str_replace(' ', '-', $request->title);
        if ($request->image) {
            $brandCategory->image = $this->uploadImage($request->file('image'));
        }
        if ($request->has('description')) {
            $brandCategory->description = $request->description;

        }

        $brandCategory->save();


        toastr()->success('برند با موفقیت ایجاد شد.');

        return back();
    }


    public function uploadImage($image)
    {
        $file = $image;
        $name = uniqid() . '_' . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/products'), $name);
        return '/uploads/products/' . $name;
    }
}
