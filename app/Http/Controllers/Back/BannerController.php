<?php

namespace App\Http\Controllers\Back;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Banner::class, 'banner');
    }

    public function index()
    {
        $banners = Banner::detectLang()->orderBy('ordering')->get();

        return view('back.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('back.banners.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'       => 'image|required|max:2048',
            'group'       => 'required',
            'title'       => 'nullable',
            'description' => 'nullable',
        ]);

        $file = $request->image;
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        Storage::disk('plocal')->put('uploads/banners/'.$filename, file_get_contents($file));

        if ($request->group == 'index_middle_banners'){
            $webpPath = $this->convertToWebp($file, 'uploads/banners', $filename , 837 , 400);
        }
        if ($request->group == 'index_slider_banners'){
            $webpPath = $this->convertToWebp($file, 'uploads/banners', $filename , 250 , 250);
        }

        Banner::create([
            'link'        => $request->link,
            'lang'        => app()->getLocale(),
            'group'       => $request->group,
            'published'   => $request->published ? true : false,
            'image'       => '/uploads/banners/' . $filename,
            'webp_image'       => $webpPath,
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        toastr()->success('بنر با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(Banner $banner)
    {
        return view('back.banners.edit', compact('banner'));
    }

    public function update(Banner $banner, Request $request)
    {
        $this->validate($request, [
            'image' => 'image|max:2048',
            'group' => 'required'
        ]);

        if ($request->hasFile('image')) {

            if ($banner->image) {
                Storage::disk('plocal')->delete($banner->image);
            }

            $file = $request->image;
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('plocal')->put('uploads/banners/'.$filename, file_get_contents($file));

            if ($request->group == 'index_middle_banners'){
                $webpPath = $this->convertToWebp($file, 'uploads/banners', $filename , 837 , 400);
            }
            if ($request->group == 'index_slider_banners'){
                $webpPath = $this->convertToWebp($file, 'uploads/banners', $filename , 856 , 428);
            }

            $banner->image = '/uploads/banners/' . $filename;
            $banner->webp_image = $webpPath;
            $banner->save();
        }

        $banner->update([
            'link'        => $request->link,
            'group'       => $request->group,
            'published'   => $request->published ? true : false,
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        toastr()->success('بنر با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('banners.update');

        $this->validate($request, [
            'banners' => 'required|array'
        ]);

        $i = 1;

        foreach ($request->banners as $banner) {
            Banner::findOrFail($banner)->update([
                'ordering' => $i++,
            ]);
        };

        return response('success');
    }

    private function convertToWebp($file, $directory, $filename , $width , $height)
    {
        $image = Image::make($file);
        $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        $webpPath = $directory . '/' . $webpFilename;
        $image->resize($width, $height, function ($constraint) {
            // Additional parameters to force exact dimensions
//            $constraint->upsize(); // Prevent upsizing of the image
//            $constraint->aspectRatio(); // Ignore aspect ratio
        });

        $image->encode('webp', option('image_optimization_percentage'))->save(public_path($webpPath));

        return $webpPath;
    }
}
