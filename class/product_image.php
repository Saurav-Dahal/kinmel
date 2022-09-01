<?php 


class ProductImage extends Database
{
	
	public function __construct()
	{   Database::__construct();
		$this->table('product_images');
		
	}

	public function addProductImg($data){
		return $this->insert($data);
	}

	public function getProductImageByProductId($id){
		$cond= array(
                      'where'=> array(
                                        'product_id'=> $id
                                     )
		             );
		return $this->select($cond);
	}

	public function deleteImageByName($data){
		$cond= array(
                       'where'=> array(
                                          'image_name'=> $data     
                                          )
		           );
		return $this->delete($cond);
	}
}