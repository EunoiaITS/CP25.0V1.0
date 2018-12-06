<?php 
/**INFORMATION**\
Created: 03-11-2012 19:09:00
Author: M.Wasiq Ghaznavi

Created: 03-11-2012 19:09:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php 
class Article{
			
	public static function articleKeywordIndex(){
		global $db;
		$keywords = $db->select("keyword_index","");
		if($keywords){
			foreach($keywords as $keyword){
				$query="SELECT * FROM scientific_article WHERE 
					name LIKE '%".$keyword->keyword."%' OR 
					author LIKE '%".$keyword->keyword."%' 
					OR url LIKE '%".$keyword->keyword."%'";


				$result=$db->make_array($db->query($query));
				if($result){
					foreach($result as $r){
						//link article function
						self::linkArticle($keyword->id,$r->id);
					}
				}
				
				$query2="SELECT * FROM additional_information WHERE information LIKE '%".$keyword->keyword."%' AND type='scientific_article' ";
				$result2=$db->make_array($db->query($query2));
				
				if($result2){
					foreach($result2 as $r){
						//link hadith function
						self::linkArticle($keyword->id,$r->type_id);
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

	public static function linkArticle($keyword_id,$article_id){
		global $db;
		$keyword=$db->select_single("keyword_index",array("id"=>$keyword_id));
		if(isset($keyword->scientific_article)){
			if($keyword->scientific_article==""){
				$keyword->scientific_article=$article_id;
				$db->save("keyword_index",$keyword);
			}else{
				if(!in_array($article_id,self::keywordIndexArray($keyword->scientific_article))){
					$keyword->scientific_article.=",".$article_id;
					$db->save("keyword_index",$keyword);
				}
			}
		}
	}// link article function

	public static function unLink($keyword_id,$article_id){ 
		global $db;
		$error=true;

		$keyword=$db->select_single("keyword_index",array("id"=>$keyword_id));
		if(isset($keyword->scientific_article)){
			if($keyword->scientific_article!=""){
				$links=self::keywordIndexArray($keyword->scientific_article);
				if(count($links)>1){
					$keyword->scientific_article="";
					$db->save("keyword_index",$keyword);
					foreach($links as $l){
						if($l!=$article_id){
							self::linkHadith($keyword->id,$l);
						}
					}
					$error=false;
					alert("Unlinked!");
				}else{
					$keyword->scientific_article="";
					$db->save("keyword_index",$keyword);
					$error=false;
					alert("Unlinked!");
				}
			}
		}

		if($error){
			alert("Something went wrong");
		}

	}// unlink article function

		
}
?>