<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'duration' => $this->duration,
            'responsibleName' => $this->responsibleName,
            'inscriptionMethod' => $this->inscriptionMethod,
            'status' => $this->status,
        ];
    }
}
