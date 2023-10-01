<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $id
 * @property string $code
 * @property string $type
 * @property float $value
 * @property int $quantity
 */
class Coupon extends Model
{
    use HasFactory;

     /**
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'type',
        'value',
        'type',
        'quantity'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'float',
    ];
}
