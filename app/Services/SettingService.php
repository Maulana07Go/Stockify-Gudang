<?php

namespace App\Services;

use App\Repositories\Interfaces\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SettingService
{
    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getAllSettings(): Collection
    {
        return $this->settingRepository->getAll();
    }

    public function getSettingById(int $id)
    {
        return $this->settingRepository->findById($id);
    }

    public function createSetting(array $data)
    {
        return $this->settingRepository->create($data);
    }

    public function updateSetting(int $id, array $data)
    {
        return $this->settingRepository->update($id, $data);
    }

    public function deleteSetting(int $id)
    {
        return $this->settingRepository->delete($id);
    }
}