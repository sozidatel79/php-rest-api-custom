<?php

namespace App\Controllers\Auth;

use App\Services\UserService;
use App\Repositories\TxtUserRepository;

class Auth
{
    public function login()
    {

        $body = file_get_contents('php://input');
        $usr = json_decode($body);
        $userService = new UserService(new TxtUserRepository());

        $user = $userService->getByEmailAndPassword($usr->email, $usr->password);

            $data = [
                'online' => true,
                'visit_time' => date("Y-m-d H:i"),
                'visit_counter' => 'to_update',
                'user_agent'=> $_SERVER['HTTP_USER_AGENT'],
                'ip' => $_SERVER['REMOTE_ADDR']
            ];
            $json_data = json_encode($data);
            $userService->save($user['id'], $json_data);
            $userLoggedIn = $userService->getByEmailAndPassword($usr->email, $usr->password);
            echo json_encode($userLoggedIn);
    }

    public function logOut(): void
    {

        $body = file_get_contents('php://input');
        $usr = json_decode($body);
        $userService = new UserService(new TxtUserRepository());
        unset($_SESSION['UID']);
        $data = [
            'online' => false,
        ];
        $json_data = json_encode($data);
        $userService->save($usr->id, $json_data);
    }

}