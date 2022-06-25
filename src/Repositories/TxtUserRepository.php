<?php

namespace App\Repositories;


class TxtUserRepository implements UserRepositoryInterface
{

    private $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/users.db.json';
    }

    public function find()
    {
        return  file_get_contents($this->file);
    }

    public function findOne($id)
    {
        $one = [];
        $users = file_get_contents($this->file);
        $decoded = json_decode($users, true);
        foreach ($decoded as $key => $value) {
            if ($value['id'] == $id) {
                $one = $value;
            }
        }
        $_SESSION['json_user'] = $one;
        return json_encode($one);
    }

    public function save($id, $data)
    {
        $update_data = json_decode($data);
        $jsonString = file_get_contents($this->file);
        $data = json_decode($jsonString, true);

        foreach ($data as $key => $value) {
            if ($value['id'] == $id) {
                $data[$key]['online'] = isset($update_data->online) ? $update_data->online : $data[$key]['online'];
                $data[$key]['name'] = isset($update_data->name) ? $update_data->name : $data[$key]['name'];
                $data[$key]['email'] = isset($update_data->email) ? $update_data->email : $data[$key]['email'];
                $data[$key]['user_agent'] = isset($update_data->user_agent) ? $update_data->user_agent : $data[$key]['user_agent'];
                $data[$key]['ip'] = isset($update_data->ip) ? $update_data->ip : $data[$key]['ip'];
                $data[$key]['password'] = isset($update_data->password) ? $update_data->password : $data[$key]['password'];
                $data[$key]['visit_time'] = isset($update_data->visit_time) ? $update_data->visit_time : $data[$key]['visit_time'];
                $data[$key]['visit_counter'] = isset($update_data->visit_counter) ? $data[$key]['visit_counter'] += 1 : $data[$key]['visit_counter'];
            }
        }
        $newJsonString = json_encode($data);
        file_put_contents($this->file, $newJsonString);
    }

    public function findByEmailAndLogin($email, $password)
    {

        $one = [];
        $users = file_get_contents($this->file);
        $decoded = json_decode($users, true);
        foreach ($decoded as $key => $value) {
            if ($value['email'] === $email && $value['password'] === $password) {
                $one = $value;
            }
        }
        $_SESSION['json_user'] = $one;
        return $one;
    }
}