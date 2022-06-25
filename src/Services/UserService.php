<?php


namespace App\Services;


use App\Controllers\User\User;
use App\Repositories\UserRepositoryInterface;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->find();
    }

    public function getOne($id)
    {
        return $this->userRepository->findOne($id);
    }

    public function save($id, $data)
    {
        $this->userRepository->save($id, $data);
    }

    public function getByEmailAndPassword($email, $password)
    {
        return $this->userRepository->findByEmailAndLogin($email, $password);
    }
}