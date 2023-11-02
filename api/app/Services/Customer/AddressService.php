<?php

namespace App\Services\Customer;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Support\Arr;

class AddressService 
{
    /**
     * @param Customer $customer
     * @param array $params
     * @return Address
     */
    public function updateOrCreate(Customer $customer, array $params = []): Address
    {
        return $customer->addresses()->updateOrCreate([
            'cep' => Arr::get($params, 'cep'),
            'street' => Arr::get($params, 'street'),
            'number' => Arr::get($params, 'number'),
            'district' => Arr::get($params, 'district'),
            'complement' => Arr::get($params, 'complement'),
            'city' => Arr::get($params, 'city'),
            'state' => Arr::get($params, 'state'),
            'country' => Arr::get($params, 'country', 'Brasil'),
        ], [
            'cep' => Arr::get($params, 'cep'),
            'street' => Arr::get($params, 'street'),
            'number' => Arr::get($params, 'number'),
            'district' => Arr::get($params, 'district'),
            'complement' => Arr::get($params, 'complement'),
            'city' => Arr::get($params, 'city'),
            'state' => Arr::get($params, 'state'),
            'country' => Arr::get($params, 'country', 'Brasil'),
        ]);
    }
}