<?php 

class Product extends Database{

	public function __construct(){
		Database::__construct();
		$this->table('products');
	}

	public function addProduct($data, $is_die= false){
		return $this->insert($data, $is_die);

	}

	public function getAllProduct(){
		$cond = array(
		                'fields'=> array(
		                	              'products.id',
		                	              'products.title',
		                	              'products.cat_id',
		                	              'products.price',
		                	              'products.discount',
		                	              'products.status',
		                	              'products.thumbnail',
		                	              'categories.title AS cat_title',
		                	              '(SELECT categories.title FROM categories where id= products.child_cat_id) as child_cat_title' 
		                	          ),
		                'join'=> " LEFT JOIN categories ON products.cat_id= categories.id"
		              );
		return $this->select($cond, true);
	}

	public function getProductById($id){
		$cond= array(
		               'where' => array(
		               	                 'id'=>$id
		                               )
		           );
		return $this->select($cond);
	}

	public function deleteProduct($id){
		$cond= array(
		               'where' => array(
		               	                 'id'=>$id
		                               )
		           );
		return $this->delete($cond);
	}

	public function updateProduct($data, $id){
		$cond= array(
		              'where'=> array(
		              	                 'id'=>$id
		                                    )
		          );
		 $success= $this->update($data, $cond);
		if ($success) {
			return $id;
		}else{
			return false;
		}
	}

	public function getSearchValue($data){
		$where = "products.status= 'Active'";

		if (isset($data['keyword']) && !empty($data['keyword'])) {
			$where .= " AND (
                             products.title LIKE '%".$data['keyword']."%' 
                             OR products.summary LIKE '%".$data['keyword']."%' 
                             OR products.description LIKE '%".$data['keyword']."%'         
			)";
		}

		if (isset($data['cat_id']) && !empty($data['cat_id'])) {
			$where .= " AND products.cat_id =".$data['cat_id'];
		}

		if (isset($data['min_price']) && !empty($data['min_price'])) {
			$where .= " AND products.price >=".$data['min_price'];
		}

		if (isset($data['max_price']) && !empty($data['max_price'])) {
			$where .= " AND products.price <=".$data['max_price'];
		}

		if (isset($data['brand']) && !empty($data['brand'])) {
			$where .= " AND products.brand =".$data['brand'];
		}

		$cond= array(
			           'fields' => array(
			           	                   'products.id',
			           	                   'products.title',
			           	                   'products.price',
			           	                   'products.discount',
			           	                   'products.thumbnail',
			           	                   'products.added_date'
			                             ),
			           'where' => $where,
			           'limit' => array(0,15)
		);
         return $this->select($cond);
	}

}