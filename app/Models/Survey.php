<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Survey extends Model
{
    use HasFactory , HasSlug;

    protected $fillable = [
        'title',
        'user_id',
        'image',
        'status',
        'description',
        'expire_data',
        'slug'
    ];

    public function getSlugOptions()
    {
        return SlugOptions::create()->generateSlugsFrom('tittle')->saveSlugsTo('slug');
    }

}
