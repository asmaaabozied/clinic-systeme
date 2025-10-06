<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // If your users table only has a 'name' field, split it for first/last name
        $nameParts = explode(' ', $this->name ?? '');
        return [
            'id' => $this->id,
            'first_name' => $this->first_name ?? ($nameParts[0] ?? ''),
            'last_name' => $this->last_name ?? ($nameParts[1] ?? ''),
            'email' => $this->email,
            'type' => $this->type,
            // Add more fields as needed by your React theme
        ];
    }
}
