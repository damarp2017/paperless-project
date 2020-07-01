<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreWithProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'store_logo' => $this->store_logo,
            'description' => $this->description,
            'email' => $this->email,
            'products' => ProductOnlyResource::collection($this->product)
        ];
    }
}
