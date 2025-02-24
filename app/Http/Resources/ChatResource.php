<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        // Ensure user() is authenticated and not null
        $currentUser = user();

        if (!$currentUser) {
            // If the user is not authenticated, return a specific error message
            return [
                'error' => __('translation.user_not_authenticated')
            ];
        }

        $otherUser = null;

        // Proceed if the current user is an employee
        if ($currentUser->user_type == \App\Enums\UserTypesEnum::EMPLOYEE->value) {
            // Check if the sender_id is not the current user's id
            if ($this->sender_id != $currentUser->id) {
                // Fetch the other user safely using sender_id
                $otherUser = User::find($this->sender_id); // Using find() returns null if user is not found
            }

            // If otherUser is found and has the proper user type, set the name
            if (isset($otherUser)) {
                if ($otherUser->user_type == \App\Enums\UserTypesEnum::ADMIN->value) {
                    $otherUser->name = __('translation.admin');
                } elseif ($otherUser->user_type == \App\Enums\UserTypesEnum::EMPLOYEE->value) {
                    $otherUser->name = __('translation.support_user');
                }
            }
        } else {
            // For other user types, set the otherUser from $this->otherUser
            $otherUser = $this->otherUser;
        }

        // Return the transformed data safely
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'channel' => $this->channel,
            'message' => $this->message,
            'is_read' => (bool) $this->is_read,
            'read_at' => (string) $this->read_at,
            // Ensure other_user is not null
            'other_user' => $otherUser !== null && $otherUser !== '-1' ? SimpleUserResource::make($otherUser) : null,
            'other_user_id' => $otherUser !== null && $otherUser !== '-1' ? $otherUser?->id : null,
            'other_user_image' => $otherUser !== null && $otherUser !== '-1' ? $otherUser?->avatar_url : default_avatar(),
            'created_since' => $this->created_at->diffForHumans(),
            'time' => $this->created_at->format('H:i'),
        ] + ($this->unread_message_count !== null ? ['unread_message_count' => $this->unread_message_count] : []);
    }
}
