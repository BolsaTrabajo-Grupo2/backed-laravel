<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->user->name,
            'CIF' => $this->module->cliteral,
            'dirección' => $this->address,
            'telefono' => $this->phone,
            'web' => $this->web,
        ];
    }
}
