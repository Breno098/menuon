<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property int $quantity
 * @property float $price
 * @property string|null $info
 * @property string|null $customer_notes
 * @property int|null $product_reference_id
 * @property int $order_id
 * @property BelongsTo|Order $order
 * @property HasOne|Product $product_reference
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'price',
        'info',
        'customer_notes',
        'order_id',
        'product_reference_id',
    ];

    protected $casts = [
        'price' => 'float',
    ];


    /**
     * Relationships
     */

    /**
     * @return HasOne|Product
     */
    public function productReference(): HasOne|Product
    {
        return $this->hasOne(Product::class, 'id', 'product_reference_id');
    }

    /**
     * @return BelongsTo|Order
     */
    public function order(): BelongsTo|Order
    {
        return $this->belongsTo(Order::class);
    }
}
