<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'message',
        'product_name',
        'product_price',
        'status',
        'order_channel',
        'admin_notes',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
    ];

    /**
     * Relation avec le produit
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope pour les commandes en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les commandes confirmées
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope pour les commandes complétées
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Accesseur pour le prix formaté
     */
    public function getFormattedPriceAttribute()
    {
        return $this->product_price ? number_format($this->product_price, 0, ',', ' ') . ' FCFA' : null;
    }
}

