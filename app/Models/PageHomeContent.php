<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageHomeContent extends Model
{
    protected $fillable = [
        'hero_image',
        'hero_title',
        'hero_paragraph_1',
        'hero_paragraph_2',
        'hero_paragraph_3',
        'about_title',
        'about_description',
        'about_image',
        'features_title',
        'features_description',
        'cta_title',
        'cta_description',
        'cta_button_text',
        'cta_button_link',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}

