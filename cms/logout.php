<?php

require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
require CLASS_PATH.'user.php';
require CLASS_PATH.'session.php';

$user= new User();
$session= new Session();

$user_id= $session->getSessionKeyValueByKey('user_id');

$data= array('api_token'=> null);

$user->updateUser($data, $user_id);
$session->destroySession();

redirect('./');