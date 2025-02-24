<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Notification
 */
class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'title' => isset($this->data['title']) ? $this->data['title'] : __('translation.reminder'),
            'message' => $this->data['message'] ? $this->data['message'] : '',
            'read_at' => (string) $this->read_at,
            'is_read' =>  $this->is_read,
            'firebase_result' => $this->data['result'] ?? null,
            'created_at' => $this->created_at->format('Y-m-d'),
            'created_time' => $this->created_at->format('H:i:s'),
            'created_since' => $this->created_at->diffForHumans(),
        ];
    }
}
