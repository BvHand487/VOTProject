<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            "ownerId" => $this->owner_id,
            "ownerName" => User::find($this->owner_id)->name,
            "name"=> $this->name,

        ];
    }
}
