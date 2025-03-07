<?php

namespace App\Services;

use App\Repositories\Interfaces\UserActivityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserActivityService
{
    protected $useractivityRepository;

    public function __construct(UserActivityRepositoryInterface $useractivityRepository)
    {
        $this->useractivityRepository = $useractivityRepository;
    }

    public function getAllUserActivities(): Collection
    {
        return $this->useractivityRepository->getAll();
    }

    public function getFilteredUserActivity($search = null)
    {
        return $this->useractivityRepository->getFilteredUserActivity($search);
    }

    public function getUserActivityById(int $id)
    {
        return $this->useractivityRepository->findById($id);
    }

    public function createUserActivity(array $data)
    {
        return $this->useractivityRepository->create($data);
    }

    public function updateUserActivity(int $id, array $data)
    {
        return $this->useractivityRepository->update($id, $data);
    }

    public function deleteUserActivity(int $id)
    {
        return $this->useractivityRepository->delete($id);
    }
}