
   <?php
	require 'config/init.php';
	require CLASS_PATH.'product.php';

	$product = new Product();
        echo "haha";
	foreach(glob("track_data/*.json") as $file_name){
		//echo $_COOKIE['_user_device'];
            echo "$file_name";

        $file_data = file_get_contents($file_name);
		$data = json_decode($file_data, true);
		$cat = array();

		foreach($data as $cat_data){
			$cat[$cat_data['cat_id']][] = $cat_data['cat_id'];
		}
		debugger($cat, true);
	}	