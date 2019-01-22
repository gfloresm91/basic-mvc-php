<?php

namespace App\Services;

use App\Models\User;


class UserService
{
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
