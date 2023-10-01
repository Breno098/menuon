<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $id
 * @property string|null $title
 * @property string $path
 * @property Product $product
 */
class ProductImage extends Model
{
    use HasFactory;

     /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'path',
    ];


    /**
     * Relationships
     */

    /**
     * @return BelongsTo|Product
     */
    public function product(): BelongsTo|Product
    {
        return $this->belongsTo(Product::class);
    }
}
