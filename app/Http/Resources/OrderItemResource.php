<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'brand_id' => $this->brand_id,
            'product_name' => $this->product_name,
            'product_price' => $this->product_price,
            'product_image' => url($this->product_image),
            'quantity' => $this->quantity,
            'total_price'=>$this->total_price
        ];
    }
}
