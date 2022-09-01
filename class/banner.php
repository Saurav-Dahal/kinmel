<?php

/**
* 
*/
class Banner extends Database
{  public function __construct()
	{  
    Database::__construct();
		$this->table('banners');
	   }

   public function add_banner($data, $is_die= false){
     return $this->insert($data, $is_die);
    }

    public function getAllBanner(){
    	return $this->select();
    }

    public function getBannerById($data, $is_die= false){
    	$cond= array(
                      'where'=> array('id'=> $data)
    	           );
    	return $this->select($cond, $is_die);
    }

    public function deleteBanner($id, $is_die= false){
    	$cond= array(
    		           'where'=> array('id'=> $id)
    	             );
    	return $this->delete($cond);
    }
    public function update_banner($data, $id, $is_die= false){
           $cond= array(
                          'where'=> array('id'=>$id)
                      );
        return $this->update($data, $cond);
    }

}