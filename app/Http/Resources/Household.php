<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Household extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'country' => $this->country,
            'phone_number' => $this->phone_number,
            'members' => HouseholdMember::collection($this->whenLoaded('members')),
        ];
    }
}
