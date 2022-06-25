<?php


namespace App\Repositories;

use App\Controllers\User\User;

interface UserRepositoryInterface
{
    public function findOne(int $id);
    public function find();
    public function save(int $id, $data);
    public function findByEmailAndLogin(string $email, string $password);
}