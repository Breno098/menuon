<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property HasMany|Collection<ProductImage> $images
 * @property BelongsToMany|Collection<Product> $additional
 * @property BelongsToMany|Collection<FoodSession> $sessions
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;

     /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Relationships
     */

    /**
     * @return HasMany|Collection<ProductImage>
     */
    public function images(): HasMany|Collection
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @return BelongsToMany|Collection<Product>
     */
    public function additional(): BelongsToMany|Collection
    {
        return $this->belongsToMany(
            Product::class, 
            'additional_products',
            'product_id',
            'additional_product_id'
        )->withPivot([
            'price as additional_price',
            'maximum_quantity as additional_maximum_quantity'
        ]);
    }

     /**
     * @return BelongsToMany|Collection<FoodSession>
     */
    public function sessions(): BelongsToMany|Collection
    {
        return $this->belongsToMany(FoodSession::class);
    }
}
