<?php

namespace App\Resources\Users;

use App\Models\User;

final class UserResource
{
    public static function transformToList(?User $user): array
    {
        if (!$user?->id) {
            return [];
        }

        return [
            'id' => $user->id,
            'login' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ];
    }

    public static function transformToShow(?User $user): array
    {
        if (!$user?->id) {
            return [];
        }

        return [
            'id' => $user->id,
            'login' => $user->login,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'status' => $user->status,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'photo' => $user->photo,
        ];
    }
}
