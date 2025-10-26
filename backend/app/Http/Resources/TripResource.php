<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DestinationResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\StatusResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "departure_date" => $this->departure_date->format("d/m/Y"),
            "return_date" => $this->return_date->format("d/m/Y"),
            "created_at" => $this->created_at->format("d/m/Y H:i:s"),
            "updated_at" => $this->updated_at->format("d/m/Y H:i:s"),

            "destination" => new DestinationResource($this->whenLoaded('destination')),
            "status" => new StatusResource($this->whenLoaded('status')),
            "created_by" => new UserResource($this->whenLoaded('user')),
        ];
    }
}
