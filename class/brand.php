<?php

/**
* 
*/
class Brand extends Database{ 

    public function __construct(){
       Database::__construct();
		  $this->table('brand');
	   }

   public function add_brand($data, $is_die= false){
     return $this->insert($data, $is_die);
    }

    public function getAllBrand(){
    	return $this->select();
    }

    public function getBrandById($data, $is_die= false){
    	$cond= array(
                      'where'=> array('id'=> $data)
 
    	           );
    	return $this->select($cond, $is_die);
    }

    public function deleteBrand($id, $is_die= false){
    	$cond= array(
    		           'where'=> array('id'=> $id)
    	             );
    	return $this->delete($cond);
    }
    public function update_brand($data, $id, $is_die= false){
           $cond= array(
                          'where'=> array('id'=>$id)
                      );
        return $this->update($data, $cond);
    }

}