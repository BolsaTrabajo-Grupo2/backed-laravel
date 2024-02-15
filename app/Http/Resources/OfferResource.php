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
            'responsibleName' => $this->responsible_name,
            'inscriptionMethod' => $this->inscription_method,
            'status' => $this->status,
            'verified' => $this->verified,
            'CIF' => $this->CIF
        ];
    }
}
