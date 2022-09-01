<?php





ob_start();
session_start();


$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/';

if($_SERVER['SERVER_ADDR']=='127.0.0.1' || $_SERVER['SERVER_ADDR']=='::1')
	{
		define('ENVIRONMENT', 'DEVELOPMENT');
	}
else{
	    define('ENVIRONMENT', 'PRODUCTION');
	}	

	if (ENVIRONMENT=='DEVELOPMENT') {
		  error_log(E_ALL);
		  define('DB_HOST', 'localhost');
		  define('DB_USERNAME', 'root');
		  define('DB_PWD', '');
		  define('DB_NAME', 'kinmel');
	}  
	else{
		error_log(0);
		define('DB_HOST', 'localhost');
		define('DB_USERNAME', 'root');
		define('DB_PWD', 'Passw0rd@saurav');
		define('DB_NAME', 'kinmel');
	}


	  define('ERROR_PATH', $_SERVER['DOCUMENT_ROOT'].'error/');
	  define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'].'config/');
	  define('CLASS_PATH', $_SERVER['DOCUMENT_ROOT'].'class/');
    define('SITE_URL', $url);
    define('ALLOWED_IMAGE_EXTENSION', array('jpg', 'jpeg', 'png', 'gif', 'bmp'));
    define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].'upload/');
    define('UPLOAD_URL', SITE_URL.'upload/');



    /***   Admin Panel constants ***/

    define('CMS_URL', SITE_URL.'cms/');
    define('ASSETS_URL', CMS_URL.'assets/');
    define('CSS_URL', ASSETS_URL.'css/');
    define('JS_URL', ASSETS_URL.'js/');

    /*** Admin Panel constants ends ***/ 

    define('PAGE_TITLE', 'Kinmel.com');


    /****** Frontend constant******/

      define('FRONT_ASSETS_URL', SITE_URL.'assets/');
      define('FRONT_CSS_URL', FRONT_ASSETS_URL.'css/');
      define('FRONT_JS_URL', FRONT_ASSETS_URL.'js/');
      define('FRONT_IMAGE_URL', FRONT_ASSETS_URL.'img/');

      define('SITE_TITLE', "Kinmel.com || A leading nepali ecommerce website.");
      define('SITE_DESCRIPTION', "Kinmel is a leading nepali ecommerce website where quality products and service is our first priority.");
      define('SEO_KEYWORDS', "nepali ecommerce website, ecommerce website in nepal, best ecommerce website in nepal");

      define('OG_URL', SITE_URL);
      define('OG_TITLE', SITE_TITLE);
      define('OG_DESCRIPTION', SITE_DESCRIPTION);
      define('OG_TYPE', 'article');
      define('OG_IMAGE', FRONT_IMAGE_URL.'logo.png');

    /****** Frontend constant ends******/