<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int|null $id
 * @property int $quantity
 * @property float $price
 * @property string|null $info
 * @property string|null $customer_notes
 * @property int|null $product_id
 * @property int $order_id
 * @property-read float|null $total_price
 * @property BelongsTo|Order $order
 * @property HasOne|Product $product
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property BelongsToMany|Collection<Product> $additional
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
        'product_id',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Attributes
     */

    /**
     * @return float|null
     */
    public function getTotalPriceAttribute(): float|null
    {
        $total = $this->price;

        foreach ($this->additional as $add) {
            $total += $add->additional_price * $add->additional_quantity;
        }

        return (float) $total * $this->quantity;
    }

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

    /**
     * @return BelongsTo|Order
     */
    public function order(): BelongsTo|Order
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsToMany|Collection<Product>
     */
    public function additional(): BelongsToMany|Collection
    {
        return $this->belongsToMany(
            Product::class, 
            'additional_order_items',
            'order_item_id',
            'additional_product_id'
        )->withPivot([
            'additional_order_items.price as additional_price',
            'additional_order_items.quantity as additional_quantity'
        ]);
    }
}
