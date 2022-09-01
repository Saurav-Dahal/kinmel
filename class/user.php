
<?php

class User extends Database{

	public function __construct(){
		Database::__construct();
		$this->table('users');
	}

	public function getUserByName($username){
		$cond= array(
                      'fields' => 'id, full_name, email_address, password, roles',
                        
                      'where'=> array(
                                      'email_address' => $username,
                                      'status' =>'Active'

                                  )
                     );
              return $this->select($cond, true);
			}

     public function getUserByToken($token) {
      $cond= array( 
                  'where' => array( 'api_token' => $token)
                    );
         return $this->select($cond);
     }
    
    public function updateUser($data, $id, $is_die= false){
        $cond = array(
 
                    'where' => array  ('id'=> $id)
                     );
    return $this->update($data, $cond, $is_die); 
    }

    public function getAllVendor($is_die= false){
      $cond= array(
                    'where' => array('roles' => 'Vendor' )
                  );
      return $this->select($cond, $is_die);
    }

 }


 