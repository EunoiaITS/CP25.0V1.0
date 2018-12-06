<?php 
/**INFORMATION**\
Created: 03-11-2012 19:09:00
Author: M.Wasiq Ghaznavi

Created: 03-11-2012 19:09:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php 
class Synonyms{
			
	public static function getSynonyms($id){
			global $db;
			$synonyms=false;
			$syns=$db->make_array($db->query("SELECT * FROM synonyms WHERE keyword_id_1='".$id."' OR keyword_id_2='".$id."'"));
			if($syns){
			$synonyms=array();
				foreach($syns as $syn){
					if($syn->keyword_id_1==$id){
						$synonyms[]=$db->select_single("keyword_index",array("id"=>$syn->keyword_id_2));
					}elseif($syn->keyword_id_2==$id){
						$synonyms[]=$db->select_single("keyword_index",array("id"=>$syn->keyword_id_1));
					}
				}
			}
			return $synonyms;
		}// get synonyms function
		
	public static function add($objPost){
		global $db;
		$keyword=$db->select_single("keyword_index",array("keyword"=>$objPost->keyword));
			if(isset($keyword->keyword)){
				alert("ERROR: Keyword Duplcation",$_SERVER['HTTP_REFERER']);
			}else{
				$obj=new stdClass();
				$obj->keyword=$objPost->keyword;
				$db->save("keyword_index",$obj);
				$keyword_id_1=$db->insert_id();

				$syn=new stdClass();
				$syn->keyword_id_1=$keyword_id_1;
				$syn->keyword_id_2=$objPost->linked_to;
				$db->save("synonyms",$syn);
				alert("New synonym added and linked",$_SERVER['HTTP_REFERER']);
			}
	}// add synonyms function

	public static function link($objPost){
		global $db;
		if(isset($objPost->keyword_id_1) && isset($objPost->keyword_id_2)){
			if($objPost->keyword_id_1 == $objPost->keyword_id_2){
					alert("ERROR: Keyword Link Conflict",$_SERVER['HTTP_REFERER']);
			}else{
				$check=$db->select_single("synonyms",array("keyword_id_1"=>$objPost->keyword_id_1,"keyword_id_2"=>$objPost->keyword_id_2));
				$checkRev=$db->select_single("synonyms",array("keyword_id_1"=>$objPost->keyword_id_2,"keyword_id_2"=>$objPost->keyword_id_1));

				if(isset($checkRev->keyword_id_1) || isset($check->keyword_id_1)){
					alert("ERROR: Synonyms Duplication",$_SERVER['HTTP_REFERER']);
				}else{
					$db->save("synonyms",$objPost);
					alert("Synonyms Successfully Linked",$_SERVER['HTTP_REFERER']);

				}
			}
		}

		
	}// link synonyms function
	
	public static function unLink($keyword_id_1,$keyword_id_2){
		global $db;
		$error=true;

		$link = $db->select_single("synonyms",array("keyword_id_1"=>$keyword_id_1,"keyword_id_2"=>$keyword_id_2));
		if(!$link){
			$link = $db->select_single("synonyms",array("keyword_id_1"=>$keyword_id_2,"keyword_id_2"=>$keyword_id_1));
		}
		if($link){
			if($db->query("DELETE FROM synonyms WHERE id='".$link->id."'")){
				$error=false;
				alert("Unlinked!");
			}
		}

		if($error){
			//alert("Something went wrong!");
		}

	}//unlink ends
}
?>