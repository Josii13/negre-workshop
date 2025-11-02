<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContactContent extends Model
{
    protected $fillable = [
        'banner_title',
        'banner_description',
        'banner_background',
        'info_title',
        'info_email',
        'info_phone',
        'info_address',
        'info_city',
        'info_country',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'social_linkedin',
        'form_title',
        'form_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}

