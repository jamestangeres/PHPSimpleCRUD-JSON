<?php

function getUsers()
{
    return json_decode(file_get_contents(__DIR__ . '/users.json'), true);
}

function getUserById($id)
{
    $users = getUsers();
    foreach ($users as $user) {
        # code...
        if ($user['id'] == $id) {
            return $user;
        }
    }

    return;
}

function createUser($data)
{
    $users = getUsers();

    $data['id'] = rand(1000, 2000);

    $users[] = $data;

    // store new user to json file
    putJson($users);

    return $data;
}

function updateUser($data, $id)
{
    $updateUser = [];
    $users = getUsers();
    foreach ($users as $i => $user) {

        # code...
        if ($user['id'] == $id) {
            $users[$i] = $updateUser = array_merge($user, $data);
        }
    }

    putJson($users);

    return $updateUser;
}

function deleteUser($id)
{
    $users = getUsers();

    foreach ($users as $i => $user) {
        # code...
   
        if ($user['id'] == $id){
            // unset($users[$i]);
            //remove selected elements in an array
            array_splice($users, $i, 1);
        }
    }

    putJson($users);
}

function uploadImage($file, $user)
{

    if ( isset($_FILES['picture']) && $_FILES['picture']['name']) {
        // check if folder is exist 
        if (!is_dir(__DIR__ . "/images")) {
            mkdir(__DIR__ . "/images");
        }

        // get the file extension from the filename
        $fileName = $file['name'];

        // search for the dot in the filename
        $dotPosition = strpos($fileName, '.');
        // take the substring from the dot position till the end of the string
        $extension = substr($fileName, $dotPosition + 1);

        move_uploaded_file($file['tmp_name'], __DIR__ . "/images/${user['id']}.$extension");

        $user['extension'] = $extension;
        updateUser($user, $user['id']);
    }
}

function putJson($users)
{
    file_put_contents(__DIR__ . '/users.json', json_encode($users, JSON_PRETTY_PRINT));
}

function validateUser()
{
}
