<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\Attributes\Sluggable;

#[Sluggable(from: 'title', to: 'slug')]
#[Guarded(['id'])]
class Product extends Model implements HasMedia
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory ,InteractsWithMedia;

    protected $casts = [
        'variants' => 'array',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_spicy' => 'boolean',
        'is_vegetarian' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The price actually charged: the discount price when set, otherwise the regular price.
     *
     * @return Attribute<float, never>
     */
    protected function effectivePrice(): Attribute
    {
        return Attribute::make(
            get: fn (): float => (float) ($this->discount_price ?? $this->price),
        );
    }

    /**
     * Order the query by the effective price (discount price when set, otherwise the regular price).
     *
     * @param  Builder<Product>  $query
     * @return Builder<Product>
     */
    public function scopeOrderByEffectivePrice(Builder $query, string $direction = 'asc'): Builder
    {
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        return $query->orderByRaw("coalesce(discount_price, price) {$direction}");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->nonQueued()
            ->format('webp')
            ->quality(75);

        $this->addMediaConversion('thumb')
            ->nonQueued()
            ->format('webp')
            ->quality(50)
            ->fit(Fit::Max, 400, 400);
    }
}
