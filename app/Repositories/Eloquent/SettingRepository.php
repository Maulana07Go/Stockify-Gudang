<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    public function getAll(): Collection
    {
        return Setting::all();
    }

    public function findById(int $id): ?Setting
    {
        return Setting::find($id);
    }

    public function create(array $data): Setting
    {
        return Setting::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $setting = Setting::find($id);
        return $setting ? $setting->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $setting = Setting::find($id);
        return $setting ? $setting->delete() : false;
    }
}