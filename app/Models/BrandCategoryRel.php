<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandCategoryRel extends Model
{
    use HasFactory;

    protected $table = 'brand_category_rel';

    protected $fillable = ['brand_id' , 'category_id'];
}
