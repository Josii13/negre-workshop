<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read',
        'admin_response',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Scope pour les messages non lus
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope pour les messages lus
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Marquer comme lu
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}

