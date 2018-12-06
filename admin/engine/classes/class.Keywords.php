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
	
	public static function reindex(){
		global $db;
		self::generatePropheticFoodKeywords();
		Quran::quranKeywordIndex();
		Hadith::hadithKeywordIndex();
		Manuscript::manuscriptKeywordIndex();
		Article::articleKeywordIndex();
	}// reindex function	

	public static function generatePropheticFoodKeywords(){
		global $db;
		$pfoods=$db->select("prophetic_food","");
		if($pfoods){
			foreach($pfoods as $food){
				$foo=explode(" ",$food->food);
				if($foo){
					foreach($foo as $f){
						$fo=explode("-",$f);
						if($fo){
							foreach($fo as $ff){
								if(!self::exists($ff)){
									$obj=new stdClass();
									$obj->keyword=$ff;
									$db->save("keyword_index",$obj);									
								}//if not exists
							}//foreach exploded -
						}//if exploded -
					}//foreach exploded " "
				}//if exploded " "

				$foo=explode(" ",$food->trans_english);
				if($foo){
					foreach($foo as $f){
						$fo=explode("-",$f);
						if($fo){
							foreach($fo as $ff){
								if(!self::exists($ff)){
									$obj=new stdClass();
									$obj->keyword=$ff;
									$db->save("keyword_index",$obj);									
								}//if not exists
							}//foreach exploded -
						}//if exploded -
					}//foreach exploded " "
				}//if exploded " "

				$foo=explode(" ",$food->trans_malay);
				if($foo){
					foreach($foo as $f){
						$fo=explode("-",$f);
						if($fo){
							foreach($fo as $ff){
								if(!self::exists($ff)){
									$obj=new stdClass();
									$obj->keyword=$ff;
									$db->save("keyword_index",$obj);									
								}//if not exists
							}//foreach exploded -
						}//if exploded -
					}//foreach exploded " "
				}//if exploded " "
				

				$foo=explode(" ",$food->trans_arabic);
				if($foo){
					foreach($foo as $f){
						$fo=explode("-",$f);
						if($fo){
							foreach($fo as $ff){
								if(!self::exists($ff)){
									$obj=new stdClass();
									$obj->keyword=$ff;
									$db->save("keyword_index",$obj);									
								}//if not exists
							}//foreach exploded -
						}//if exploded -
					}//foreach exploded " "
				}//if exploded " "

			}// foreach prophetic food
		}// if prophetic foods
	}// generate keywords function
	
	public static function exists($x){
		global $db;
		$key=$db->select_single("keyword_index",array("keyword"=>$x));
		if($key){
			return $key->id;
		}else{
			return false;
		}
	}

	public static function getQuran($id){
		global $db;
		$quran=false;
		$keyword=$db->select_single("keyword_index",array("id"=>$id));
		if($keyword){
			if(isset($keyword->quran) && $keyword->quran!=""){
				$quran=array();
				$ids=explode(",", $keyword->quran);
				foreach($ids as $i){
					$quran[]=$db->select_single("quran",array("id"=>$i));
				}
			}
		}
		return $quran;
	}// get quran function

	public static function getHadith($id){
		global $db;
		$hadith=false;
		$keyword=$db->select_single("keyword_index",array("id"=>$id));
		if($keyword){
			if(isset($keyword->hadith) && $keyword->hadith!=""){
				$hadith=array();
				$ids=explode(",", $keyword->hadith);
				foreach($ids as $i){
					$hadith[]=$db->select_single("hadith",array("id"=>$i));
				}
			}
		}
		return $hadith;
	}// get hadith function

	public static function getManuscript($id){
		global $db;
		$manuscript=false;
		$keyword=$db->select_single("keyword_index",array("id"=>$id));
		if($keyword){
			if(isset($keyword->manuscript) && $keyword->manuscript!=""){
				$manuscript=array();
				$ids=explode(",", $keyword->manuscript);
				foreach($ids as $i){
					$manuscript[]=$db->select_single("manuscript",array("id"=>$i));
				}
			}
		}
		return $manuscript;
	}// get manuscript function

	public static function getArticle($id){
		global $db;
		$article=false;
		$keyword=$db->select_single("keyword_index",array("id"=>$id));
		if($keyword){
			if(isset($keyword->scientific_article) && $keyword->scientific_article!=""){
				$article=array();
				$ids=explode(",", $keyword->scientific_article);
				foreach($ids as $i){
					$article[]=$db->select_single("scientific_article",array("id"=>$i));
				}
			}
		}
		return $article;
	}// get article function

	public static function add($x){
		global $db;
		if(self::exists($x)){
			alert("ERROR: Keyword Duplication",$_SERVER['HTTP_REFERER']);
		}else{
			$obj=new stdClass();
			$obj->keyword=$x;
			$db->save("keyword_index",$obj);
			alert("Keyword successfully added",$_SERVER['HTTP_REFERER']);
		}
	}// add function



}//keywords class ends
?>