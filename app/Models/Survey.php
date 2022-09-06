<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Survey extends Model
{
    use HasFactory , HasSlug;

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_SELECT = 'select';
    const TYPE_RADIO= 'radio';
    const TYPE_CHECKBOX = 'checkbox';

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
    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class,'survey_id');
    }

}
