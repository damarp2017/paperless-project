<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function Aws\boolean_value;

class InvitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (is_null($this->status)){
            $status = null;
        } else {
            $status = (int)$this->status ? true : false;
        }

        return [
            'id' => $this->id,
            'requested_by_store' => [
                'id' => $this->store->id,
                'name' => $this->store->name,
                'store_logo' => $this->store->store_logo
            ],
            'to' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'role' => (int)$this->role,
            'status' => $status,
            'invited_at' => $this->created_at->diffForHumans()
        ];
    }
}
