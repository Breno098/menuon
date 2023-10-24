<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int|null $id
 * @property string $status
 * @property string $payment_method
 * @property float $manual_discount
 * @property-read float|null $price
 * @property BelongsTo|Customer $customer
 * @property BelongsTo|Address $deliveryAddress
 * @property HasMany|Collection<OrderItem> $items
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Order extends Model
{
    use HasFactory;

     /**
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'payment_method',
        'manual_discount'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'manual_discount' => 'float',
    ];

    /**
     * Attributes
     */

    /**
     * @return float|null
     */
    public function getPriceAttribute(): float|null
    {
        return $this->items->sum(function(OrderItem $item)  {
            return (float) $item->price * $item->quantity;
        });
    }

    /**
     * Relationships
     */

    /**
     * @return BelongsTo|Customer
     */
    public function customer(): BelongsTo|Customer
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return BelongsTo|Address
     */
    public function deliveryAddress(): BelongsTo|Address
    {
        return $this->belongsTo(Address::class, 'delivery_address_id');
    }

    /**
     * @return HasMany|Collection<OrderItem>
     */
    public function items(): HasMany|Collection
    {
        return $this->hasMany(OrderItem::class);
    }


}
