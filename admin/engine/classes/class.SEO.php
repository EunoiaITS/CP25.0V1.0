<?php 
/**INFORMATION**\
Created: 06-11-2012 07:52:00
Author: M.Wasiq Ghaznavi

Last Modified: 06-11-2012 07:52:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php
class SEO{
	
	public static function image($src,$width="",$height="",$alt="image"){
		$img="";
		$path= Request::$ABSOLUTE_URL."images/";
		if($src != NULL){
			$src= $path.$src;
			$img.= '<img src="'.$src.'"';
				if($width != NULL){
						$img.= ' width="'.$width.'" ';
					}
				if($height != NULL){
						$img.= ' height="'.$height.'" ';
					}
			$img.= ' alt="'.$alt.'" />';
			
			echo $img;
			
			}else{
				echo ERROR;
				}
		}
	}
?>