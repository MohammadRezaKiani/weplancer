<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandCategory extends Model
{
    use HasFactory;

    protected $table = 'brand_category';

    protected $fillable = ['name' , 'slug' , 'image' , 'description' , 'lang'];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_category_rel', 'category_id', 'brand_id')->withTimestamps();
    }
}
