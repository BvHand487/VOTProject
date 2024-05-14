<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            "userId" => $this->user_id,
            "userName" => User::find($this->user_id)->name,
            "text" => $this->text,
            "createdAt" => $this->created_at->format("Y-m-d H:i:s"),
        ];
    }
}
