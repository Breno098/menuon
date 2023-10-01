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
 * @property float $price
 * @property float $manual_discount
 * @property BelongsTo|Customer $customer
 * @property HasOne|Address $deliveryAddress
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
        'price',
        'manual_discount'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
        'manual_discount' => 'float',
    ];


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
     * @return HasOne|Address
     */
    public function deliveryAddress(): HasOne|Address
    {
        return $this->hasOne(Address::class, 'delivery_address_id');
    }

    /**
     * @return HasMany|Collection<OrderItem>
     */
    public function items(): HasMany|Collection
    {
        return $this->hasMany(OrderItem::class);
    }
}
