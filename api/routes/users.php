<?php

require_once WWW_ROOT .DIRECTORY_SEPARATOR. 'Pusher.php';

$userDAO = new UserDAO();

$app->get('/users/?',function() use ($userDAO){
    header("Content-Type: application/json");
    echo json_encode($userDAO->selectAll(), JSON_NUMERIC_CHECK);
    exit();
});

$app->get('/users/:id/?',function($id) use ($userDAO){
    header("Content-Type: application/json");
    echo json_encode($userDAO->selectById($id), JSON_NUMERIC_CHECK);
    exit();
});

$app->get('/users/facebookids/:id/?',function($id) use ($userDAO){
    header("Content-Type: application/json");
    echo json_encode($userDAO->selectByFacebookId($id), JSON_NUMERIC_CHECK);
    exit();
});

$app->post('/users/?', function() use ($app, $userDAO){
    header("Content-Type: application/json");
    $post = $app->request->post();
    if(empty($post)){
        $post = (array) json_decode($app->request()->getBody());
    }

    if(!empty($post["device_id"])) {

        $existingUser = $userDAO->selectByDeviceId($post["device_id"]);

        if($existingUser) {
            //user reeds in database via device_id, maar nu ingelogd met facebook 
            if(empty($existingUser["facebook_id"]) && !empty($post["facebook_id"])) {
                echo json_encode($userDAO->updateToFacebookUser($existingUser["id"], $post), JSON_NUMERIC_CHECK);
                exit();
            //user reeds in database met facebookgegevens  
            } else {
                echo json_encode($existingUser, JSON_NUMERIC_CHECK);
                exit(); 
            }
        } else {
            //user nog niet in database en ingelogd met facebook
            if(!empty($post["facebook_id"])) {
                echo json_encode($userDAO->insertWithFacebookId($post), JSON_NUMERIC_CHECK);  
                exit();
            //user nog niet in database en enkel device_id
            } else {
                echo json_encode($userDAO->insertWithoutFacebookId($post), JSON_NUMERIC_CHECK);  
                exit();
            }
        }
    } else {
        echo json_encode(array("error" => "no DEVICE_ID given"));
        exit();
    }
});

$app->get('/users/missing/?',function() use ($userDAO){
    header("Content-Type: application/json");
    echo json_encode($userDAO->selectAllMissing(), JSON_NUMERIC_CHECK);
    exit();
});


$app->put('/users/missing/:id/?', function($id) use ($app, $userDAO){
    header("Content-Type: application/json");
    $post = $app->request->post();
    if(empty($post)){
        $post = (array) json_decode($app->request()->getBody());
    }

    $updatedUser = $userDAO->updateMissingByFacebookId($id, $post);

    if($updatedUser && $post["missing"] == 1) {

        ob_start();
        var_dump($updatedUser["name"]);
        error_log(ob_get_clean());

        $app_id = '122950';
        $app_key = '652067c9e368032c2208';
        $app_secret = 'b2db452b61f845046c79';

        $pusher = new Pusher($app_key, $app_secret, $app_id);

        $data['message'] = $updatedUser["name"] . ' vindt jou niet meer!';
        $event = $updatedUser["facebook_id"] . 'Missing';
        $pusher->trigger('MissingPeople', $event, $data);

    }

    echo json_encode($updatedUser, JSON_NUMERIC_CHECK);
    exit();
});

$app->delete('/users/:id/?', function($id) use ($userDAO){
    header("Content-Type: application/json");
    echo json_encode($userDAO->delete($id));
    exit();
});