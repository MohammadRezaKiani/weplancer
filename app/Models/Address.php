<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
//    protected $guarded = ['id'];
    protected $fillable = ['province_id', 'city_id', 'postal_code', 'address'];

    public function province()
    {
        return $this->belongsTo(Province::class)->withTrashed();
    }

    public function city()
    {
        return $this->belongsTo(City::class)->withTrashed();
    }
}
