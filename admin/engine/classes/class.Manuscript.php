<?php 
/**INFORMATION**\
Created: 03-11-2012 19:09:00
Author: M.Wasiq Ghaznavi

Created: 03-11-2012 19:09:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php 
class Manuscript{
			
	public static function manuscriptKeywordIndex(){
		global $db;
		$keywords = $db->select("keyword_index","");
		if($keywords){
			foreach($keywords as $keyword){
				$query="SELECT * FROM manuscript WHERE 
					trans_arabic LIKE '%".$keyword->keyword."%' OR 
					trans_english LIKE '%".$keyword->keyword."%' OR 
					trans_malay LIKE '%".$keyword->keyword."%'";


				$result=$db->make_array($db->query($query));
				if($result){
					foreach($result as $r){
						//link manuscript function
						self::linkManuscript($keyword->id,$r->id);
					}
				}

				$query2="SELECT * FROM additional_information WHERE information LIKE '%".$keyword->keyword."%' AND type='manuscript' ";
				$result2=$db->make_array($db->query($query2));
				
				if($result2){
					foreach($result2 as $r){
						//link manuscript function
						self::linkManuscript($keyword->id,$r->type_id);
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

	public static function linkManuscript($keyword_id,$manuscript_id){
		global $db;
		$keyword=$db->select_single("keyword_index",array("id"=>$keyword_id));
		if(isset($keyword->manuscript)){
			if($keyword->manuscript==""){
				$keyword->manuscript=$manuscript_id;
				$db->save("keyword_index",$keyword);
			}else{
				if(!in_array($manuscript_id,self::keywordIndexArray($keyword->manuscript))){
					$keyword->manuscript.=",".$manuscript_id;
					$db->save("keyword_index",$keyword);
				}
			}
		}
	}// link Manuscript function

	public static function unLink($keyword_id,$manuscript_id){ 
		global $db;
		$error=true;

		$keyword=$db->select_single("keyword_index",array("id"=>$keyword_id));
		if(isset($keyword->manuscript)){
			if($keyword->manuscript!=""){
				$links=self::keywordIndexArray($keyword->manuscript);
				if(count($links)>1){
					$keyword->manuscript="";
					$db->save("keyword_index",$keyword);
					foreach($links as $l){
						if($l!=$manuscript_id){
							self::linkManuscript($keyword->id,$l);
						}
					}
					$error=false;
					alert("Unlinked!");
				}else{
					$keyword->manuscript="";
					$db->save("keyword_index",$keyword);
					$error=false;
					alert("Unlinked!");
				}
			}
		}

		if($error){
			alert("Something went wrong");
		}

	}// unlink Manuscript function

		
}
?>