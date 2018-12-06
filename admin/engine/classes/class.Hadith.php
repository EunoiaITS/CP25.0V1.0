<?php 
/**INFORMATION**\
Created: 03-11-2012 19:09:00
Author: M.Wasiq Ghaznavi

Created: 03-11-2012 19:09:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php 
class Hadith{
			
	public static function hadithKeywordIndex(){
		global $db;
		$keywords = $db->select("keyword_index","");
		if($keywords){
			foreach($keywords as $keyword){
				$query="SELECT * FROM hadith WHERE 
					trans_arabic LIKE '%".$keyword->keyword."%' OR 
					trans_english LIKE '%".$keyword->keyword."%' 
					OR trans_malay LIKE '%".$keyword->keyword."%'";


				$result=$db->make_array($db->query($query));
				if($result){
					foreach($result as $r){
						//link hadith function
						self::linkHadith($keyword->id,$r->id);
					}
				}
				
				$query2="SELECT * FROM additional_information WHERE information LIKE '%".$keyword->keyword."%' AND type='hadith' ";
				$result2=$db->make_array($db->query($query2));
				
				if($result2){
					foreach($result2 as $r){
						//link hadith function
						self::linkHadith($keyword->id,$r->type_id);
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

	public static function linkHadith($keyword_id,$hadith_id){
		global $db;
		$keyword=$db->select_single("keyword_index",array("id"=>$keyword_id));
		if(isset($keyword->hadith)){
			if($keyword->hadith==""){
				$keyword->hadith=$hadith_id;
				$db->save("keyword_index",$keyword);
			}else{
				if(!in_array($hadith_id,self::keywordIndexArray($keyword->hadith))){
					$keyword->hadith.=",".$hadith_id;
					$db->save("keyword_index",$keyword);
				}
			}
		}
	}// link hadith function

	public static function unLink($keyword_id,$hadith_id){ 
		global $db;
		$error=true;

		$keyword=$db->select_single("keyword_index",array("id"=>$keyword_id));
		if(isset($keyword->hadith)){
			if($keyword->hadith!=""){
				$links=self::keywordIndexArray($keyword->hadith);
				if(count($links)>1){
					$keyword->hadith="";
					$db->save("keyword_index",$keyword);
					foreach($links as $l){
						if($l!=$hadith_id){
							self::linkHadith($keyword->id,$l);
						}
					}
					$error=false;
					alert("Unlinked!");
				}else{
					$keyword->hadith="";
					$db->save("keyword_index",$keyword);
					$error=false;
					alert("Unlinked!");
				}
			}
		}

		if($error){
			alert("Something went wrong");
		}

	}// unlink hadith function

		
}
?>