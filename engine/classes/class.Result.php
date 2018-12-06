<?php 
/**INFORMATION**\
Created: 06-11-2012 07:52:00
Author: M.Wasiq Ghaznavi

Last Modified: 06-11-2012 07:52:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php
class Result {

	public $_words;
	public $_synonyms;
	public $_quran;
	public $_hadith;
	public $_manuscript;
	public $_article;
	public $_synonyms_quran;
	public $_synonyms_hadith;
	public $_synonyms_manuscript;
	public $_synonyms_article;
	public $_prophetic_foods;
	public $_selected_pf;

	function __construct($search){
		global $db;
		$this->_words=array();
		$this->_synonyms=array();
		$this->_synonyms_quran=array();
		$this->_synonyms_hadith=array();
		$this->_synonyms_manuscript=array();
		$this->_synonyms_article=array();
		$this->_quran=array();
		$this->_hadith=array();
		$this->_manuscript=array();
		$this->_article=array();
		$this->_prophetic_foods=array();
		$search=trim($db->escape_value($search));	// Trim and Escape Search Term

		if(isset($search) && $search!=""){			// If search term not empty 

			$this->processKeywords($search);		// Split search term and find amtching keywords in index
			$this->getAllQuran();					// Get all ayats linked to the keywords. Weight the ayats
			$this->getAllHadith();					// Get all hadiths linked to the keywords. Weight the hadiths
			$this->getAllManuscript();				// ***Get all manuscripts linked to the keywords. Weight the manuscripts
			$this->getAllArticle();					// ***Get all articles linked to the keywords. Weight the articles
			
			$this->getAllSynonyms();				// Get all synonyms linked to the keywords. Weight the synonyms
			$this->getAllSynonymsQuran();			// Get all ayats linked to synonyms. Weight the ayats.
			$this->getAllSynonymsHadith();			// Get all hadiths linked to synonyms. Weight the hadiths.
			$this->getAllSynonymsManuscript();		// ***Get all manuscripts linked to synonyms. Weight the manuscripts.
			$this->getAllSynonymsArticle();			// ***Get all articles linked to synonyms. Weight the articles.
			
			$this->mergeQuran();					// Merge all quran ayats and their weights.
			$this->mergeHadith();					// Merge all hadiths and their weights.
			$this->mergeManuscript();				// ***Merge all manuscripts and their weights.
			$this->mergeArticle();					// ***Merge all articles and their weights.
			$this->processPropheticFood($search);	// Merge synonyms and keywords to find propheitc foods.


		}// if search not empty
		
	}// constructor ends
	
	public function processKeywords($search){
		global $db;
		$ignore=array("this","is","has","the","any","of","you","to","have","and","a",
			"with","for","him","that","so","let","it","ke","ada","dan","itu","ini","saya","satu","dua","tiga",
			"empat","lima","enam","tujuh","sembilan","se","sepuluh","1","2","3","4","5","6","7","8","9","10");
		/*
			Finding all keywords matching all of the words in the search term
		*/
		$search=explode(" ", $search);
		if(count($search)>0){
			foreach($search as $s){
				$s=stripslashes($s);
				$keywords=$db->make_array($db->query("SELECT * FROM keyword_index WHERE keyword LIKE'%".$s."%' AND is_approved='1'"));
				if(count($keywords)>0){
					$this->_words=array_merge($this->_words,$keywords);
				}else{// if count keywords
					$newKeyword=new stdClass();
					$newKeyword->keyword=$s;
					if(!in_array($s, $ignore)){
						$db->save("keyword_index",$newKeyword);
						$newKeyword->id=$db->insert_id();

						Request::Curl(Request::$BASE_URL."admin/index.php/reindex");

						$keywords=$db->select("keyword_index",array("id"=>$newKeyword->id));
						$this->_words=array_merge($this->_words,$keywords);
					}// if ignore
				}
			}// foreach search term
		}//if count search
	}

	public function getAllQuran(){
		global $db;
		/*
			Get ayats for all the words found	
		*/
		if(count($this->_words)>0){
			foreach($this->_words as $word){
				$results1=$this->getQuran($word->id);
				if(is_array($results1)){
					$this->_quran=array_merge($this->_quran,$results1);
				}// If result is an array
			}// Foreach word
		}// If words
	
		/*
			Calculate quran ayats weight based on duplication and remove duplicates
		*/
		if(count($this->_quran)>0){
			
			$ayatIndexes=array();
			foreach($this->_quran as $ayat){
					$ayatIndexes[]=$ayat->id;
			}
			$weights=array_count_values($ayatIndexes);	// Group ayat ids and find how many times they were repeated
			$this->_quran=array();
			foreach($weights as $ayat=>$weight){
				$obj=$db->select_single("quran",array("id"=>$ayat));
				$obj->weight=1.0*$weight;

				$this->_quran[]=$obj;
			}// for each indexes
		}// if quran not empty
	}

	public function getAllHadith(){
		global $db;
		/*
			Get hadiths for all the words found	
		*/
		if(count($this->_words)>0){
			foreach($this->_words as $word){
				$results1=$this->getHadith($word->id);
				if(is_array($results1)){
					$this->_hadith=array_merge($this->_hadith,$results1);
				}// If result is an array
			}// Foreach word
		}// If words
	
		/*
			Calculate quran ayats weight based on duplication and remove duplicates
		*/
		if(count($this->_hadith)>0){
			$hadithIndexes=array();
			foreach($this->_hadith as $hadith){
					$hadithIndexes[]=$hadith->id;
			}
			$weights=array_count_values($hadithIndexes);	// Group hadiths ids and find how many times they were repeated
			$this->_hadith=array();
			foreach($weights as $hadith=>$weight){
				$obj=$db->select_single("hadith",array("id"=>$hadith));
				$obj->weight=1.0*$weight;

				$this->_hadith[]=$obj;
			}// for each indexes
		}// if quran not empty
	}

	public function getAllManuscript(){
		global $db;
		/*
			Get manuscripts for all the words found	
		*/
		if(count($this->_words)>0){
			foreach($this->_words as $word){
				$results1=$this->getManuscript($word->id);
				if(is_array($results1)){
					$this->_manuscript=array_merge($this->_manuscript,$results1);
				}// If result is an array
			}// Foreach word
		}// If words
	
		/*
			Calculate manuscripts weight based on duplication and remove duplicates
		*/
		if(count($this->_manuscript)>0){
			$manuscriptIndexes=array();
			foreach($this->_manuscript as $manuscript){
					$manuscriptIndexes[]=$manuscript->id;
			}
			$weights=array_count_values($manuscriptIndexes);	// Group manuscripts ids and find how many times they were repeated
			$this->_manuscript=array();
			foreach($weights as $manu=>$weight){
				$obj=$db->select_single("manuscript",array("id"=>$manu));
				$obj->weight=1.0*$weight;

				$this->_manuscript[]=$obj;
			}// for each indexes
		}// if manuscript not empty
	}

	public function getAllArticle(){
		global $db;
		/*
			Get articles for all the words found	
		*/
		if(count($this->_words)>0){
			foreach($this->_words as $word){
				$results1=$this->getArticle($word->id);
				if(is_array($results1)){
					$this->_article=array_merge($this->_article,$results1);
				}// If result is an array
			}// Foreach word
		}// If words
	
		/*
			Calculate articles weight based on duplication and remove duplicates
		*/
		if(count($this->_article)>0){
			$articleIndexes=array();
			foreach($this->_article as $article){
					$articleIndexes[]=$article->id;
			}
			$weights=array_count_values($articleIndexes);	// Group articles ids and find how many times they were repeated
			$this->_article=array();
			foreach($weights as $article=>$weight){
				$obj=$db->select_single("scientific_article",array("id"=>$article));
				$obj->weight=1.0*$weight;

				$this->_article[]=$obj;
			}// for each indexes
		}// if article not empty
	}

	public function getAllSynonyms(){
		global $db;
		/*
			Get synonyms of the keywords
		*/
		if(count($this->_words)>0){
			foreach($this->_words as $word){
				$syns=$this->getSynonyms($word->id);
				if($syns){
					foreach($syns as $syn){
						$this->_synonyms[]=$syn;
					}
				}
			}// Foreach word
		}// If words
	
		/*
			Calculate synonyms weight based on duplication and remove duplicates
		*/
		if(count($this->_synonyms)>0){
			$synIndexes=array();
			foreach($this->_synonyms as $syn){
				$synIndexes[]=$syn->id;
			}
			$weights=array_count_values($synIndexes);
			$this->_synonyms=array();
			foreach($weights as $syn=>$weight){
				$obj=$db->select_single("keyword_index",array("id"=>$syn));
				$obj->weight=1.0*$weight;

				$this->_synonyms[]=$obj;
			}
		}
	}

	public function getAllSynonymsQuran(){
		global $db;
		if(count($this->_synonyms)>0){
			/*
				Get quran ayats for each synonym
			*/
			foreach($this->_synonyms as $word){
				$results1=$this->getQuran($word->id);
				if(is_array($results1)){
					$this->_synonyms_quran=array_merge($this->_synonyms_quran,$results1);
				}// If result is an array
			}// Foreach Synonym

			/*
				Calculate quran ayat weight based on duplication and remove duplication
			*/
			if(count($this->_synonyms_quran)>0){
				$ayatIndexes=array();
				foreach($this->_synonyms_quran as $ayat){
						$ayatIndexes[]=$ayat->id;
				}
				$weights=array_count_values($ayatIndexes);	// Group ayat ids and find how many times they were repeated
				$this->_synonyms_quran=array();
				foreach($weights as $ayat=>$weight){
					$obj=$db->select_single("quran",array("id"=>$ayat));
					$obj->weight=0.5*$weight;

					$this->_synonyms_quran[]=$obj;
				}// for each indexes

			}
		}

	}

	public function getAllSynonymsHadith(){
		global $db;
		if(count($this->_synonyms)>0){
			/*
				Get hadiths  for each synonym
			*/
			foreach($this->_synonyms as $word){
				$results1=$this->getHadith($word->id);
				if(is_array($results1)){
					$this->_synonyms_hadith=array_merge($this->_synonyms_hadith,$results1);
				}// If result is an array
			}// Foreach Synonym

			/*
				Calculate quran ayat weight based on duplication and remove duplication
			*/
			if(count($this->_synonyms_hadith)>0){
				$hadithIndexes=array();
				foreach($this->_synonyms_hadith as $hadith){
						$hadithIndexes[]=$hadith->id;
				}
				$weights=array_count_values($hadithIndexes);	// Group ayat ids and find how many times they were repeated
				$this->_synonyms_hadith=array();
				foreach($weights as $hadith=>$weight){
					$obj=$db->select_single("hadith",array("id"=>$hadith));
					$obj->weight=0.5*$weight;

					$this->_synonyms_hadith[]=$obj;
				}// for each indexes

			}
		}

	}

	public function getAllSynonymsManuscript(){
		global $db;
		if(count($this->_synonyms)>0){
			/*
				Get hadiths  for each synonym
			*/
			foreach($this->_synonyms as $word){
				$results1=$this->getManuscript($word->id);
				if(is_array($results1)){
					$this->_synonyms_manuscript=array_merge($this->_synonyms_manuscript,$results1);
				}// If result is an array
			}// Foreach Synonym

			/*
				Calculate manuscript weight based on duplication and remove duplication
			*/
			if(count($this->_synonyms_manuscript)>0){
				$manuscriptIndexes=array();
				foreach($this->_synonyms_manuscript as $manu){
						$manuscriptIndexes[]=$manu->id;
				}
				$weights=array_count_values($manuscriptIndexes);	// Group manuscript ids and find how many times they were repeated
				$this->_synonyms_manuscript=array();
				foreach($weights as $manu=>$weight){
					$obj=$db->select_single("manuscript",array("id"=>$manu));
					$obj->weight=0.5*$weight;

					$this->_synonyms_manuscript[]=$obj;
				}// for each indexes

			}
		}

	}

	public function getAllSynonymsArticle(){
		global $db;
		if(count($this->_synonyms)>0){
			/*
				Get hadiths  for each synonym
			*/
			foreach($this->_synonyms as $word){
				$results1=$this->getArticle($word->id);
				if(is_array($results1)){
					$this->_synonyms_article=array_merge($this->_synonyms_article,$results1);
				}// If result is an array
			}// Foreach Synonym

			/*
				Calculate article weight based on duplication and remove duplication
			*/
			if(count($this->_synonyms_article)>0){
				$articleIndexes=array();
				foreach($this->_synonyms_article as $article){
						$articleIndexes[]=$article->id;
				}
				$weights=array_count_values($articleIndexes);	// Group article ids and find how many times they were repeated
				$this->_synonyms_article=array();
				foreach($weights as $article=>$weight){
					$obj=$db->select_single("scientific_article",array("id"=>$article));
					$obj->weight=0.5*$weight;

					$this->_synonyms_article[]=$obj;
				}// for each indexes

			}
		}

	}

	public function mergeQuran(){
		global $db;
		/*
			Search for similar quran ayats and add corresponding weight, 
			or else add new ayat to the quran ayats
		*/
		if(count($this->_synonyms_quran)>0){
			foreach($this->_synonyms_quran as $sq){
				$done=0;
				foreach($this->_quran as $q){
					if($q->id==$sq->id){
						$q->weight+=$sq->weight;
						$done=1;
					}
				}// foreach quran

				if($done==0){
					$this->_quran[]=$sq;
				}
			}// foreach synonyms quran
		}

		$sorted=array();

	
		foreach($this->_quran as $ayat){
			$index=$this->getHighestIndex();
			if($index>=0){
				$sorted[]=$this->_quran[$index];
				unset($this->_quran[$index]);
				$this->_quran=array_values($this->_quran);
			}
		}
		$this->_quran=$sorted;

	}

	public function mergeHadith(){
		global $db;
		/*
			Search for similar hadiths and add corresponding weight, 
			or else add new hadith to the hadiths
		*/
		if(count($this->_synonyms_hadith)>0){
			foreach($this->_synonyms_hadith as $sq){
				$done=0;
				foreach($this->_hadith as $q){
					if($q->id==$sq->id){
						$q->weight+=$sq->weight;
						$done=1;
					}
				}// foreach quran

				if($done==0){
					$this->_hadith[]=$sq;
				}
			}// foreach synonyms quran
		}

		$sorted=array();

	
		foreach($this->_hadith as $ayat){
			$index=$this->getHighestIndexH();
			if($index>=0){
				$sorted[]=$this->_hadith[$index];
				unset($this->_hadith[$index]);
				$this->_hadith=array_values($this->_hadith);
			}
		}
		$this->_hadith=$sorted;

	}

	public function mergeManuscript(){
		global $db;
		/*
			Search for similar manuscripts and add corresponding weight, 
			or else add new manuscript to the manuscripts
		*/
		if(count($this->_synonyms_manuscript)>0){
			foreach($this->_synonyms_manuscript as $sq){
				$done=0;
				foreach($this->_manuscript as $q){
					if($q->id==$sq->id){
						$q->weight+=$sq->weight;
						$done=1;
					}
				}// foreach manuscript

				if($done==0){
					$this->_manuscript[]=$sq;
				}
			}// foreach synonyms manuscript
		}

		$sorted=array();

	
		foreach($this->_manuscript as $manu){
			$index=$this->getHighestIndexM();
			if($index>=0){
				$sorted[]=$this->_manuscript[$index];
				unset($this->_manuscript[$index]);
				$this->_manuscript=array_values($this->_manuscript);
			}
		}
		$this->_manuscript=$sorted;

	}

	public function mergeArticle(){
		global $db;
		/*
			Search for similar articles and add corresponding weight, 
			or else add new article to the articles
		*/
		if(count($this->_synonyms_article)>0){
			foreach($this->_synonyms_article as $sq){
				$done=0;
				foreach($this->_article as $q){
					if($q->id==$sq->id){
						$q->weight+=$sq->weight;
						$done=1;
					}
				}// foreach manuscript

				if($done==0){
					$this->_article[]=$sq;
				}
			}// foreach synonyms article
		}

		$sorted=array();

	
		foreach($this->_article as $article){
			$index=$this->getHighestIndexA();
			if($index>=0){
				$sorted[]=$this->_article[$index];
				unset($this->_article[$index]);
				$this->_article=array_values($this->_article);
			}
		}
		$this->_article=$sorted;

	}
	
	private function getHighestIndex(){
		$i=0;
		$index=false;
		$highest=-999;
		if(count($this->_quran)>0){
			$index=0;
			foreach($this->_quran as $q){
				if($q->weight>$highest){
					$highest=$q->weight;
					$index=$i;
				}
				$i++;
			}
		}
		return $index;
	}

	private function getHighestIndexH(){
		$i=0;
		$index=false;
		$highest=-999;
		if(count($this->_hadith)>0){
			$index=0;
			foreach($this->_hadith as $q){
				if($q->weight>$highest){
					$highest=$q->weight;
					$index=$i;
				}
				$i++;
			}
		}
		return $index;
	}

	private function getHighestIndexM(){
		$i=0;
		$index=false;
		$highest=-999;
		if(count($this->_manuscript)>0){
			$index=0;
			foreach($this->_manuscript as $q){
				if($q->weight>$highest){
					$highest=$q->weight;
					$index=$i;
				}
				$i++;
			}
		}
		return $index;
	}

	private function getHighestIndexA(){
		$i=0;
		$index=false;
		$highest=-999;
		if(count($this->_manuscript)>0){
			$index=0;
			foreach($this->_manuscript as $q){
				if($q->weight>$highest){
					$highest=$q->weight;
					$index=$i;
				}
				$i++;
			}
		}
		return $index;
	}

	private function processPropheticFood($search){
		global $db;
		/*
		Search for similar prophetic foods, 
		or else add new prophetic food to _prophetic foods
		*/

		foreach($this->_words as $word){$word->weight=1.0;}

		if(count($this->_words)>0){
			if(count($this->_synonyms)>0){
				foreach($this->_synonyms as $sq){
					$done=0;
					foreach($this->_words as $q){
						if($q->id==$sq->id){
							$q->weight+=$sq->weight;
							$done=1;
						}
					}// foreach quran

					if($done==0){
						$this->_words[]=$sq;
					}
				}// foreach synonyms quran
			}
			
			$i=0;
			foreach($this->_words as $word){
				$prophetic_food=$db->make_array($db->query("SELECT * FROM prophetic_food WHERE food LIKE '%".$word->keyword."%' 
															OR trans_english LIKE '%".$word->keyword."%' 
															OR trans_malay LIKE '%".$word->keyword."%' 
															OR trans_arabic LIKE '%".$word->keyword."%'
															AND is_approved='1'
															"));
				if(count($prophetic_food)>0){ 
					foreach($prophetic_food as $foods){
						$this->_prophetic_foods[$i]['word']=$foods->food;
						$this->_prophetic_foods[$i]['index']=$foods->id;
						$i++;

						$this->_prophetic_foods[$i]['word']=$foods->trans_arabic;
						$this->_prophetic_foods[$i]['index']=$foods->id;
						$i++;

						$this->_prophetic_foods[$i]['word']=$foods->trans_english;
						$this->_prophetic_foods[$i]['index']=$foods->id;
						$i++;

						$this->_prophetic_foods[$i]['word']=$foods->trans_malay;
						$this->_prophetic_foods[$i]['index']=$foods->id;
						$i++;
					}// foreach prophetic food
				}// if prophetic food
			}// foreach words

			if(count($this->_prophetic_foods)>0){
				$pFoods=array();
				$correspondingID=array();

				foreach($this->_prophetic_foods as $f){
					if(!in_array($f['word'], $pFoods)){
						$pFoods[]=$f['word'];
						$correspondingID[]=$f['index'];
					}
				}

				// Levenshtein
						$input = $search;
						// no shortest distance found, yet
						$shortest = -1;
						$wordRow=-1;
						$x=0;
						// loop through words to find the closest
						foreach ($pFoods as $word) {
						    // calculate the distance between the input word,
						    // and the current word
						    $lev = levenshtein($input, $word);
						    // check for an exact match
						    if ($lev == 0) {
						        // closest word is this one (exact match)
						        $closest = $word;
						        $shortest = 0;
						        $wordRow=$x;
						        // break out of the loop; we've found an exact match
						        break;
						    }
						    // if this distance is less than the next found shortest
						    // distance, OR if a next shortest word has not yet been found
						    if ($lev <= $shortest || $shortest < 0) {
						        // set the closest match, and shortest distance
						        $closest = $word;
						        $shortest = $lev;
						        $wordRow=$x;
						    }
						}// foreach pfoods

						$this->_selected_pf=$correspondingID[$x];
				// Levenshtein

				$this->_prophetic_foods=array();
				$y=0;
				foreach($pFoods as $p){
					$this->_prophetic_foods[$y]['food']=$p;
					$this->_prophetic_foods[$y]['id']=$correspondingID[$y];
					$y++;
				}
			}// if prophetic foods

		}// if synonyms and keywords
	}

	public function keywordIndexArray($x){
		if($x){
			return $y=explode(",",$x);
		}else{
			return false;
		}
	}// keyword index array function

	public function getQuran($id){
		global $db;
		$quran=false;
		$keyword=$db->select_single("keyword_index",array("id"=>$id));
		if($keyword){
			if($keyword->quran){
				$quran=array();
				$ids=explode(",", $keyword->quran);
				foreach($ids as $i){
					$r=$db->select_single("quran",array("id"=>$i));
					if($r){
						$quran[]= $r;
					}
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
					$r=$db->select_single("hadith",array("id"=>$i));
					if($r){
						$hadith[]= $r;
					}
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
					$r=$db->select_single("manuscript",array("id"=>$i));
					if($r){
						$manuscript[]= $r;
					}
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
					$r=$db->select_single("scientific_article",array("id"=>$i));
					if($r){
						$article[]= $r;
					}
				}
			}
		}
		return $article;
	}// get article function

	public function getSynonyms($id){
			global $db;
			$synonyms=false;
			$syns=$db->make_array($db->query("SELECT * FROM synonyms WHERE keyword_id_1='".$id."' OR keyword_id_2='".$id."'"));
			if($syns){
			$synonyms=array();
				foreach($syns as $syn){
					if($syn->keyword_id_1==$id){
						$r=$db->select_single("keyword_index",array("id"=>$syn->keyword_id_2));
						if($r){
							$synonyms[]= $r;
						}

					}elseif($syn->keyword_id_2==$id){
						$r=$db->select_single("keyword_index",array("id"=>$syn->keyword_id_1));
						if($r){
							$synonyms[]= $r;
						}
					}
				}
			}
			return $synonyms;
		}// get synonyms function
		
}
?>