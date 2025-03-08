<?php

namespace App\Repositories\Interfaces;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

interface SettingRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Setting;
    public function create(array $data): Setting;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}