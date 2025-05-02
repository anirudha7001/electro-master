<?php
// Database configuration
$host = 'localhost';       // Host name
$username = 'root';   // MySQL username
$password = 'toor';   // MySQL password
$database = 'ecom';     // MySQL database name

// Create a connection
$conn = new mysqli($host,$username,$password,$database);

//check connection
if($conn -> connect_errno){
  echo "Failed to connect to Mysql: " . $mysqli -> connect_error;
  exit();
}
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'.'/electro-master/']);
define('SITE_PATH','http://localhost/electro-master/');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'./media/product/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'./media/product/');

// Optionally, you can set the character set to UTF-8

?>

