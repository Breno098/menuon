<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int|null $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $cellphone
 * @property HasMany|Collection<Address> $addresses
 * @property HasMany|Collection<Order> $orders
 * @property BelongsToMany|Collection<Coupon> $coupons
 * @property BelongsToMany|Collection<Product> $shoppingCart
 */
class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cellphone'
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationships
     */

    /**
     * @return HasMany|Collection<Address>
     */
    public function addresses(): HasMany|Collection
    {
        return $this->hasMany(Address::class);
    }

     /**
     * @return BelongsToMany|Collection<Coupon>
     */
    public function coupons(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Coupon::class);
    }

    /**
     * @return BelongsToMany|Collection<Product>
     */
    public function shoppingCart(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Product::class, 'shopping_cart');
    }

    /**
     * @return HasMany|Collection<Order>
     */
    public function orders(): HasMany|Collection
    {
        return $this->hasMany(Order::class);
    }
}
