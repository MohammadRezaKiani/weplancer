<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Slider::class, 'slider');
    }

    public function index()
    {
        $sliders = Slider::detectLang()->orderBy('ordering')->get();

        return view('back.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('back.sliders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|required|max:2048',
            'group' => 'required'
        ]);

        $file = $request->image;
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        // Save the image file to the 'plocal' disk
        Storage::disk('plocal')->put('uploads/sliders/'.$filename, file_get_contents($file));

        if ($request->group == 'main_sliders'){
            $webpPath = $this->convertToWebp($file, 'uploads/sliders', $filename , 1780 , 890);
        }
        if ($request->group == 'mobile_sliders'){
            $webpPath = $this->convertToWebp($file, 'uploads/sliders', $filename , 658 , 436);
        }
        if ($request->group == 'coworker_sliders'){
            $webpPath = $this->convertToWebp($file, 'uploads/sliders', $filename , 150 , 150);
        }
        if ($request->group == 'sevices_sliders'){
            $webpPath = $this->convertToWebp($file, 'uploads/sliders', $filename , 60 , 60);
        }

        Slider::create([
            'title'       => $request->title,
            'link'        => $request->link,
            'group'       => $request->group,
            'description' => $request->description,
            'published'   => $request->published ? true : false,
            'image'       => '/uploads/sliders/' . $filename,
            'webp_image'       => $webpPath,
            'lang'        => app()->getLocale(),
        ]);

        toastr()->success('اسلایدر با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(Slider $slider)
    {
        return view('back.sliders.edit', compact('slider'));
    }

    public function update(Slider $slider, Request $request)
    {
        $this->validate($request, [
            'image' => 'image|max:2048',
            'group' => 'required'
        ]);

        if ($request->hasFile('image')) {

            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }

            $file = $request->image;
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            // Save the image file to the 'plocal' disk
            Storage::disk('plocal')->put('uploads/sliders/'.$filename, file_get_contents($file));

            if ($request->group == 'main_sliders'){
                $webpPath = $this->convertToWebp($file, 'uploads/sliders', $filename , 1780 , 890);
            }
            elseif ($request->group == 'mobile_sliders'){
                $webpPath = $this->convertToWebp($file, 'uploads/sliders', $filename , 658 , 436);
            }
            elseif ($request->group == 'coworker_sliders'){
                $webpPath = $this->convertToWebp($file, 'uploads/sliders', $filename , 150 , 150);
            }
            elseif ($request->group == 'sevices_sliders'){
                $webpPath = $this->convertToWebp($file, 'uploads/sliders', $filename , 60 , 60);
            }
            else{
                $webpPath = $slider->webp_image;
            }
        }

        $slider->update([
            'title'       => $request->title,
            'link'        => $request->link,
            'group'       => $request->group,
            'description' => $request->description,
            'published'   => $request->published ? true : false,
            'image' => '/uploads/sliders/' . $filename,
            'webp_image' => $webpPath
        ]);

        toastr()->success('اسلایدر با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('sliders.update');

        $this->validate($request, [
            'sliders' => 'required|array'
        ]);

        $i = 1;

        foreach ($request->sliders as $slider) {
            Slider::findOrFail($slider)->update([
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
