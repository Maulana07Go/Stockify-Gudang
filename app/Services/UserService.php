<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getFilteredUsers($search = null)
    {
        return $this->userRepository->getFilteredUsers($search);
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}