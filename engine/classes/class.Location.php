<?php 
/**INFORMATION**\
Created: 06-11-2012 07:52:00
Author: M.Wasiq Ghaznavi

Last Modified: 06-11-2012 07:52:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php
class Location {
		
	public static function all(){
		global $db;
		$sql="SELECT *,(SELECT name FROM categories WHERE id= location.categories_id) AS category, 
		(SELECT name FROM area WHERE id= location.area_id) AS area FROM location WHERE is_active='1' ";
		$object= $db->query_array($sql);
		
		return $object;
		}
	
	public static function by_id($id){
		global $db;
		if($id != NULL){
			$sql="SELECT *,(SELECT name FROM categories WHERE id= location.categories_id) AS category, 
			(SELECT name FROM area WHERE id= location.area_id) AS area FROM location WHERE id='".$id."' AND is_active='1' ";
			$object= $db->query($sql);
			$object= mysql_fetch_object($object);
			return $object;
		}else{
			echo ERROR;
			}
	}

	}
?>