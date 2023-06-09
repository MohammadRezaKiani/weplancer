<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandCategory;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function show(Brand $brand)
    {
        $products = $brand->products()
            ->published()
            ->orderByStock()
            ->latest()
            ->paginate(20);

        return view('front::brands.show', compact('brand', 'products'));
    }

    public function showCategory(Request $request)
    {
        $brandCategory = BrandCategory::where('slug' , $request->slug)->first();
        $listBrand = $brandCategory->brands()
            ->latest()
            ->paginate(20);

        return view('front::brands.category.show', compact('brandCategory', 'listBrand'));
    }
}
