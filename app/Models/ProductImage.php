<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
        'thumbnail_path',
        'file_size',
        'mime_type',
        'is_primary',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'file_size' => 'integer',
        ];
    }

    // Relations
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Accessors pour les URLs
    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->path ? asset('storage/'.$this->path) : null,
        );
    }

    public function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->thumbnail_path ? asset('storage/'.$this->thumbnail_path) : null,
        );
    }

    // Compatibilité: $image->image_url dans les vues
    public function getImageUrlAttribute(): ?string
    {
        return $this->path ? asset('storage/'.$this->path) : null;
    }

    // Compatibilité: $image->thumbnail_url dans les vues
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? asset('storage/'.$this->thumbnail_path) : null;
    }

    // Accesseur pour la taille formatée
    public function formattedSize(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->file_size) {
                    return null;
                }

                $units = ['B', 'KB', 'MB', 'GB'];
                $size = $this->file_size;
                $unitIndex = 0;

                while ($size >= 1024 && $unitIndex < count($units) - 1) {
                    $size /= 1024;
                    $unitIndex++;
                }

                return round($size, 2) . ' ' . $units[$unitIndex];
            }
        );
    }
}

