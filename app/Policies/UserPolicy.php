<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin'; // Hanya admin yang bisa melihat semua pengguna
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id || $user->role === 'admin'; // Hanya pemilik atau admin yang bisa memperbarui
    }
}
