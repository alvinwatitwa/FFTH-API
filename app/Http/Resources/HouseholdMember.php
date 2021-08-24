<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class HouseholdMember extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'household_id' => $this->household_id,
            'household_head' => $this->household_head,
        ];
    }
}
