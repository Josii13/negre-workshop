<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageGalleryContent extends Model
{
    protected $fillable = [
        'banner_title',
        'banner_subtitle',
        'banner_description',
        'banner_quote',
        'banner_background',
        'gallery_name',
        'gallery_description',
        'gallery_image',
        'tab_atelier',
        'tab_activites',
        'tab_evenements',
        'tab_podcasts',
        'modal_details_title',
        'modal_label_type',
        'modal_label_frequency',
        'modal_label_capacity',
        'modal_label_audience',
        'modal_button_whatsapp',
        'whatsapp_message_template',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}

