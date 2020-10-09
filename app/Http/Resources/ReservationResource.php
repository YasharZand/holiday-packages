<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PackageResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "reserve_date" => $this->reserve_date,
            "guests" => $this->guests,
            "user_id" => $this->user_id,
            "package_id" => $this->package_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at

        ];
    }
}
