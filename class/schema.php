<?php
class Schema extends Database{

	public function __construct(){
		Database::__construct();
    }

     public function createTable($sql){
        return $this->create($sql);
     }
}

