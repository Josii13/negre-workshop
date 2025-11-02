<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageDesignContent extends Model
{
    protected $fillable = [
        'banner_title',
        'banner_description',
        'banner_background',
        'intro_title',
        'intro_text',
        'grid_title',
        'grid_subtitle',
        'product_button_order',
        'detail_button_order',
        'detail_characteristics_title',
        'detail_label_dimensions',
        'detail_label_materials',
        'detail_label_finish',
        'detail_label_year',
        'order_title',
        'order_label_name',
        'order_label_email',
        'order_label_phone',
        'order_label_message',
        'order_button_submit',
        'order_button_whatsapp',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}

