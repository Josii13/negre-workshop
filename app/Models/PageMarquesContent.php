<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageMarquesContent extends Model
{
    protected $fillable = [
        'banner_default_description',
        'banner_background',
        'intro_title',
        'intro_text',
        'grid_title',
        'grid_subtitle',
        'product_button_whatsapp',
        'detail_button_whatsapp',
        'detail_characteristics_title',
        'detail_label_material',
        'detail_label_color',
        'detail_label_brand',
        'detail_label_availability',
        'order_title',
        'order_label_name',
        'order_label_email',
        'order_label_phone',
        'order_label_message',
        'order_button_submit',
        'order_button_whatsapp',
        'whatsapp_message_template',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}

