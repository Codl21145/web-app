<?php

class User {

    public int $id;
    public string $username;
    public string $password;
    public string $email;
    public string $name;

    public function __construct(string $username, string $password, string $email, string $name)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
    }


    //CRUD

    // create
    public function putJson($users)
    {
        file_put_contents(__DIR__ . '/users.json', json_encode($users, JSON_PRETTY_PRINT));
    }

    public function createUser($data)
    {
        $users = $this->getUsers();

        $data['id'] = rand(1000000, 2000000);

        $users[] = $data;

        $this->putJson($users);

        return $data;
    }

    // read
    public function getUsers()
    {
        return json_decode(file_get_contents(__DIR__ . '/users.json'), true);
    }


    // update
    public function updateUser($data, $id)
    {
        $updateUser = [];
        $users = $this->getUsers();
        foreach ($users as $i => $user) {
            if ($user['id'] == $id) {
                $users[$i] = $updateUser = array_merge($user, $data);
            }
        }

        $this->putJson($users);

        return $updateUser;
    }

    // delete
    public function deleteUser($id)
    {
        $users = $this->getUsers();

        foreach ($users as $i => $user) {
            if ($user['id'] == $id) {
                array_splice($users, $i, 1);
            }
        }

        $this->putJson($users);
    }


}

