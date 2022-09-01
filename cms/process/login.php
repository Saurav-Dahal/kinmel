<?php

require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
require CLASS_PATH.'user.php';
require CLASS_PATH.'session.php';

$user= new User();
$session= new Session();
if (isset($_POST) && !empty($_POST)) {
	// debugger($_POST, true); 
	$username = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL);
	if (!$username) {
		redirect('../', 'error', 'Invalid Email Address.');
	}
	$password = sha1($username.$_POST['password']);
     /*getting data from database through username*/
     $user_info = $user->getUserByName($username);
      /*data retrived from database by making dynamic select query */
          // debugger($user_info, true);
      /*matching info retrived from database with info received from login page ie. username*/
     if ($user_info) {
         if ($user_info[0]->password == $password) {
         	if ($user_info[0]->roles != 'Customer' ) {
         		  // debugger($user_info);

         /*session is created if password and username matches*/		
                 $session->setSessionKeyValue('user_id', $user_info[0]->id);
                  $session->setSessionKeyValue('full_name', $user_info[0]->full_name);
                  $session->setSessionKeyValue('email_address', $user_info[0]->email_address);
                   
                   $token = generateRandomString();
                   $session->setSessionKeyValue('session_token', $token);
                      
           /*session portion ends here*/
                $data= array('api_token'=> $token,
                              'last_login'=> date('Y-m-d h.i.s A')  );
           		  $user->updateUser($data, $user_info[0]->id);
        
                 redirect('../dashboard', 'success','Welcome to Admin Panel.');
         	}else{
         		redirect('../', 'error', 'You do not have previlage to access admin panel.');
             }
         }else{
         	 redirect('../', 'error', 'Password does not match.');
         }
     }else{
     	redirect('../', 'error', 'User does not exist.');
     }
     /*matching info retrived from database with info received and created session.*/
}else{
	redirect('../', 'error', 'Unauthorised Access.' );
}
