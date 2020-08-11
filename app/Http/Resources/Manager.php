<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Manager extends JsonResource
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
            'user_name' => $this->user_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
