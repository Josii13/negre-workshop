<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'dimensions',
        'technique',
        'support',
        'materials',
        'style',
        'collection',
        'sizes',
        'year',
        'is_available',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Relation avec la catégorie
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation avec les commandes
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope pour les produits disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope pour les produits en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope pour trier par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope pour filtrer par catégorie
     */
    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    /**
     * Accesseur pour le prix formaté
     */
    public function getFormattedPriceAttribute()
    {
        return $this->price ? number_format((float) $this->price, 0, ',', ' ') . ' FCFA' : null;
    }
}

