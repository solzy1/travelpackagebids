<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/config.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/vendor/autoload.php';

	use Illuminate\Database\Capsule\Manager as Capsule;
     
    class Database {
    
        function __construct() {
            $capsule = new Capsule;
            $capsule->addConnection([
             'driver' => DBDRIVER,
             'host' => DBHOST,
             'database' => DBNAME,
             'username' => DBUSER,
             'password' => DBPASS,
             'charset' => 'utf8',
             'collation' => 'utf8_unicode_ci',
             'prefix' => '' 
            ]);
            
            $capsule->setAsGlobal();

            // Setup the Eloquent ORM…
            $capsule->bootEloquent(); 
        }
    }

	//Initialize Illuminate Database Connection 
	new Database();
?>