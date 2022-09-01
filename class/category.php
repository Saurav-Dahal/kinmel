<?php

class Category extends Database{
	public function __construct(){
		Database::__construct();
		$this->table('categories');
	}

	public function getAllCategory(){
		return $this->select();
	}

	public function getAllParents(){
        
        $cond= array( 
        	            'where'=> array(   'is_parent'=> 1,
                                           'parent_id'=>0 

                                        ) 
                     );
		return $this->select($cond);
	}

	public function add_category($data, $is_die= false){

	   return $this->insert($data, $is_die);
	}

    public function update_category($data, $id, $is_die= false){
       
       $cond= array(
                        'where'=> array('id'=>$id)

                     );   
    	return $this->update($data, $cond, $is_die);
    }
   
   public function getCategoryParentById($id, $is_die= false){

      $cond= array(
      	              'where'=> array('id'=>$id)

                  );
   	return $this->select($cond, $is_die);
   }

   public function getCategoryById($id, $is_die = false){

      $cond= array(
      	              'where'=> array('id'=>$id)

                  );
   	return $this->select($cond, $is_die);
   }

  public function deleteCategory($id, $is_die= false){

      $cond= array(
      	              'where'=> array('id'=>$id)

                  );
   	return $this->delete($cond, $is_die);
  }

  public function shiftChild($id, $is_die= false){
    
    $data= array(
                     'is_parent' => 1,
                       'parent_id'=> '0'
                 );

    $cond= array(
                   'where'=> array( 'parent_id'=>$id)
                 );
  	return $this->update($data,$cond);
  }
  

  public function getChildByParentId($id, $is_die=false){

    $cond= array(
                    'where' => array( 'is_parent'=> 0,
                                      'parent_id'=> $id
                                    )
                 );
    return $this->select($cond);

  }

  public function getAllActiveParent(){
    $cond= array(
                   'where'=> array(
                                   'status'=> 'Active',
                                   'is_parent'=> 1
                                  ),
                   'order_by'=> 'title ASC'
                  
                 );
       return $this->select($cond);
  }
}