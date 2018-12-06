<?php 
/**INFORMATION**\
Created: 06-11-2012 07:52:00
Author: M.Wasiq Ghaznavi

Last Modified: 06-11-2012 07:52:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php
class Keywords {
	
	public static function processKeywordsResults($keywords){
		global $db;
		$results=false;
		if($keywords){
			$results=array();
			foreach($keywords as $keyword){
				$results1=self::getQuran($keyword->id);
				if(is_array($results1)){
					$results=array_merge($results,$results1);
				}
				$syns=self::getSynonyms($keyword->id);
				if($syns){
					foreach($syns as $syn){
						$results1=self::getQuran($syn->id);
						if(is_array($results1)){
							$results=array_merge($results,$results1);
						}
					}
				}
			}
		}
		return $results;
	}//process keywords results function
		
	public static function keywordIndexArray($x){
		if($x){
			return $y=explode(",",$x);
		}else{
			return false;
		}
	}// keyword index array function

	public static function getQuran($id){
		global $db;
		$quran=false;
		$keyword=$db->select_single("keyword_index",array("id"=>$id));
		if($keyword){
			if($keyword->quran){
				$quran=array();
				$ids=explode(",", $keyword->quran);
				foreach($ids as $i){
					$quran[]=$db->select_single("quran",array("id"=>$i));
				}
			}
		}
		return $quran;
	}// get quran function

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
		
}
?>