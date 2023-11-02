<?php

namespace App\Http\Resources\Customer\Order;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryAddress extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Address */
        $address = $this->resource;

        return [
            'cep' => $address->cep,
            'street' => $address->street,
            'number' => $address->number,
            'district' => $address->district,
            'complement' => $address->complement,
            'city' => $address->city,
            'state' => $address->state,
            'country' => $address->country,
        ];
    }
}
