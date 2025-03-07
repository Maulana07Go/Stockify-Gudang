<?php

namespace App\Repositories\Eloquent;

use App\Models\UserActivity;
use App\Repositories\Interfaces\UserActivityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserActivityRepository implements UserActivityRepositoryInterface
{
    public function getAll(): Collection
    {
        return UserActivity::all();
    }

    public function getFilteredUserActivity($search = null): LengthAwarePaginator
    {
        return userActivity::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('activity', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10);
    }

    public function findById(int $id): ?UserActivity
    {
        return UserActivity::find($id);
    }

    public function create(array $data): UserActivity
    {
        return UserActivity::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $useractivity = UserActivity::find($id);
        return $useractivity ? $useractivity->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $useractivity = UserActivity::find($id);
        return $useractivity ? $useractivity->delete() : false;
    }
}