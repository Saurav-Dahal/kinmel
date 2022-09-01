<?php

require CLASS_PATH.'session.php';
require CLASS_PATH.'user.php';
$session = new Session();
$user = new User();

if (isset($_SESSION['session_token']) && !empty($_SESSION['session_token'])) {
	// debugger($_SESSION);
      $user_info = $user->getUserByToken($session->getSessionKeyValueBykey('session_token'));
        // debugger($user_info);
        if (!$user_info) {
        	redirect('logout');
        }else{
            if($session->getSessionKeyValueBykey('user_id') != $user_info[0]->id){
            	redirect('logout');
            }
        }
}else{
	redirect('./', 'warning', 'Please Login First.');
 }
