<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Province;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function list(Request $request)
    {
        if (!is_null($request->user()->address)){
            $address = $request->user()->address->latest()->paginate(20);
        }else{
            $address = null;
        }
        return view('front::user.address.index', compact('address'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $provinces = Province::all();

        return view('front::user.address.create', compact('user', 'provinces'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'province_id'  => 'required|exists:provinces,id',
            'city_id'      => 'required|exists:cities,id',
            'postal_code' => 'required|numeric|digits:10',
            'address'      => 'required|string|max:300',
        ]);

        auth()->user()->address()->create([
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
        ]);
        return response('success');
    }

    public function edit(Request $request)
    {
        $address = Address::find($request->id);
        $user = auth()->user();
        $provinces = Province::all();

        return view('front::user.address.edit', compact('user', 'provinces', 'address'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'province_id'  => 'required|exists:provinces,id',
            'city_id'      => 'required|exists:cities,id',
            'postal_code' => 'required|numeric|digits:10',
            'address'      => 'required|string|max:300',
        ]);
        $address = Address::find($request->id);
        $address->update([
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
        ]);
        return response('success');

    }
}
