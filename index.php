<?php
/**INFORMATION**\
Created: 17-10-2012 04:40:00
Author: M.Wasiq Ghaznavi

Last Modified: 17-10-2012 04:40:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php
//******************Auto Load*********************\\
//******************DONOT EDIT*********************\\
function __autoload ($class_name) {
  $class_name = 'engine/classes/class.' . $class_name . '.php';
  include_once ($class_name);
 }
require_once('engine/configurations.php');
require_once('engine/functions.php');
 
$session	= 	new Session();
$db 		=	new Database();
//echo $_SERVER['REQUEST_URI'];

	Gateway::Process(Request::Parameters());
?>