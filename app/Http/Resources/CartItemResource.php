<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product'=> [
                'id' => $this->product_id,
                'name' => $this->product_name,
                'price' => $this->product_price,
            ],
            'quantity' => $this->quantity,
            'total' => $this->product_price * $this->quantity,  
            'brand'      => $this->relationLoaded('brand') && !($this->brand->count() == 0) ? new BrandResource($this->brand) : null,
        ];
    }
}
