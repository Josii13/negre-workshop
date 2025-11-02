<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModalContent extends Model
{
    protected $fillable = [
        // Modal Details
        'detail_characteristics_title',
        'detail_button_order',
        'detail_button_reserve',
        
        // Modal Order
        'order_title',
        'order_label_name',
        'order_label_email',
        'order_label_phone',
        'order_label_message',
        'order_button_submit',
        
        // Messages
        'success_message',
        'success_submessage',
        'loading_title',
        'loading_message',
    ];
    
    /**
     * Get the single instance (singleton pattern)
     */
    public static function content()
    {
        return static::first() ?? new static();
    }
}
