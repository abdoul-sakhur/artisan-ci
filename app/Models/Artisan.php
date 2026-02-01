<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Artisan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_slug',
        'shop_description',
        'shop_logo',
        'shop_banner',
        'is_approved',
        'approved_at',
        'approved_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Bootstrap the model.
     *
     * Listen for the creating event and set the shop slug if it is empty.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artisan) {
            if (empty($artisan->shop_slug)) {
                $artisan->shop_slug = Str::slug($artisan->shop_name);
            }
        });
    }

        /**
         * Get the user associated with the artisan.
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Return the user who approved the artisan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

        /**
         * Scope a query to only include approved artisans.
         *
         * @param \Illuminate\Database\Eloquent\Builder $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

        /**
         * Scope a query to only include pending artisans.
         *
         * @param \Illuminate\Database\Eloquent\Builder $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Approve an artisan.
     *
     * @param \App\Models\User $admin
     * @return void
     */
    public function approve(User $admin)
    {
        $this->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => $admin->id,
        ]);
    }

    /**
     * Rejetter l'artiste et remet à zéro les champs is_approved, approved_at et approved_by.
     *
     * @return void
     */
    public function reject()
    {
        $this->update([
            'is_approved' => false,
            'approved_at' => null,
            'approved_by' => null,
        ]);
    }

    /**
     * Accessor for `logo_url` to resolve storage path or external URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (empty($this->shop_logo)) {
            return null;
        }
        if (str_starts_with($this->shop_logo, 'http://') || str_starts_with($this->shop_logo, 'https://')) {
            return $this->shop_logo;
        }
        return asset('storage/' . ltrim($this->shop_logo, '/'));
    }

    /**
     * Accessor for `banner_url` to resolve storage path or external URL.
     */
    public function getBannerUrlAttribute(): ?string
    {
        if (empty($this->shop_banner)) {
            return null;
        }
        if (str_starts_with($this->shop_banner, 'http://') || str_starts_with($this->shop_banner, 'https://')) {
            return $this->shop_banner;
        }
        return asset('storage/' . ltrim($this->shop_banner, '/'));
    }
}

