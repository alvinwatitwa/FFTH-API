<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Child extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'Country' => $this->Country,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'photo' => $this->photo,
            'hobbies' => $this->hobbies,
            'history' => $this->history,
            'support_amount' => $this->support_amount,
            'frequency' => $this->frequency,
            'household_id' => $this->household_id,
        ];
    }
}
