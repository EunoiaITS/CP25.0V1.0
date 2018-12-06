<?php
class gateway {
    static function Process($parameters = NULL){
        global $db;
        global $session;


        if(!isset($parameters[0]) || $parameters[0] == '') $parameters[0] = 'admin';

        $objPresenter = new Presenter();

        $objPresenter->AddParameter('parameters',$parameters);

        $objPost=Request::getpostvariables();

        if(isset($_GET['p'])){
            $page=$_GET['p'];
        }else{
            $page=0;
        }

        //User Log In Controll
        if(!$session->is_logged_in()){
            //Not Logged in
            if($parameters[0]=="loginAdmin"){
                $parameters[0]="loginAdmin";
            }
        }else{

            //Logged in
            $logged_in= true;
            $objPresenter->AddParameter('logged_in',$logged_in);

            $f=$db->select("prophetic_food",array('is_approved'=>'0'));
            $h=$db->select("hadith",array('is_approved'=>'0'));
            $k=$db->select("keyword_index",array('is_approved'=>'0'));
            $q=$db->select("quran",array('is_approved'=>'0'));
            $m=$db->select("manuscript",array('is_approved'=>'0'));
            $a=$db->select("article",array('is_approved'=>'0'));
            $i=$db->select("additional_information",array('is_approved'=>'0'));

            $total=count($f)+count($h)+count($k)+count($q)+count($m)+count($a)+count($i);
            $objPresenter->AddParameter('approval_no',$total);

            switch($parameters[0]){
                case 'adminHome':
                    $queries=count($db->select("query_log",""));
                    $users=count($db->select("user_public",""));
                    $keywords=count($db->select("keyword_index",""));
                    $pfs=count($db->select("prophetic_food",""));

                    $objPresenter->AddParameter('queries_log',Pagination::queryD("query_log","50",$page));

                    $objPresenter->AddParameter('queries',$queries);
                    $objPresenter->AddParameter('users',$users);
                    $objPresenter->AddParameter('keywords',$keywords);
                    $objPresenter->AddParameter('pfs',$pfs);

                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminHome');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'adminApproval':
                    $objPresenter->AddParameter('food',$f=$db->select("prophetic_food",array('is_approved'=>'0')));
                    $objPresenter->AddParameter('hadith',$h=$db->select("hadith",array('is_approved'=>'0')));
                    $objPresenter->AddParameter('keyword_index',$k=$db->select("keyword_index",array('is_approved'=>'0')));
                    $objPresenter->AddParameter('quran',$q=$db->select("quran",array('is_approved'=>'0')));
                    $objPresenter->AddParameter('manuscript',$m=$db->select("manuscript",array('is_approved'=>'0')));
                    $objPresenter->AddParameter('article',$a=$db->select("article",array('is_approved'=>'0')));
                    $objPresenter->AddParameter('additional_information',$i=$db->select("additional_information",array('is_approved'=>'0')));

                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminApproval');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'adminUsers':
                    $objPresenter->AddParameter('users',$db->select("user",""));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminUsers');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'adminPropheticFood':
                    $objPresenter->AddParameter('food',Pagination::query("prophetic_food","30",$page));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminPropheticFood');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'adminHadith':
                    $objPresenter->AddParameter('hadith',Pagination::query("hadith","30",$page));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminHadith');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'adminManuscript':
                    $objPresenter->AddParameter('manuscript',Pagination::query("manuscript","30",$page));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminManuscript');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'adminArticle':
                    $objPresenter->AddParameter('article',Pagination::query("scientific_article","30",$page));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminArticle');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'adminQuran':
                    $objPresenter->AddParameter('quran',Pagination::query("quran","30",$page));
                    $objPresenter->AddParameter('surah_index',$db->select("surah_index",""));

                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminQuran');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;
                case 'adminZikir':
                    $objPresenter->AddParameter('zikir',Pagination::query("zikir","30",$page));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminZikir');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'zikir_of_the_day':

                    $table = $objPost->table;
                    $id = $objPost->id;

                    $data = new stdClass();
                    $data->id = $objPost->id;
                    $data->zikir_of_the_day = 1;


                    $db->query("UPDATE zikir  set `zikir_of_the_day` = 0 ");

                    $db->save($objPost->table,$data);


                    header("Location: ".request::$BASE_PATH."index.php/adminZikir
                            
                            ");
                    break;
                case 'ayat_of_the_day':

                    $table = $objPost->table;
                    $id = $objPost->id;

                    $data = new stdClass();
                    $data->id = $objPost->id;
                    $data->ayat_of_the_day = 1;


                    $db->query("UPDATE quran  set `ayat_of_the_day` = 0 ");

                    $db->save($objPost->table,$data);


                    header("Location: ".request::$BASE_PATH."index.php/adminQuran");
                    break;

                case 'hadith_of_the_day':

                    $table = $objPost->table;
                    $id = $objPost->id;

                    $data = new stdClass();
                    $data->id = $objPost->id;
                    $data->hadith_of_the_day = 1;


                    $db->query("UPDATE hadith  set `hadith_of_the_day` = 0 ");

                    $db->save($objPost->table,$data);

                    header("Location: ".request::$BASE_PATH."index.php/adminHadith");

                    break;



                case 'adminEditKeywords':
                    if($parameters[1]=="" || $parameters[1]<1){header("Location: ".$_SERVER['HTTP_REFERER']);}else{
                        $keyword=$db->select_single("keyword_index",array("id"=>$parameters[1]));
                        $quran=Keywords::getQuran($keyword->id);
                        $hadith=Keywords::getHadith($keyword->id);
                        $manuscript=Keywords::getManuscript($keyword->id);
                        $article=Keywords::getArticle($keyword->id);
                        $synonyms=Synonyms::getSynonyms($parameters[1]);

                        $ayats=$db->select("quran","");
                        $hadiths=$db->select("hadith","");
                        $manuscripts=$db->select("manuscript","");
                        $articles=$db->select("scientific_article","");

                        $objPresenter->AddParameter('keyword',$keyword);
                        $objPresenter->AddParameter('quran',$quran);
                        $objPresenter->AddParameter('ayats',$ayats);
                        $objPresenter->AddParameter('hadith',$hadith);
                        $objPresenter->AddParameter('hadiths',$hadiths);
                        $objPresenter->AddParameter('manuscript',$manuscript);
                        $objPresenter->AddParameter('manuscripts',$manuscripts);
                        $objPresenter->AddParameter('article',$article);
                        $objPresenter->AddParameter('articles',$articles);
                        $objPresenter->AddParameter('synonyms',$synonyms);


                        $objPresenter->AddTemplate('AdminHeader');
                        $objPresenter->AddTemplate('AdminEditKeywords');
                        $objPresenter->AddTemplate('AdminFooter');
                    }
                    break;

                case 'adminEditQuran':
                    if($parameters[1]=="" || $parameters[1]<1){header("Location: ".$_SERVER['HTTP_REFERER']);}else{
                        $quran=$db->select_single("quran",array("id"=>$parameters[1]));
                        $additional_information=$db->select("additional_information",array("type"=>"quran","type_id"=>$parameters[1]));

                        $objPresenter->AddParameter('quran',$quran);
                        $objPresenter->AddParameter('additional_information',$additional_information);


                        $objPresenter->AddTemplate('AdminHeader');
                        $objPresenter->AddTemplate('AdminEditQuran');
                        $objPresenter->AddTemplate('AdminFooter');
                    }
                    break;

                case 'adminEditHadith':
                    if($parameters[1]=="" || $parameters[1]<1){header("Location: ".$_SERVER['HTTP_REFERER']);}else{
                        $hadith=$db->select_single("hadith",array("id"=>$parameters[1]));
                        $additional_information=$db->select("additional_information",array("type"=>"hadith","type_id"=>$parameters[1]));

                        $objPresenter->AddParameter('hadith',$hadith);
                        $objPresenter->AddParameter('additional_information',$additional_information);


                        $objPresenter->AddTemplate('AdminHeader');
                        $objPresenter->AddTemplate('AdminEditHadith');
                        $objPresenter->AddTemplate('AdminFooter');
                    }
                    break;

                case 'adminEditManuscript':
                    if($parameters[1]=="" || $parameters[1]<1){header("Location: ".$_SERVER['HTTP_REFERER']);}else{
                        $manuscript=$db->select_single("manuscript",array("id"=>$parameters[1]));
                        $additional_information=$db->select("additional_information",array("type"=>"manuscript","type_id"=>$parameters[1]));

                        $objPresenter->AddParameter('manuscript',$manuscript);
                        $objPresenter->AddParameter('additional_information',$additional_information);


                        $objPresenter->AddTemplate('AdminHeader');
                        $objPresenter->AddTemplate('AdminEditManuscript');
                        $objPresenter->AddTemplate('AdminFooter');
                    }
                    break;

                case 'adminEditArticle':
                    if($parameters[1]=="" || $parameters[1]<1){header("Location: ".$_SERVER['HTTP_REFERER']);}else{
                        $article=$db->select_single("scientific_article",array("id"=>$parameters[1]));
                        $additional_information=$db->select("additional_information",array("type"=>"scientific_article","type_id"=>$parameters[1]));

                        $objPresenter->AddParameter('article',$article);
                        $objPresenter->AddParameter('additional_information',$additional_information);


                        $objPresenter->AddTemplate('AdminHeader');
                        $objPresenter->AddTemplate('AdminEditArticle');
                        $objPresenter->AddTemplate('AdminFooter');
                    }
                    break;

                case 'adminEditPropheticFood':
                    if($parameters[1]=="" || $parameters[1]<1){header("Location: ".$_SERVER['HTTP_REFERER']);}else{
                        $food=$db->select_single("prophetic_food",array("id"=>$parameters[1]));
                        $additional_information=$db->select("additional_information",array("type"=>"prophetic_food","type_id"=>$parameters[1]));

                        $objPresenter->AddParameter('food',$food);
                        $objPresenter->AddParameter('additional_information',$additional_information);


                        $objPresenter->AddTemplate('AdminHeader');
                        $objPresenter->AddTemplate('AdminEditPropheticFood');
                        $objPresenter->AddTemplate('AdminFooter');
                    }
                    break;

                case 'adminUnlinkSynonyms':
                    if(isset($parameters[1]) && isset($parameters[2])){
                        Synonyms::unLink($parameters[1],$parameters[2]);
                    }else{
                        alert("Incorrect Data");
                    }
                    break;

                case 'adminUnlinkQuran':
                    if(isset($parameters[1]) && isset($parameters[2])){
                        Quran::unLink($parameters[1],$parameters[2]);
                    }else{
                        alert("Incorrect Data");
                    }
                    break;

                case 'adminUnlinkHadith':
                    if(isset($parameters[1]) && isset($parameters[2])){
                        Hadith::unLink($parameters[1],$parameters[2]);
                    }else{
                        alert("Incorrect Data");
                    }
                    break;

                case 'adminUnlinkManuscript':
                    if(isset($parameters[1]) && isset($parameters[2])){
                        Manuscript::unLink($parameters[1],$parameters[2]);
                    }else{
                        alert("Incorrect Data");
                    }
                    break;

                case 'adminUnlinkArticle':
                    if(isset($parameters[1]) && isset($parameters[2])){
                        Article::unLink($parameters[1],$parameters[2]);
                    }else{
                        alert("Incorrect Data");
                    }
                    break;

                case 'adminKeywords':
                    $objPresenter->AddParameter('keyword_index',Pagination::query("keyword_index","30",$page));

                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminKeywords');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;
                
                case 'adminTransactions':
                    
                    $transactions=Pagination::queryD("user_wallet_transaction","30",$page);
                    
                    if(isset($transactions) && count($transactions)>0){
                        foreach($transactions as $t){
                            $user=$db->select_single('user_public',array('id'=>$t->user_public_id));
                            $t->user=$user;
                            
                            if($t->transaction_json!=""){
                                $t->payment=json_decode($t->transaction_json);
                            }else{
                                $t->payment="";
                            }

                            if($t->package_id!=0){
                                $t->package=$db->select_single('subscription_packages',array('id'=>$t->package_id));
                            }else{
                                $t->package="";
                            }
                        }
                    }
                    
                    $objPresenter->AddParameter('transactions',$transactions);

                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminTransactions');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                case 'adminReindex':
                    Keywords::reindex();
                    header("Location: ".$_SERVER['HTTP_REFERER']);
                    break;

                case 'adminDelete':
                    if(isset($parameters[1]) && $parameters[1]!="" && table_exists($parameters[1]) && isset($parameters[2]) && $parameters[2]>0){
                        $db->query("DELETE FROM ".$parameters[1]." WHERE id='".$parameters[2]."'");
                        alert("Deleted!");
                    }else{
                        alert("Incorrect Data!");
                    }
                    break;
                //Forum Management
                case 'adminForum':
                    $objPresenter->AddParameter('topic',Pagination::query("forum_topic","10",$page));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminForum');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;
                case 'adminForumComments':
                    if($parameters[1]=="" || $parameters[1]<1){header("Location: ".$_SERVER['HTTP_REFERER']);}else{
                        $topic_id = $parameters[1];
                        $comments=$db->make_array($db->query("SELECT c.message,c.is_approved,c.id as comment_id,c.topic_id,u.id as user_public_id,u.username FROM `comments` c 
                               inner join user_public u on c.user_public_id = u.id where c.topic_id = '".$topic_id."'"));
                        
                        if (isset($comments) && count($comments)>0) {
                           
                        foreach ($comments as $obj) {
                            $id = $obj->comment_id;
                            $comments_reply1 = $db->make_array($db->query
                            ("SELECT * FROM `comments_reply` cr where
                                 cr.topic_id = '" . $topic_id . "' and cr.comment_id = '" . $id . "' "));
                            
                            if (isset($comments_reply1) && count($comments_reply1)>0) {
                                $object = (object)$comments_reply1;

                                foreach ($object as $o) {
                                    $obj->reply = $o->reply;
                                }

                            }
                        }
                    }       
                               
                               
                        $objPresenter->AddParameter('comments',$comments);
                      

                        $objPresenter->AddTemplate('AdminHeader');
                        $objPresenter->AddTemplate('AdminForumComments');
                        $objPresenter->AddTemplate('AdminFooter');
                    }
                    break;

                case 'adminEvents':
                    $objPresenter->AddParameter('event',Pagination::query("events","10",$page));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminEvents');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;
                case 'adminAdvertisements':
                    $objPresenter->AddParameter('advertisement',Pagination::query("advertisement","10",$page));
                    $objPresenter->AddTemplate('AdminHeader');
                    $objPresenter->AddTemplate('AdminAdvertisements');
                    $objPresenter->AddTemplate('AdminFooter');
                    break;

                default:
                    if(!$session->is_logged_in()){
                        header("Location: ".request::$BASE_PATH."index.php/adminHome");
                    }
                    break;
            }//switch admin ends
        }

        /***LOGIN Manager***/

        switch ($parameters[0]){
            case 'loginAdmin':
                $object= Request::getPostVariables();
                if(isset($object->password)){
                    $login= User::login($object);
                }
                if($session->is_logged_in()){
                    header("location:".request::$BASE_URL."index.php/adminHome");
                }
                else{
                    header("location:".request::$BASE_URL."index.php/login");
                }
                break;


            case 'logout':
                unset($_SESSION['user_id']);
                unset($_SESSION['user_name']);

                header("location:".request::$BASE_PATH."index.php/admin");
                break;
            /***LOGIN Cases***/

            case 'reindex':
                Keywords::reindex();
                header("Location: ".$_SERVER['HTTP_REFERER']);
                break;

            case 'ajax':
                $obj= NULL;
                foreach($_POST as $key=>$value){
                    $obj->$key=$value;
                }
                $db->save($objPost->table,$obj);
                break;

            // case 'delete':
            // $sql= "DELETE FROM ".$_POST['table']." WHERE id='".$_POST['id']."'";
            // $db->query($sql);
            // break;

            case 'login':
                $objPresenter->AddTemplate('AdminHeader');
                $objPresenter->AddTemplate('AdminLogin');
                $objPresenter->AddTemplate('AdminFooter');
                break;


            case 'home':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('Home');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title','Naqli Aqli');
                break;

            case 'admin':
                header("location:".request::$BASE_URL."index.php/loginAdmin");
                break;

            case 'post':
                $obj= new stdClass();
                foreach($_POST as $key=>$value){
                    if($key=="data"){
                        $obj->$key=strip($value);
                    }else if($key=="password"){
                        $obj->$key=md5($value);
                    }else{
                        $obj->$key=$value;
                    }
                }


                if(isset($_FILES['path']) && $_FILES['path']['name']!=""){
                    $obj->path=Request::$BASE_PATH."images/".$_FILES['path']['name'];
                    $obj->short_path="images/".$_FILES['path']['name'];
                    image_upload($_FILES['path']['name'], $_FILES['path']['tmp_name']);

                }
                $db->save($objPost->table,$obj);
                header("Location: ".$_SERVER['HTTP_REFERER']);
                break;

            case 'addSynonym':
                Synonyms::add($objPost);
                break;

            case 'addKeyword':
                if(isset($objPost->keyword)){
                    Keywords::add($objPost->keyword);
                }
                break;

            case 'linkSynonym':
                Synonyms::link($objPost);
                break;

            case 'linkQuran':
                if(isset($objPost->quran_id) && isset($objPost->keyword_id)){
                    Quran::linkQuran($objPost->keyword_id,$objPost->quran_id);
                    alert("Quran linked successfully",$_SERVER['HTTP_REFERER']);
                }else{
                    alert("ERROR: Data not found",$_SERVER['HTTP_REFERER']);
                }
                break;

            case 'linkHadith':
                if(isset($objPost->hadith_id) && isset($objPost->keyword_id)){
                    Hadith::linkHadith($objPost->keyword_id,$objPost->hadith_id);
                    alert("Hadith linked successfully",$_SERVER['HTTP_REFERER']);
                }else{
                    alert("ERROR: Data not found",$_SERVER['HTTP_REFERER']);
                }
                break;

            case 'linkManuscript':
                if(isset($objPost->manuscript_id) && isset($objPost->keyword_id)){
                    Manuscript::linkManuscript($objPost->keyword_id,$objPost->manuscript_id);
                    alert("Manuscript linked successfully",$_SERVER['HTTP_REFERER']);
                }else{
                    alert("ERROR: Data not found",$_SERVER['HTTP_REFERER']);
                }
                break;

            case 'linkArticle':
                if(isset($objPost->article_id) && isset($objPost->keyword_id)){
                    Article::linkArticle($objPost->keyword_id,$objPost->article_id);
                    alert("Article linked successfully",$_SERVER['HTTP_REFERER']);
                }else{
                    alert("ERROR: Data not found",$_SERVER['HTTP_REFERER']);
                }
                break;

            case 'selectKeyword':
                $data=array();
                if(isset($_GET['q'])){
                    $q=strip_tags(trim($_GET['q']));
                    $results=$db->make_array($db->query("SELECT * FROM keyword_index WHERE keyword LIKE '%".$q."%'"));
                    if($results){
                        foreach($results as $r){
                            $result=array("id"=>$r->id,"keyword"=>$r->keyword);
                            //echo '<option value="'.$r->id.'">'.$r->keyword.'</option>';
                            $data[]=$result;
                        }
                        echo json_encode($data);
                    }
                }
                break;



            default:
                if(!$session->is_logged_in()){
                    header("Location: ".request::$BASE_PATH);
                }
                break;
        }

        $objPresenter->AddParameter('title','Naqli Aqli');
        $objPresenter->Publish();
    }
}