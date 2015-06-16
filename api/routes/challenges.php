<?php

$challengeDAO = new ChallengeDAO();

$app->get('/challenges/?',function() use ($challengeDAO){
    header("Content-Type: application/json");
    echo json_encode($challengeDAO->selectAll(), JSON_NUMERIC_CHECK);
    exit();
});

$app->get('/challenges/:id/?',function($id) use ($challengeDAO){
    header("Content-Type: application/json");
    echo json_encode($challengeDAO->selectByChallengeId($id), JSON_NUMERIC_CHECK);
    exit();
});

$app->get('/challenges/devices/:device_id/?',function($device_id) use ($challengeDAO){
    header("Content-Type: application/json");
    echo json_encode($challengeDAO->selectByDeviceId($device_id), JSON_NUMERIC_CHECK);
    exit();
});

$app->post('/challenges/?', function() use ($app, $challengeDAO){
    header("Content-Type: application/json");
    $post = $app->request->post();
    if(empty($post)){
        $post = (array) json_decode($app->request()->getBody());
    }

    $existingChallenge = $challengeDAO->selectByDeviceIdAndChallengeId($post["device_id"], $post["challenge_id"]);

    if(empty($existingChallenge)) {
        echo json_encode($challengeDAO->insert($post), JSON_NUMERIC_CHECK);
        exit();
    } else {
        echo json_encode($challengeDAO->update($existingChallenge["id"], $post), JSON_NUMERIC_CHECK);
        exit();
    }
    
});

$app->delete('/challenges/:id/?', function($id) use ($challengeDAO){
    header("Content-Type: application/json");
    echo json_encode($challengeDAO->delete($id));
    exit();
});