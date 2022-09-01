<?php

require 'config/init.php';
require CLASS_PATH.'schema.php';

$schema = new Schema();

$sql= array(
	           'users' => "CREATE TABLE IF NOT EXISTS users(
                           id int NOT NULL AUTO_INCREMENT,
                           PRIMARY KEY(id),
                           full_name varchar(50),
                           email_address varchar(150) NOT NULL,
                           password text NOT NULL,
                           roles ENUM('Admin','Vendor','Customer'),
                           status ENUM('Active','Inactive'),
                           remember_token text DEFAULT NULL,
                           api_token text DEFAULT NULL,
                           other_info text DEFAULT NULL,
                           added_date datetime DEFAULT CURRENT_TIMESTAMP,
                           update_date datetime ON UPDATE CURRENT_TIMESTAMP
                          )",

               'customers' => "CREATE TABLE IF NOT EXISTS customers(
                                id int NOT NULL AUTO_INCREMENT,
                                PRIMARY KEY(id),
                                user_id int NOT NULL,
                                billing_address text ,
                                shipping_address text,
                                phone_number varchar(30),
                                added_date datetime DEFAULT CURRENT_TIMESTAMP,
                                update_date datetime ON UPDATE CURRENT_TIMESTAMP
                              )", 

                'banners' => "CREATE TABLE IF NOT EXISTS banners(
                              id int NOT NULL AUTO_INCREMENT,
                              PRIMARY KEY(id),
                              title varchar(150),
                              link text,
                              image varchar(100),
                              status ENUM('Active', 'Inactive'),
                              added_by int,
                              added_date datetime DEFAULT CURRENT_TIMESTAMP,
                              update_date datetime ON UPDATE CURRENT_TIMESTAMP
                             )",

                'category' => "CREATE TABLE IF NOT EXISTS categories(
                               id int NOT NULL AUTO_INCREMENT,
                               PRIMARY KEY(id),
                               title text NOT NULL,
                               summary text,
                               image text,
                               is_parent tinyint DEFAULT 1,
                               parent_id int DEFAULT null,
                               show_in_menu tinyint DEFAULT 1,
                               status ENUM('Active', 'Inactive'),
                               added_by int,
                               added_date datetime DEFAULT CURRENT_TIMESTAMP,
                               update_date datetime ON UPDATE CURRENT_TIMESTAMP
                              )",

                 'brand' => "CREATE TABLE IF NOT EXISTS brand(
                             id int NOT NULL AUTO_INCREMENT,
                             PRIMARY KEY(id),
                             title text NOT NULL,
                             summary text,
                             image text,
                             status ENUM('Active', 'Inactive'),
                             added_by int,
                             added_date datetime DEFAULT CURRENT_TIMESTAMP,
                             update_date datetime ON UPDATE CURRENT_TIMESTAMP
                             )",             

                'products' =>  "CREATE TABLE IF NOT EXISTS products(
                                 id int NOT NULL AUTO_INCREMENT,
                                 PRIMARY KEY(id),
                                 title text NOT NULL,
                                 cat_id int,
                                 child_cat_id int,
                                 summary text,
                                 description text,
                                 price float,
                                 discount float,
                                 thumbnail text,
                                 brand int,
                                 stock int,
                                 other_info text,
                                 is_featured tinyint,
                                 is_branded tinyint,
                                 status ENUM('Active', 'Inactive'),
                                 vendor_id int,
                                 added_by int,
                                 added_date datetime DEFAULT CURRENT_TIMESTAMP,
                                 update_date datetime ON UPDATE CURRENT_TIMESTAMP
                               )",

           'product_images' => "CREATE TABLE IF NOT EXISTS product_images(
                                 id int NOT NULL AUTO_INCREMENT,
                                 PRIMARY KEY(id),
                                 product_id int NOT NULL,
                                 image_name text
                                )"                                                                                                              
       );

foreach ($sql as $table => $query) {
    if($schema->createTable($query)){
	     echo "<em>".$table."</em>Table created successfully.";
       }
    else{
	     echo "Sorry There was problem while creating <em>".$table."</em>table.";
      }
   echo "<br>";
}