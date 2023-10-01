<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int|null $id
 * @property string $title
 * @property string|null $description
 * @property string|null $image
 * @property BelongsToMany|Collection<Product> $products
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FoodSession extends Model
{
    use HasFactory;

     /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [];


    /**
     * Relationships
     */

    /**
     * @return BelongsToMany|Collection<Product>
     */
    public function products(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Product::class);
    }
}
