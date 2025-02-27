<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'max_participants' => $this->max_participants,
            'status' => $this->status,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'organizer' => new UserResource($this->whenLoaded('user')),
            'participants_count' => $this->participants()->count(),
            'created_at' => $this->created_at,
        ];
    }
}
