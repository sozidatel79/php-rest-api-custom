<?php


namespace App\Controllers\User;

use App\Helpers\JsonHelper;
use App\Repositories\TxtUserRepository;
use App\Services\UserService;



class User
{

    public function getAll()
    {
        $userService = new UserService(new TxtUserRepository());
        $users = $userService->getAll();
        echo $users;
    }

    public function getOne()
    {
        $body = file_get_contents('php://input');
        $userId = JsonHelper::jsonToArray($body);
        $userService = new UserService(new TxtUserRepository());
        $one = $userService->getOne($userId['id']);
        echo $one;
    }

    public function getUpdate()
    {

        $body = file_get_contents('php://input');
        $userId = JsonHelper::jsonToArray($body);
        $data = [
            'ip' => '10.0.0.10'
        ];
        $userService = new UserService(new TxtUserRepository());
        $userService->save($userId['id'], JsonHelper::arrayToJson($data));

        $one = $userService->getOne($userId['id']);
        echo $one;
    }

}