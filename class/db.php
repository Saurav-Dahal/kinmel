<?php

abstract class Database{
    protected $conn = null;
    protected $stmt = null;
    protected $sql = null;
    protected $table = null;

	public function __construct(){
		try{
               $this->conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';',DB_USERNAME,DB_PWD);
               $this->conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
               $this->stmt = $this->conn->prepare('SET NAMES utf8');
               $this->stmt->execute();
		}catch(PDOException $e){
			error_log(date('Y-m-d h.i.s A').', Connection Setup '.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;

		}catch(Exception $e){
			error_log(date('Y-m-d h.i.s A').', Connection Setup, General '.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
	    }
    }


final protected function create($sql){
	try{
		 $this->sql= $sql;

		 if(empty($this->sql)){
		 	throw new Exception("Empty Query");
		 	  }
         $this->stmt= $this->conn->prepare($this->sql);
         $this->stmt->execute();
         return $this->stmt;
	}catch(PDOException $e){
         error_log(date('Y-m-d h.i.s A').',Connection Setup:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
         return false;
	} catch(Exception $e){
          error_log(date('Y-m-d h.i.s A').'Connection Setup, General:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
          return false;
	}
}

final protected function table($table){
	$this->table = $table;
}

final protected function select($args= array(), $is_die = false){
	try{
          $this->sql= "SELECT ";
            /*we have to generate sql as
          SELECT fields(* or user_name, password ...)FROM table(user or any other table)
          join statement(and ...)
          WHERE clause
          GROUP BY clause
          ORDER BY clause
          LIMIT start, count
            */
          /*setting fields i.e condition */

           if (isset($args['fields'])) {
           	    if (is_array($args['fields'])) {
           	    	$this->sql.= implode(",", $args['fields']);
           	    }else{
                   $this->sql.=  $args['fields'];
           	    }
           }else{ 
              $this->sql.= " * ";
           }

           /* setting fields ends here*/
           
           $this->sql.= " FROM ";

           /*set table*/
             if (!isset($this->table) || empty($this->table)) {
             	throw new Exception('Table Not Set');	
             }else{
             	$this->sql.= $this->table;
             }
           /*set table*/

           /*join query*/
              if (isset($args['join']) && !empty($args['join'])) {
                   $this->sql.= $args['join'];
              }
            /*join query*/

           /*where clause*/
               if (isset($args['where']) && !empty($args['where'])) {
               	   if (is_array($args['where'])) {
                          $temp= array();
                          foreach ($args['where'] as $column_name => $value) {
                          	$str = $column_name."= :".$column_name;
                          	$temp[] = $str;
                          }

               	   	$this->sql.= " WHERE ". implode(' AND ', $temp);
               	   }else{
               	   	$this->sql.= " WHERE ". $args['where'];
               	   } 
               }
           /*where clause*/
             
             /* group by*/
             /* group by*/

             /* order by*/
              if (isset($args['order_by']) && !empty($args['order_by'])) {
                 $this->sql.=" ORDER BY ".$args['order_by'];
              }else{
                $this->sql.=" ORDER BY ".$this->table.".id DESC";
              }
              
             /* order by*/

             /* limit*/

              if(isset($args['limit']) && !empty($args['limit'])){
                    if(is_array($args['limit'])){
                          $this->sql .= " LIMIT ".$args['limit'][0].", ".$args['limit'][1];
                      } else {
                           $this->sql .= ' LIMIT '.$args['limit'];
                            }
                 }

             /* limit*/
              $this->stmt = $this->conn->prepare($this->sql);

             /*Data Binding*/
              if (isset($args['where']) && !empty($args['where']) && is_array($args['where'])) {
              	foreach ($args['where'] as $column_name => $value) {
              		if (is_int($value)) {
              			$param = PDO::PARAM_INT;
              		}else if (is_bool($value)) {
              			$param = PDO::PARAM_BOOL;
              		}else if (is_null($value)) {
              			$param = PDO::PARAM_NULL;
              		}else{
              			$param = PDO::PARAM_STR;
              		}

              		if ($param) {
              			$this->stmt->bindValue(":".$column_name, $value, $param);
              		}
              	}
              }
          /*Data Binding ends*/

          // if ($is_die) {
          // 	echo $this->sql;
          // 	debugger($this->stmt);
          // 	debugger($args, true);
          // }

          $this->stmt->execute();
          $data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
          return $data;
	}catch(PDOException $e){
          error_log(date('Y-m-d h.i.s A').',Select Query:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
           return false;
	}catch(Exception $e){
            error_log(date('Y-m-d h.i.s A').',Select Query,  General:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
            return false;
	}
}



final protected function update($data, $args= array(), $is_die = false){

  try{
       /* UPDATE user SET 'api_token'= data($data) WHERE clause */

       $this->sql= "UPDATE ";
        /*table*/
       if (!isset($this->table) || empty($this->table)) {
         throw new Exception("Table Not Set."); 
       }else{
             $this->sql.= $this->table;
           }
           /*table*/

           $this->sql.= " SET ";

           if (isset($data) && !empty($data)) {
                 if (is_array($data)) {
                       $temp= array();

                       foreach ($data as $column_name => $value) {
                           $str= $column_name."= :".$column_name;
                           $temp[] = $str;
                       }
                       $this->sql.= implode(" , ", $temp);
                 }else{
                     $this->sql.= $temp;
                 }
           }

            /*where clause*/
               if (isset($args['where'])&& !empty($args['where'])) {
                   if (is_array($args['where'])) {
                          $temp= array();
                          foreach ($args['where'] as $column_name => $value) {
                            $str = $column_name." = :".$column_name;
                            $temp[] = $str;
                          }

                    $this->sql.= " WHERE ". implode('AND', $temp); 
                   }else{ 
                    $this->sql.= " WHERE ". $args['where'];
                   }
               }
           /*where clause*/ 
        $this->stmt= $this->conn->prepare($this->sql);
          
          /*Data Binding*/
          if (isset($data) && !empty($data) && is_array($data)) {
            
                foreach ($data as $column_name => $value) {
                  if (is_int($value)) {
                    $param = PDO::PARAM_INT;
                  }else if (is_bool($value)) {
                    $param = PDO::PARAM_BOOL;
                   }
                    // else if (is_null($value)) {
                  //   $param = PDO::PARAM_NULL;
                  // }
                    else{
                    $param = PDO::PARAM_STR;
                  }

                  if ($param) {
                    $this->stmt->bindValue(":".$column_name, $value, $param);
                  }
                }
              }
              
                if (isset($args['where']) && !empty($args['where']) && is_array($args['where'])) {
                foreach ($args['where'] as $column_name => $value) {
                  if (is_int($value)) {
                    $param = PDO::PARAM_INT;
                  }else if (is_bool($value)) {
                    $param = PDO::PARAM_BOOL;
                      }//else if (is_null($value)) {
                  //   $param = PDO::PARAM_NULL;
                  // }
                    else{
                    $param = PDO::PARAM_STR;
                  }

                  if ($param) {
                    $this->stmt->bindValue(":".$column_name, $value, $param);
                  }
                }
              }
    // /*Data Binding ends*/

  //   if ($is_die) {
  //          echo $this->sql;
  //          debugger($this->stmt);
  //          debugger($args, true);
  // }
         return $this->stmt->execute();

  }catch(PDOException $e){
     error_log(date('Y-m-d h.i.s A').', Update Query:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
  }catch(Exception $e){
   error_log(date('Y-m-d h.i.s A').',Update Query General:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
  }
}

final protected function insert($data, $is_die= false){
 

  try{
       /* INSERT INTO banners SET 'api_token'= data($data) WHERE clause */

       $this->sql= "INSERT INTO ";

       if (!isset($this->table) || empty($this->table)) {
         throw new Exception("Table Not Set."); 
       }else{
             $this->sql.= $this->table;
           }

           $this->sql.= " SET ";
            /*setting data*/
           if (isset($data) && !empty($data)) {
                 if (is_array($data)) {
                       $temp= array();
                       foreach ($data as $column_name => $value) {
                           $str= $column_name."= :".$column_name ;
                           $temp[] = $str;
                       }
                       $this->sql.= implode(" , ", $temp);
                 }else{
                     $this->sql.= $temp;
                 }
           }
           /*setting data ends*/

        $this->stmt= $this->conn->prepare($this->sql);
          
          /*Data Binding*/
          if (isset($data) && !empty($data) && is_array($data)) {
                foreach ($data as $column_name => $value) {
                  if (is_int($value)) {
                    $param = PDO::PARAM_INT;
                  }else if (is_bool($value)) {
                    $param = PDO::PARAM_BOOL;
                  }/*else if (is_null($value)) {
                    $value = null;
                    $param = PDO::PARAM_INT;
                  }*/else{
                    $param = PDO::PARAM_STR;
                  }

                  if ($param) {
                    $this->stmt->bindValue(":".$column_name, $value, $param);
                  }
                }
              }
          
    /*Data Binding ends*/

  //   if ($is_die) {
  //          echo $this->sql;
  //          debugger($this->stmt);
  //          debugger($args, true);
  // }
         $this->stmt->execute();
         return $this->conn->lastInsertId();

  }catch(PDOException $e){
     error_log(date('Y-m-d h.i.s A').',Insert Query:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
  }catch(Exception $e){
   error_log(date('Y-m-d h.i.s A').',Insert Query General:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
  } 
}

final protected function delete($args, $is_die= false){
  
     try{  
          /*we have to generate sql as
              DELETE FROM table
               WHERE clause 
            */

          $this->sql= "DELETE FROM ";
          
           /*set table*/
             if (!isset($this->table) || empty($this->table)) {
              throw new Exception('Table Not Set'); 
             }else{
              $this->sql.= $this->table;
             }
           /*set table*/

           /*where clause*/
               if (isset($args['where']) && !empty($args['where'])) {
                   if (is_array($args['where'])) {
                          $temp= array();
                          foreach ($args['where'] as $column_name => $value) {
                            $str = $column_name."= :".$column_name;
                            $temp[] = $str;
                          }

                    $this->sql.= " WHERE ". implode(' AND ', $temp);
                   }else{
                    $this->sql.= " WHERE ". $args['where'];
                   } 
               }
           /*where clause*/

              $this->stmt = $this->conn->prepare($this->sql);

             /*Data Binding*/
              if (isset($args['where']) && !empty($args['where']) && is_array($args['where'])) {
                foreach ($args['where'] as $column_name => $value) {
                  if (is_int($value)) {
                    $param = PDO::PARAM_INT;
                  }else if (is_bool($value)) {
                    $param = PDO::PARAM_BOOL;
                  }else if (is_null($value)) {
                    $param = PDO::PARAM_NULL;
                  }else{
                    $param = PDO::PARAM_STR;
                  }

                  if ($param) {
                    $this->stmt->bindValue(":".$column_name, $value, $param);
                  }
                }
              }
          /*Data Binding ends*/

          //  if ($is_die) {
          //  echo $this->sql;
          //  debugger($this->stmt);
          //  debugger($args, true);
          // }

         return $this->stmt->execute();
  }catch(PDOException $e){
          error_log(date('Y-m-d h.i.s A').',Delete Query:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
           return false;
  }catch(Exception $e){
            error_log(date('Y-m-d h.i.s A').',Delete Query,  General:'.$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
            return false;
  }

}

}