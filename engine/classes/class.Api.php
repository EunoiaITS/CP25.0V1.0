<?php
require_once('engine/classes/class.phpmailer.php');
class api {
    static function Process($parameters = NULL){
        global $db;
        global $session;
        // header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');


        $objPresenter = new Presenter();

        $objPresenter->AddParameter('parameters',$parameters);

        $objPost=Request::getpostvariables();

        switch($parameters[2]){
            
            case 'addPicture':
                $obj= new stdClass();
                if(isset($_FILES['file']) && $_FILES['file']['name']!=""){
					
					$obj->path=Request::$BASE_PATH."images/".$_FILES['file']['name'];
					
					$obj->short_path="images/".$_FILES['file']['name'];
				 	
				 	image_upload($_FILES['file']['name'], $_FILES['file']['tmp_name']);
    	
    				$obj->id=$_POST['user_id'];
    				
    			    $db->save('user_public',$obj);

                    echo json_encode("success");   
                }
				
                break;
            
            case 'addAD':
                $obj= new stdClass();
                if(isset($_FILES['file']) && $_FILES['file']['name']!=""){
					
					$obj->path=Request::$BASE_PATH."images/".$_FILES['file']['name'];
					
					$obj->short_path="images/".$_FILES['file']['name'];
				 	
				 	image_upload($_FILES['file']['name'], $_FILES['file']['tmp_name']);
    	
    				$obj->user_id=$_POST['user_id'];
    				$obj->link=$_POST['url'];
    				$obj->is_approved=0;
    				
    			    $db->save('advertisement',$obj);

                    echo json_encode("success");   
                }
				
                break;
                
            case 'payment':
                // echo '<script type="text/javascript">;';
                // echo    'window.close();';
                // echo '</script>';
                if (isset($_GET['id']) && $_GET['id']!="") {
                    $r=$_GET['id'];
                    
                        $result = $db->select_single('user_public', array('id' => $r));
                        
                        $package = $db->select_single('subscription_packages', array('id' =>$_GET['subscription_package_id'] ));
                            
                        $trans=new stdClass();
                        $trans->user_public_id=$result->id;
                        $trans->package_id=$package->id;
                        $trans->description="ATTEMPT TO BUY";
                        $trans->typ=1;
                        $trans_id=$db->save('user_wallet_transaction',$trans);
                        
                        $user_data = new stdClass();
                        $user_data->user_id  = $result->id;
                        $user_data->trans_id  = $trans_id;
                        $user_data->username  = $result->username;
                        $user_data->email  = $result->email;
                        $user_data->phone_no  = $result->phone_no;
                        $user_data->package  = $package->price;
                        
                        
                        header("Location: " . request::$BASE_PATH . "index.php/payment?data=".urldecode(serialize($user_data)));
                    

                } else {
                   $_SESSION['msg_error'] = 'User Not Found';
                  header("Location: " . $_SERVER['HTTP_REFERER']);
                }
                break;
            
            case 'events':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $additional=$db->select('events',array(''));
                    $result = strip($additional);
                    if(isset($additional)) {
                        echo json_encode(array('status' => "success", 'additional' => $result));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }
                break;
                
                case 'forums':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $additional=$db->select('forum_topic',array(''));
                    $result = strip($additional);
                    if(isset($additional)) {
                        echo json_encode(array('status' => "success", 'additional' => $result));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }
                break;
                
                case 'postForumComment':
                if ($_SERVER['REQUEST_METHOD'] == 'GET'  && isset($_GET['id']) && $_GET['id']!="") {
                    $obj = new stdClass();
                    $obj->topic_id=$_GET['id'];
                    $obj->user_public_id=$_GET['userId'];
                    $obj->message=$_GET['comment'];
                    $obj->is_approved=0;
                    
                    $r=$db->save('comments',$obj);
                    
                    if($r) {
                        echo json_encode(array('status' => "success"));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }
                break;
                
                case 'forumComments':
                if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && $_GET['id']!="") {
                    
                    $data = $db->select_single('forum_topic', array('id' => $_GET['id']));
                    //$comments_reply=$db->select("comments_reply",array());
                    $topic_id = $_GET['id'];
                    $comments = $db->make_array($db->query("SELECT c.message,c.created ,c.id,c.topic_id,u.username FROM
                            `comments` c inner join user_public u on c.user_public_id = u.id where c.topic_id = '" . $topic_id . "'
                             and c.is_approved=1 order by c.created desc"));
                    
                    
                    
                    if (isset($comments) && count($comments)>0) {
                        foreach ($comments as $obj) {
                            $topic_id = $obj->topic_id;
                            $id = $obj->id;
                            $comments_reply1 = $db->make_array($db->query
                            ("SELECT * FROM `comments_reply` cr where
                                 cr.topic_id = '" . $topic_id . "' and cr.comment_id = '" . $id . "' "));
                            if (isset($comments_reply1)) {
                                $object = (object)$comments_reply1;

                                foreach ($object as $o) {

                                    $obj->reply = $o->reply;
                                }

                            }else{
                                $obj->reply = "";
                            }
                        }
                    }
                    
                    $result = strip($comments);
                    
                    if(isset($result) && count($result)>0) {
                        echo json_encode(array('status' => "success", 'additional' => $result));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }
                break;
                
                 case 'subscription_packages':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $subscription_packages = $db->select('subscription_packages',array(''));
                    $result = strip($subscription_packages);
                    if(isset($result)) {
                        echo json_encode(array('status' => "success", 'subscription_packages' => $result));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                    //$objPresenter->AddTemplate('AboutUs');
                }
                break;

            case 'ayat_of_the_day':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $additional=$db->select('quran',array('ayat_of_the_day'=>1));
                    $result = strip($additional);
                    if(isset($additional)) {
                        echo json_encode(array('status' => "success", 'additional' => $result));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                    //$objPresenter->AddTemplate('AboutUs');
                }
                break;

            case 'hadith_of_the_day':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $additional=$db->select('hadith',array('hadith_of_the_day'=>1));
                    $result = strip($additional);
                    if(isset($additional)) {
                        echo json_encode(array('status' => "success", 'additional' => $result));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                    //$objPresenter->AddTemplate('AboutUs');
                }
                break;

            case 'zikir_of_the_day':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $additional=$db->select('zikir',array('zikir_of_the_day'=>1));
                    $result = strip($additional);
                    if(isset($additional)) {
                        echo json_encode(array('status' => "success", 'zikir' => $result));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                    //$objPresenter->AddTemplate('AboutUs');
                }
                break;

            case 'home':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                    $advertisement = $db->select('advertisement',array(''),$col="position",$sq="ASC");
                    $keywords = $db->make_array($db->query("SELECT * from keyword_index where is_approved = 1"));
                    $data = new stdClass();
                    $ad = new stdClass();

                    if(isset($keywords) && isset($advertisement) ) {
                        $data = $keywords;
                        $ad = $advertisement;
                        foreach ($data as $k){
                            $k->keyword_id = $k->id;
                            unset($k->created);
                            unset($k->id);
                            unset($k->is_active);
                            unset($k->is_approved);
                        }
                        foreach ($ad as $a){
                            unset($a->created);
                            unset($a->id);
                            unset($a->is_active);
                            unset($a->is_approved);
                            unset($a->position);
                        }

                    }

                    if(isset($keywords) && isset($advertisement) ) {
                        echo json_encode(array('status' => "success", 'keywords' => $data,'advertisement' => $advertisement));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                    //$objPresenter->AddTemplate('AboutUs');
                }
                break;
            case 'propheticfoods':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $prophetic_foods=$db->select('prophetic_food',array(''),$col="food",$sq="ASC");
                    $result = strip($prophetic_foods);
                    $resultstrip = new stdClass();
                    $resultstrip = $prophetic_foods;
                    foreach ($resultstrip as $pf){
                        $pf->stripresult=strip_tags($pf->description);
                        $pf->description_striped = preg_replace('~[\r\n\t]+~', '', $pf->stripresult);
                        unset($pf->stripresult);
                        unset($pf->description);
                        $pf->stripdefinition=strip_tags($pf->definition);
                        $pf->definition_striped = preg_replace('~[\r\n\t]+~', '', $pf->stripdefinition);
                        unset($pf->stripdefinition);
                        unset($pf->definition);

                    }
                    if(isset($prophetic_foods)) {
                        echo json_encode(array('status' => "success", 'prophetic_foods' => $resultstrip));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }
                break;

            case 'results':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $results = false;
                    
                    if(isset($_GET['user_id'])){
                        $wallet=$db->select('user_wallet_transaction',array('user_public_id'=>$_GET['user_id'],'active'=>1),"id","DESC");
                        if(count($wallet)>0){
                            $p=$db->select_single('subscription_packages',array('id'=>$wallet[0]->package_id));
                            if($p->price==0){
                            
                                $q=$db->select('query_log',array('user_id'=>$_GET['user_id']));
                                
                                if(count($q)>3){
                                    $wallet[0]->active=0;
                                    $db->save('user_wallet_transaction',$wallet[0]);
                                    echo json_encode("expired");
                                    exit();
                                }
                            }
                        }else{
                            echo json_encode("expired");
                            exit();
                        }
                    }

                    if (isset($_GET['search']) && $_GET['search'] != "") {

                        $query_log = new stdClass();
                        $query_log->query = $_GET['search'];
                        $query_log->ip_address = $_SERVER['REMOTE_ADDR'];
                        if (isset($_GET['user_id'])) {
                            $query_log->user_id = $_GET['user_id'];
                        }

                        $previousQ = $db->select_single("query_log", array("query" => $query_log->query, "ip_address" => $query_log->ip_address));
                        if (!isset($previousQ->id)) {
                            $db->save("query_log", $query_log);
                        }

                        $result = new Result($_GET['search']);


                        if ($result->_quran) {
                            foreach ($result->_quran as $res) {
                                $res->surah = $db->select_single("surah_index", array("id" => $res->surah));
                            }
                        }

                        if ((!isset($_GET['pf']) || $_GET['pf'] == "") && $result->_selected_pf > 0) {
                            $params = array_merge($_GET, array("pf" => $result->_selected_pf));
                            $new_query_string = http_build_query($params);
                            header("location:" . Request::$BASE_URL . "index.php/api/v1/results?" . $new_query_string);
                            break;
                        }

                        if (isset($_GET['pf']) && $_GET['pf'] != "" && is_numeric($_GET['pf'])) {
                            $pf = $db->select_single("prophetic_food", array("id" => $_GET['pf']));
                            if (isset($pf->id)) {
                                //$objPresenter->AddParameter('prophetic_food', $pf);
                                $addPf = $db->select("additional_information", array("type" => "prophetic_food", "type_id" => $pf->id));
                                if (count($addPf) > 0) {
                                    //$objPresenter->AddParameter('addPf', $addPf);
                                }
                            }
                        }

                        if (count($result->_prophetic_foods) > 0) {
                            $pfs = array();
                            $z = 0;
                            foreach ($result->_prophetic_foods as $f) {

                                $pfs[$z]['name'] = $f['food'];

                                $params = array_merge($_GET, array("pf" => $f['id']));
                                $new_query_string = http_build_query($params);
                                $url = Request::$BASE_URL . "index.php/api/v1/results?" . $new_query_string;

                                $pfs[$z]['url'] = $url;
                                $z++;
                            }

                            //  $objPresenter->AddParameter('pfs', $pfs);

                        }

//                                    $objPresenter->AddParameter('quran', $result->_quran);
//                                    $objPresenter->AddParameter('hadiths', $result->_hadith);
//                                    $objPresenter->AddParameter('manuscripts', $result->_manuscript);
//                                    $objPresenter->AddParameter('articles', $result->_article);
                    }

//                                $objPresenter->AddParameter('search', $_GET['search']);

                    if(isset($result) && isset($pfs) && isset($pf) && isset($addPf)) {
                        echo json_encode(array('status' => "success",'articles' => $result->_article,'manuscripts'=> $result->_manuscript,
                            'hadiths'=>$result->_hadith,'quran'=>$result->_quran,'pfs'=>$pfs, 'prophetic_food' => $pf,'addPf'=>$addPf,'prevquery'=>$previousQ));
                        return;
                    }elseif (isset($result)){
                        echo json_encode(array('status' => "success",'articles' => $result->_article,'manuscripts'=> $result->_manuscript,
                            'hadiths'=>$result->_hadith,'quran'=>$result->_quran));
                        return;
                    }
                    else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }
                break;

            case 'signup_test':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//                                date_default_timezone_set("Asia/Karachi");


                    $data = json_decode(file_get_contents("php://input"));

//                                print_r($data);
                    //die;


                    $result = $db->select_single('user_public',array('email'=>$data->email));
                    if (!empty($result)){
                        echo json_encode(array('status' => "Error",'msg'=>"Email already exsists"));
                        return;
                    }
                    $r =$db->save("user_public",$data);
                    if(!empty($r)) {
                        $wallet_data = new stdClass();
                        $wallet_data->user_public_id = $r;
                        if ($wallet_data->user_public_id != 0){
                            $wallet = $db->save("user_wallet",$wallet_data);
                        }
                        if(!empty($wallet)){
                            $result = $db->select_single('user_public',array('id'=>$r));
                            $result->user_wallet_id = $wallet;
                            $db->save("user_public",$result);
                            echo json_encode(array('status' => "success", 'user_data' => $result));
                            return;
                        }else{
                            echo json_encode(array('status' => "Error", 'msg' => "wallet not created"));
                            return;
                        }

                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }
                break;

            case 'signup':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $data = json_decode(file_get_contents("php://input"));
                    $data->field_of = json_encode($data->field_of);
                    
                    if(isset($data->id) && $data->id!=""){
                        if(isset($data->password) && $data->password!=""){
                            $data->password = md5($data->password);
                        }else{
                            unset($data->password);
                        }
                        $r =$db->save("user_public",$data);
                    }else{
                        $result = $db->select_single('user_public',array('email'=>$data->email));
                        if (!empty($result)){
                            echo json_encode(array('status' => "Error",'msg'=>"Email already exsists"));
                            return;
                        }
                        $data->password = md5($data->password);
                        $r =$db->save("user_public",$data);
                    
                        if($data->subscription_package_id==0){
                            $trans=new stdClass();
                            $trans->user_public_id=$r;
                            $trans->package_id=1;
                            $trans->active=1;
                            $trans->description="FREE TRAIL MOBILE APP";
                            $db->save('user_wallet_transaction',$trans);
                        }
                    }

                    $arr=array();
                    $arr['status']="success";
                    $arr['user_id']=$r;
                    echo json_encode($arr);
                }
                break;




            case 'login':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//                                date_default_timezone_set("Asia/Karachi");


                    $data = json_decode(file_get_contents("php://input"));
                    $login = new stdClass();
                    if(isset($data->password)){
                        $password = md5($data->password);
                        $login->email = $data->email;
                        $login->password = $password;

                        $result = $db->select_single('user_public',array('email'=>$login->email,'password'=>$password));

                    }


                    if(isset($result->id)) {
                        $result->field_of = json_decode($result->field_of);
                        
                        $wallet=$db->select('user_wallet_transaction',array('user_public_id'=>$result->id,'active'=>1),"id","DESC");
                        
                        $p=$db->select_single('subscription_packages',array('id'=>$wallet[0]->package_id));
                        
                        
                        if(count($wallet)>0){
                        
                        echo json_encode(array('status' => "success", 'user_data' => $result,'package'=>$p));
                        }else{
                            echo json_encode(array('status' => "success", 'user_data' => $result,'package'=>NULL));
                        }
                        
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }
                break;


            case 'forgot_password':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $data = json_decode(file_get_contents("php://input"));
                    //var_dump($data);die;

                    $user = $db->select_single('user_public',array('email'=>$data->email));
                    if (!empty($user)) {
                        $code = md5(crypt(rand(), 'st'));
                        $user->reset_link_time = date('Y-m-d H:i:s');
                        $user->reset_link_code = $code;

                        $r =$db->save("user_public",$user);
                        $email = $user->email;
                        if (!empty($email)) {

                            $mail = new PHPMailer(false);
                            $msg =' <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title> reset password</title>


<style type="text/css">
img {
max-width: 100%;
}
body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
  body {
    padding: 0 !important;
  }
  h1 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h2 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h3 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h4 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h1 {
    font-size: 22px !important;
  }
  h2 {
    font-size: 18px !important;
  }
  h3 {
    font-size: 16px !important;
  }
  .container {
    padding: 0 !important; width: 100% !important;
  }
  .content {
    padding: 0 !important;
  }
  .content-wrap {
    padding: 10px !important;
  }
  .invoice {
    width: 100% !important;
  }
}
</style>
</head>

<body itemscope itemtype="http://58.27.220.110:201/MVP/MVP-Dashboard/Login" style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

<table class="body-wrap" style="font-family:Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
		<td class="container" width="600" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
			<div class="content" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
				<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://58.27.220.110:201/MVP/MVP-Dashboard/Login" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
							<meta itemprop="name" content="Confirm Email" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
										Hey there,<br>

You are receiving this email as someone (hopefully you) has indicated that you have forgotten your password. If this is correct, please click reset password button to reset your password:<br>


Thank you for using Naisse App!
									</td>
								</tr><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
										<a href=" '. Request::$BASE_URL . 'forgot_password?code=' . $code . '"  class="btn-primary" itemprop="url" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Reset Password</a>
									</td>
								</tr><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
										&mdash; Naisse.org Team<br>
                                                                                
                                                                                W: www.naisse.org.com  
									</td>
								</tr></table></td>
					</tr></table><div class="footer" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
					<table width="100%" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
						</tr></table></div></div>
		</td>
		
	</tr></table></body>
</html>';

                            $mail->AddAddress($data->email, "usman");
                            $mail->SetFrom('admin@naissesearch.wasiqgh.com', 'Admin');
                            $mail->AddReplyTo('name@yourdomain.com', 'First Last');
                            $mail->Subject = "forgot password";
                            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                            $mail->MsgHTML($msg);

                            $mail->Send();

                            // print_r($mail);

//
//                                    date_default_timezone_set('asia/karachi');
//                                    $date = date('Y/m/d h:i:s ', time());
//                                    $update_data = array('doc_reset_code' => $code,
//                                        'doc_reset_time' => $date
//                                    );
//                                    $result = $this->Doctor_model->updateDoctorCode($doc_email, $update_data);
//                                    if ($result) {
//                                        $this->email->send();
//                                        echo json_encode(array('status' => "success", 'msg' => " Reset password email sent to your email id "));
//                                        return;
//                                    }
//                                    echo json_encode(array('status' => "error", 'msg' => "Invalid Email"));
//                                    return;
//                                }

                            echo json_encode(array('status' => "success", "msg" => "Reset Password email sent on your email id"));
                            return;
                        }
                    }else{
                        echo json_encode(array('status' => "error", "msg" => "User not found"));
                        return;
                    }
                }

                break;

            case 'glob':
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//                                date_default_timezone_set("Asia/Karachi");

                    header("Location: ".request::$BASE_PATH."index.php/glob");
                }
                break;

            case 'page':
                if(($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['type']) && isset($_GET['id']) && $_GET['type']!="" && is_numeric($_GET['id'])){
                    $data=$db->select_single($_GET['type'],array('id'=>$_GET['id']));
                    if(isset($data->id)){
                        $page=array();
                        $additional=$db->select('additional_information',array('type'=>$_GET['type'],'type_id'=>$data->id));

                        switch($_GET['type']){
                            case 'quran':
                                $surah=$db->select_single('surah_index',array('id'=>$data->surah));
                                $page['ayat']=$data->ayat;
                                $page['verse']=$data->verse;
                                $page['trans_arabic']=$surah->surah;
                                $page['surah_english']=$surah->trans_english;
                                $page['meaning_english']=$surah->meaning_english;
                                $page['Surah_no']=$surah->id;
                                $page['ayat_trans_eng']=$data->trans_english;
                                $page['ayat_trans_malay']=$data->trans_malay;

                                break;

                            case 'hadith':
                                $page['Kitab']=$data->kitab;
                                $page['Bab']=$data->bab;
                                $page['Vol']=$data->vol;
                                $page['Page']=$data->page;
                                $page['hadith']=$data->hadith_no;
                                $page['trans_arabic']=$data->trans_arabic;
                                $page['trans_english']=$data->trans_english;
                                $page['trans_malay']=$data->trans_malay;
                                break;

                            case 'manuscript':
                                if($data->path){
                                    $ori_img = $data->short_path;
                                    $ori_text = $data->trans_arabic;
                                }else{
                                    $ori=$data->trans_arabic;
                                }

                                $page['manuscript']=$data->manuscript_no;
                                $page['bab']=$data->bab;
                                $page['page']=$data->page;
                                $page['original_text']=$ori_text;
                                $page['img_short_path']=$ori_img;
                                $page['english']=$data->trans_english;
                                $page['malay']=$data->trans_malay;
                                break;

                            case 'scientific_article':
                                $page['article_name']= $data->name;
                                $page['article_author']=$data->author;
                                $page['article_url']=$data->url;
                                $page['abstract_text']=$data->abstract;
                                $page['concept']=$data->concept;
                                break;

                            case 'prophetic_food':
                                $additional="";
                                $pf=$db->select_single("additional_information",array("id"=>$_GET['info_id']));
                                if(isset($pf->id)){
                                    $objPresenter->AddParameter('pf',$pf);
                                }
                                break;
                            
                            case 'additional_information':
                                $page['title']= $data->type_title;
                                $page['information']=$data->information;
                                break;

                        }

                        if($additional){
                            foreach($additional as $add){
                                $type_title = preg_replace('/\s+/', '_', $add->type_title);
                                $page[$type_title] = $add->information;
                            }
                        }

                        echo json_encode(array('status' => "success", 'data' => $page));
                        return;
                    }else{
                        echo json_encode(array('status' => "empty"));
                        return;
                    }
                }else{
                    echo json_encode(array('status' => "empty"));
                    return;
                }
                break;


            default:
//						    echo("Switch default");
                if(!$session->is_logged_in()){
                    header("Location: ".request::$BASE_PATH."index.php/adminHome");
                }
                break;
        }//switch admin ends
//						}//isset permission
        //}

    }
}
