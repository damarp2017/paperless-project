<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'sender' => new StoreResource($this->store),
            'type' => $this->type,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'created_at' => $this->created_at->translatedFormat('l, d M Y H:i:s'),
        ];
    }
}
