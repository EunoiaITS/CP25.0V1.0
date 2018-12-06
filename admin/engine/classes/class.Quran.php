<?php 
/**INFORMATION**\
Created: 03-11-2012 19:09:00
Author: M.Wasiq Ghaznavi

Created: 03-11-2012 19:09:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php 
class Quran{
			
	public static function quranKeywordIndex(){
		global $db;
		$keywords = $db->select("keyword_index","");
		if($keywords){
			foreach($keywords as $keyword){
				$query="SELECT * FROM quran WHERE 
					ayat LIKE '%".$keyword->keyword."%' OR 
					trans_english LIKE '%".$keyword->keyword."%' 
					OR trans_malay LIKE '%".$keyword->keyword."%'";


				$result=$db->make_array($db->query($query));
				if($result){
					foreach($result as $r){
						//link quran function
						self::linkQuran($keyword->id,$r->id);
					}
				}

				$query2="SELECT * FROM additional_information WHERE information LIKE '%".$keyword->keyword."%' AND type='quran' ";
				$result2=$db->make_array($db->query($query2));
				
				if($result2){
					foreach($result2 as $r){
						//link quran function
						self::linkQuran($keyword->id,$r->type_id);
					}
				}

			}// foreach keywords
		}// if keywords
	}
	
	public static function keywordIndexArray($x){
		if($x){
			return $y=explode(",",$x);
		}else{
			return false;
		}
	}

	public static function linkQuran($keyword_id,$quran_id){
		global $db;
		$keyword=$db->select_single("keyword_index",array("id"=>$keyword_id));
		if(isset($keyword->quran)){
			if($keyword->quran==""){
				$keyword->quran=$quran_id;
				$db->save("keyword_index",$keyword);
			}else{
				if(!in_array($quran_id,self::keywordIndexArray($keyword->quran))){
					$keyword->quran.=",".$quran_id;
					$db->save("keyword_index",$keyword);
				}
			}
		}
	}// link quran function

	public static function unLink($keyword_id,$quran_id){
		global $db;
		$error=true;

		$keyword=$db->select_single("keyword_index",array("id"=>$keyword_id));
		if(isset($keyword->quran)){
			if($keyword->quran!=""){
				$links=self::keywordIndexArray($keyword->quran);
				if(count($links)>1){
					$keyword->quran="";
					$db->save("keyword_index",$keyword);
					foreach($links as $l){
						if($l!=$quran_id){
							self::linkQuran($keyword->id,$l);
						}
					}
					$error=false;
					alert("Unlinked!");
				}else{
					$keyword->quran="";
					$db->save("keyword_index",$keyword);
					$error=false;
					alert("Unlinked!");
				}
			}
		}

		if($error){
			alert("Something went wrong");
		}

	}// unlink quran function

		
}
?>