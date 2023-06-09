<?php

namespace App\Models;

use App\Traits\Languageable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Sluggable, Languageable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug',
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->belongsToMany(BrandCategory::class, 'brand_category_rel', 'brand_id', 'category_id')->withTimestamps();
    }
}
