<?php

namespace App\Repositories\Interfaces;

use App\Models\UserActivity;
use Illuminate\Support\Collection;

interface UserActivityRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?UserActivity;
    public function create(array $data): UserActivity;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}