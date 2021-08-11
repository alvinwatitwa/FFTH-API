<?php

namespace App\Http\Resources;

use App\Sponsorship;
use App\Http\Resources\Sponsorship as SponsorshipResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Crisis extends JsonResource
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
            'amount' => $this->amount,
            'frequency' => $this->frequency,
            'sponsorship' => new SponsorshipResource(Sponsorship::findOrfail($this->sponsor_id)),
        ];
    }
}
