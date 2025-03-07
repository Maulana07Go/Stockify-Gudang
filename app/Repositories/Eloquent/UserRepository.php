<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function getFilteredUsers($search = null): LengthAwarePaginator
    {
        return User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = User::find($id);
        if (!$user) {
            return false;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);
        return $user ? $user->delete() : false;
    }
}