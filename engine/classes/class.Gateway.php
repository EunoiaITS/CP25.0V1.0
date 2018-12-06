<?php
require_once('engine/classes/class.phpmailer.php');
require_once('engine/classes/class.smtp.php');


class gateway
{
    static function Process($parameters = NULL)
    {
        global $db;
        global $session;


        if (!isset($parameters[0]) || $parameters[0] == '') $parameters[0] = 'home';

        if(!isset($_SESSION['public_user_id']) || $_SESSION['public_user_id']==""){        	
            if($parameters[0] == 'loginAdmin' || $parameters[0] == 'login' || $parameters[0] == 'signup' || $parameters[0] == 'payment' || $parameters[0] == 'api' || $parameters[0] == 'cron' || $parameters[0] == 'ipayRes' || $parameters[0] == 'packageExpired' || $parameters[0] == 'glob' || $parameters[0] == 'makePayment' || $parameters[0] == 'privacy_policy' || $parameters[0] == 'about' || $parameters[0] == 'permission' || $parameters[0] == 'guide' || $parameters[0] == 'contact' || $parameters[0] == 'team' || $parameters[0] == 'home'){
				
			}else{
				 $parameters[0]='login';
			
			} 
        }else{
            
            if(isset($_SESSION['public_user_id']) && $_SESSION['public_user_id']>0){
                if(!$_SESSION['public_package']){
                    if($parameters[0]!="packageExpired" && $parameters[0]!="makePayment" && $parameters[0]!="ipayRes" && $parameters[0]!="payment"){
                        header("Location: " . request::$BASE_PATH . "index.php/packageExpired/".$_SESSION['public_user_id']);
                    }
                }
            }
        }

        $objPresenter = new Presenter();

        $objPresenter->AddParameter('parameters', $parameters);

        $objPost = Request::getpostvariables();

//            if(isset($_GET['p'])){
//                $page=$_GET['p'];
//            }else{
//                $page=0;
//            }

        //User Log In Controll
        if (!$session->is_logged_in()) {
            //Not Logged in
            if ($parameters[0] == "loginAdmin") {
                $parameters[0] = "loginAdmin";
            }
        } else {
            if (isset($_SESSION['user_permission']) && $_SESSION['user_permission'] != "") {

                //Logged in
                $logged_in = true;
                $objPresenter->AddParameter('logged_in', $logged_in);


                switch ($parameters[0]) {
                    case 'adminHome':
                        $objPresenter->AddTemplate('AdminHeader');
                        $objPresenter->AddTemplate('AdminHome');
                        $objPresenter->AddTemplate('AdminFooter');
                        break;


                    default:
                        if (!$session->is_logged_in()) {
                            header("Location: " . request::$BASE_PATH . "index.php/adminHome");
                        }
                        break;
                }//switch admin ends
            }//isset permission
        }

        /***LOGIN Manager***/

        switch ($parameters[0]) {

            case 'loginAdmin':
                $object = Request::getPostVariables();
                if (isset($object->password)) {
                    $login = User::login($object);
                }
                if ($session->is_logged_in()) {

                    
                } else {
                    //
                }
                break;


            case 'logout':
                unset($_SESSION['public_user_id']);
                unset($_SESSION['public_user_name']);
                unset($_SESSION['public_user_email']);
                unset($_SESSION['public_package']);

                header("location:" . request::$BASE_PATH . "index.php");
                break;
            /***LOGIN Cases***/

            case 'ajax':
                $obj = NULL;
                foreach ($_POST as $key => $value) {
                    $obj->$key = $value;
                }
                $db->save($objPost->table, $obj);
                break;

            case 'delete':
                $sql = "DELETE FROM " . $_POST['table'] . " WHERE id='" . $_POST['id'] . "'";
                $db->query($sql);
                break;

//            case 'login':
//                $objPresenter->AddTemplate('Header');
//                $objPresenter->AddTemplate('Login');
//                $objPresenter->AddTemplate('Footer');
//                $objPresenter->AddParameter('title','Naqli Aqli');
//                break;
            case 'login':
                $objPresenter->AddParameter('subscription_packages', $db->select("subscription_packages", array()));
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('Login_Test');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Naqli Aqli');
                break;
            case 'signup':

                $obj = new stdClass();
                foreach ($_POST as $key => $value) {
                    if ($key == "data") {
                        $obj->$key = strip($value);
                    } else if ($key == "password") {
                        $obj->$key = md5($value);
                    } else {
                        $obj->$key = $value;
                        if ($key == "field_of") {
                            $obj->$key = json_encode($value);
                        }
                    }
                }

                $r = $db->save($objPost->table, $obj);

             
                if ($r && $objPost->table == "user_public") {
                        $result = $db->select_single('user_public', array('id' => $r));
                        
                        $package = $db->select_single('subscription_packages', array('id' =>$_POST['subscription_package_id'] ));
                        
                       
                        $_SESSION['msg_success'] = 'Successfully Registered! Please proceed to login with your new account';
                        
                        if($package->price>0){
                            
                        $trans=new stdClass();
                        $trans->user_public_id=$result->id;
                        $trans->package_id=$package->id;
                        $trans->description="ATTEMPT TO BUY";
                        $trans_id=$db->save('user_wallet_transaction',$trans);
                        
                        $user_data = new stdClass();
                        $user_data->user_id  = $result->id;
                        $user_data->trans_id  = $trans_id;
                        $user_data->username  = $result->username;
                        $user_data->email  = $result->email;
                        $user_data->phone_no  = $result->phone_no;
                        $user_data->package  = $package->price;
                        
                        
                        header("Location: " . request::$BASE_PATH . "index.php/payment?data=".urldecode(serialize($user_data)));
                        }else{
                        
                        $trans=new stdClass();
                        $trans->user_public_id=$result->id;
                        $trans->package_id=$package->id;
                        $trans->active=1;
                        $trans->description="FREE TRAIL";
                        $db->save('user_wallet_transaction',$trans);
                        
                       header("location:" . Request::$BASE_PATH . "index.php/login");
                        }

                } else {
                   $_SESSION['msg_error'] = 'User Not Found';
                  header("Location: " . $_SERVER['HTTP_REFERER']);
                }


                break;
                
                case 'makePayment':
    
                if (isset($_POST['id']) && $_POST['id']) {
                        $r=$_POST['id'];
                    
                        $result = $db->select_single('user_public', array('id' => $r));
                        
                        $package = $db->select_single('subscription_packages', array('id' =>$_POST['subscription_package_id'] ));
                        
                       
                        $_SESSION['msg_success'] = 'Successfully Registered! Please proceed to login with your new account';
                        
                        
                            
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
                    

                }elseif($parameters[1]!="" && $parameters[1]>0 && $parameters[2]!="" && $parameters[2]>0){
                    
                        $r=$parameters[2];
                    
                        $result = $db->select_single('user_public', array('id' => $r));
                            
                        $trans=new stdClass();
                        $trans->user_public_id=$result->id;
                        $trans->package_id=$package->id;
                        $trans->description="DONATION";
                        $trans->typ=2;
                        $trans_id=$db->save('user_wallet_transaction',$trans);
                        
                        $user_data = new stdClass();
                        $user_data->user_id  = $result->id;
                        $user_data->trans_id  = $trans_id;
                        $user_data->username  = $result->username;
                        $user_data->email  = $result->email;
                        $user_data->phone_no  = $result->phone_no;
                        $user_data->package  = $parameters[1];
                        
                        
                        header("Location: " . request::$BASE_PATH . "index.php/payment?data=".urldecode(serialize($user_data)));
                    
                }else {
                   $_SESSION['msg_error'] = 'User Not Found';
                  header("Location: " . $_SERVER['HTTP_REFERER']);
                }


                break;

            case 'payment':

                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('Payment_Request');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Naqli Aqli');

                break;
                
            case 'packageExpired':
                
                if(isset($parameters[1]) && $parameters[1]>0){
                    
                    $us=$db->select_single('user_public',array('id'=>$parameters[1]));
                    
                    $objPresenter->AddParameter('subscription_packages', $db->select("subscription_packages",""));
                    
                    
                    $objPresenter->AddParameter('user', $us);
                    
                    $objPresenter->AddTemplate('Header');
                    $objPresenter->AddTemplate('Package_Expired');
                    $objPresenter->AddTemplate('Footer');
                    $objPresenter->AddParameter('title', 'Naqli Aqli');
                }else{
                    header("location:" . Request::$BASE_PATH . "index.php/login");
                }

                break;
                
             case 'ipayRes':
                 if(isset($_POST['MerchantCode']) && $_POST['MerchantCode'] == "M16029" && isset($_POST['Status']) && $_POST['Status']==1 && isset($_POST['RefNo']) && $_POST['RefNo']>0){
                     
                     $tran=$db->select_single('user_wallet_transaction',array('id'=>$_POST['RefNo']));
                     
                     $trans=$db->select('user_waller_transaction',array('user_public_id'=>$tran->user_public_id));
                     
                     if($tran->typ==1){
                         if(count($trans)>0){
                             foreach($trans as $t){
                                 $t->active=0;
                                 $db->save('user_wallet_transaction',$t);
                             }
                         }
                         
                         $tran->active=1;
                         $tran->transaction_json=json_encode($_POST);
                         $db->save('user_wallet_transaction',$tran);
                         
                         if(isset($_GET['url']) && $_GET['url']==1){
                             
                             if(isset($_SESSION['public_user_id']) && $_SESSION['public_user_id']>0){
                                 $wallet=$db->select('user_wallet_transaction',array('user_public_id'=>$_SESSION['public_user_id'],'active'=>1),"id","DESC");
                                 
                                    $_SESSION['public_package']=$wallet[0];
                                }
                             
                             
                             
                             alert("Thank you for your payment! Please login to your account!", Request::$BASE_PATH);
                         }else{
                             echo "RECEIVEOK";
                         }
                    }else{
                        $tran->transaction_json=json_encode($_POST);
                        $db->save('user_wallet_transaction',$tran);
                        alert("Thank you for your donation!", Request::$BASE_PATH);
                    }
                 }else{
                     if(isset($_GET['url']) && $_GET['url']==1){
                         alert("Payment Failed! Please try again by login to your account", Request::$BASE_PATH);
                     }else{
                         header("Location: " . Request::$BASE_PATH);
                     }
                 }
                 
                 
                break;

            case 'forgot_password':

                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('Forgot_password');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Naqli Aqli');

                break;
            case 'forgotPassword':

                //  if(!$session->is_logged_in()){


                $user = $db->select_single('user_public', array('email' => $_POST['email']));

                // print_r($user);die;


                if (!empty($user)) {
                    $code = md5(crypt(rand(), 'st'));
                    $user->reset_link_time = date('Y-m-d H:i:s');
                    $user->reset_link_code = $code;

                    $r = $db->save("user_public", $user);
                    $email = $user->email;
                    if (!empty($email)) {

//                            $mail = new PHPMailer();
//                            $mail->IsSMTP();  // telling the class to use SMTP
//                            $mail->Host = "mail.naisse.org"; // SMTP server
//                            $mail->Port = 465; // set the SMTP port for the GMAIL server
//                            $mail->Username = "_mainaccount@naisse.org"; // SMTP account username example
//                            $mail->Password = "p0Rejp2mXXg_";
//
//                            $mail->From = "admin@naisse.org";
//                            $mail->AddAddress($email, "usman");
//                            $mail->Subject = "First PHPMailer Message";
//                            $mail->Body = "Hi! \n\n This is my first e-mail sent through PHPMailer.";
//                            $mail->WordWrap = 50;
//
//                            if (!$mail->Send()) {
//                                echo 'Message was not sent.';
//                                echo 'Mailer error: ' . $mail->ErrorInfo;
//                            } else {
//                                echo 'Message has been sent.';
//                            }
//                        }


                        if (!empty($email)) {
                            $mail = new PHPMailer(false);
                            $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
                            $msg .= '<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
                            $msg .= '<head>';
                            $msg .= '<meta name="viewport" content="width=device-width" />';
                            $msg .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                            $msg .= '<title> reset password</title>';
                            $msg .= '<style type="text/css">';
                            $msg .= 'img {max-width: 100%;}body {-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;}';
                            $msg .= 'body {background-color: #f6f6f6;}@media only screen and (max-width: 640px) {body {padding: 0 !important;}h1 {font-weight: 800 !important; margin: 20px 0 5px !important;}';
                            $msg .= 'h2 {font-weight: 800 !important; margin: 20px 0 5px !important;}h3 {font-weight: 800 !important; margin: 20px 0 5px !important;}';
                            $msg .= 'h4 {font-weight: 800 !important; margin: 20px 0 5px !important;}h1 {font-size: 22px !important;}h2 {font-size: 18px !important;}';
                            $msg .= 'h3 {font-size: 16px !important;}.container {padding: 0 !important; width: 100% !important;}.content {padding: 0 !important;}.content-wrap {padding: 10px !important; }.invoice {width: 100% !important;}}';
                            $msg .= '</style></head>';
                            $msg .= '<body itemscope itemtype="http://58.27.220.110:201/MVP/MVP-Dashboard/Login" style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">';
                            $msg .= '<table class="body-wrap" style="font-family:Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>';
                            $msg .= '<td class="container" width="600" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">';
                            $msg .= '<div class="content" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">';
                            $msg .= '<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://58.27.220.110:201/MVP/MVP-Dashboard/Login" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">';
                            $msg .= '<meta itemprop="name" content="Confirm Email" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">';
                            $msg .= 'Hey there,<br>';
                            $msg .= 'You are receiving this email as someone (hopefully you) has indicated that you have forgotten your password. If this is correct, please click reset password button to reset your password:<br>';
                            $msg .= 'Thank you for using Naisse App!';
                            $msg .= '</td>';
                            $msg .= '</tr><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">';
                            $msg .= '<a href="' . Request::$BASE_URL . 'index.php/forgot_password?code=' . $code . '"  class="btn-primary" itemprop="url" >Reset Password</a>';

                            $msg .= '</td>';
                            $msg .= '</tr><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">';
                            $msg .= '&mdash; Naisse.org Team<br>';

                            $msg .= 'W: www.naisse.org.com';
                            $msg .= '</td>';
                            $msg .= '</tr></table></td>';
                            $msg .= '</tr></table><div class="footer" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">';
                            $msg .= '<table width="100%" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
                            $msg .= '</tr></table></div></div>';
                            $msg .= '</td>';

                            $msg .= '</tr></table></body>';
                            $msg .= '</html>';

                            $mail->AddAddress($email, "usman");
                            $mail->SetFrom('admin@naisse.org', 'Admin');
                            $mail->AddReplyTo('name@yourdomain.com', 'First Last');
                            $mail->addCustomHeader('Content-Type', 'text/html');
                            $mail->addCustomHeader('charset', 'ISO-8859-1');
                            $mail->Subject = "forgot password";
                            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                            $mail->MsgHTML($msg);

                            //echo $msg;
                            //  echo "mail response: ".$mail->Send();
//                            print_r($msg);
//                            if (!$mail->Send()) {
//                                echo 'Message was not sent.';
//                                echo 'Mailer error: ' . $mail->ErrorInfo;
//                            } else {
//                                echo 'Message has been sent.';
//                            }
//                        }
                            // print_r($mail);
                            //print_r($mail);

                            $_SESSION['email_success'] = "Hey " . $user->first_name . " Reset Password Email Sent On Your Email ID :) !";
                            header("location:" . Request::$BASE_PATH . "index.php/forgot_password");

                        }


                    } else {
                        $_SESSION['email_error'] = 'Invalid Email or account is not registered with this email :( !';
                        $objPresenter->AddTemplate('Header');
                        $objPresenter->AddTemplate('Forgot_password');
                        $objPresenter->AddTemplate('Footer');
                        $objPresenter->AddParameter('title', 'Naqli Aqli');
                    }
                }

                break;

            case 'reset_password':

                $_SESSION['code'] = $_GET['code'];
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('Reset_password');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Naqli Aqli');

                break;

            case'resetPassword':

                if (!empty($_SESSION['code'])) {
                    $user = $db->select_single('user_public', array('reset_link_code' => $_SESSION['code']));
                    $email_code = $_SESSION['code'];
                }
//        unset($_SESSION['code']);

                if (isset($user)) {
                    if ($email_code == $user->reset_link_code) {

                        if (md5($_POST['password']) == md5($_POST['passwordr'])) {

                            $password_reset_time = $user->reset_link_time;
                            $expiry_time = strtotime($password_reset_time) + (60 * 60 * 24);
                            $now = time();
                            if ($now > $expiry_time) {


                                $user->reset_link_time = '0000-00-00 00:00:00';
                                $user->reset_link_code = '';

                                $user = $db->save("user_public", $user);

                                $_SESSION['link_expired_msg'] = 'Invalid code or link expired';
                                header("location:" . Request::$BASE_PATH . "index.php/reset_password");
                                return;
                            } else {
                                $user->password = md5($_POST['password']);
                                $user->reset_link_time = '0000-00-00 00:00:00';
                                $user->reset_link_code = '';
                                $db->save("user_public", $user);
                                unset($_SESSION['code']);
                                $_SESSION['password_success_msg'] = 'Password Changed Successfully';
                                header("location:" . Request::$BASE_PATH . "index.php/login");
                                return;
                            }
                        } else {
                            $_SESSION['password_mismatched_msg'] = ' password Mismatched';
                            $_SESSION['code'] = $email_code;
                            header("location:" . Request::$BASE_PATH . "index.php/reset_password");

                            return;
                        }
                    } else {
                        $_SESSION['link_expired_msg'] = 'Invalid Link';
                        header("location:" . Request::$BASE_PATH . "index.php/reset_password");

                        return;
                    }
                } else {
                    $_SESSION['invalid_user_msg'] = 'User Not Found';
                    header("location:" . Request::$BASE_PATH . "index.php/reset_password");

                    return;

                }

                break;

            case 'home':
                $objPresenter->AddParameter('keywords', $db->select("keyword_index", "", "id", "ASC", 100));
                $ads=$db->select("advertisement", array(), $col = "position", $sq = 'ASC');
                if(count($ads)>0){
                    foreach($ads as $a){
                        $a->path=str_replace(" ","%20",$a->path);
                        $a->short_path=str_replace(" ","%20",$a->short_path);
                    }
                }
                
                $objPresenter->AddParameter('advertisement',$ads);
                
                
                
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('Home');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Naqli Aqli');
                break;

            case 'about':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('AboutUs');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'About Naqli Aqli');
                break;

            case 'permission':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Permission');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Permission - Naqli Aqli');
                break;

            case 'guide':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Guide');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Guide - Naqli Aqli');
                break;

            case 'contact':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Contact');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Contact - Naqli Aqli');
                break;

            case 'team':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Team');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Our Team - Naqli Aqli');
                break;

            case 'privacy_policy':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Privacy_policy');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Privacy Policy - Naqli Aqli');
                break;

            case 'refund_policy':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Refund_policy');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Refund Policy - Naqli Aqli');
                break;

            case 'company':
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Company_reg');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Company Registration - Naqli Aqli');
                break;

            case 'results':
                

                if(isset($_SESSION['public_package']) && isset($_SESSION['public_package']->price) && $_SESSION['public_package']->price==0){

                    $q=$db->select('query_log',array('user_id'=>$_SESSION['public_user_id']));
                    
                    if(count($q)>3){
                        $_SESSION['public_package']->active=0;
                        $db->save('user_wallet_transaction',$_SESSION['public_package']);
                        $_SESSION['public_package']=false;
                        alert("Max Query limit reached for trail version",Request::$BASE_PATH);
                    }
                }
            
                $results = false;

                if (isset($_GET['search']) && $_GET['search'] != "") {

                    $query_log = new stdClass();
                    $query_log->query = $_GET['search'];
                    $query_log->ip_address = $_SERVER['REMOTE_ADDR'];
                    if (isset($_SESSION['public_user_id'])) {
                        $query_log->user_id = $_SESSION['public_user_id'];
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
                        header("location:" . Request::$BASE_URL . "index.php/results?" . $new_query_string);
                    }

                    if (isset($_GET['pf']) && $_GET['pf'] != "" && is_numeric($_GET['pf'])) {
                        $pf = $db->select_single("prophetic_food", array("id" => $_GET['pf']));
                        if (isset($pf->id)) {
                            $objPresenter->AddParameter('prophetic_food', $pf);
                            $addPf = $db->select("additional_information", array("type" => "prophetic_food", "type_id" => $pf->id));
                            if (count($addPf) > 0) {
                                $objPresenter->AddParameter('addPf', $addPf);
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
                            $url = Request::$BASE_URL . "index.php/results?" . $new_query_string;

                            $pfs[$z]['url'] = $url;
                            $z++;
                        }

                        $objPresenter->AddParameter('pfs', $pfs);

                    }

                    $objPresenter->AddParameter('quran', $result->_quran);
                    $objPresenter->AddParameter('hadiths', $result->_hadith);
                    $objPresenter->AddParameter('manuscripts', $result->_manuscript);
                    $objPresenter->AddParameter('articles', $result->_article);
                }

                $objPresenter->AddParameter('search', $_GET['search']);

                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('Results');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Naqli Aqli');
                break;

            case 'page':
                if (isset($_GET['type']) && isset($_GET['id']) && $_GET['type'] != "" && is_numeric($_GET['id'])) {
                    $data = $db->select_single($_GET['type'], array('id' => $_GET['id']));
                    if (isset($data->id)) {
                        $page = array();
                        $additional = $db->select('additional_information', array('type' => $_GET['type'], 'type_id' => $data->id));

                        switch ($_GET['type']) {
                            case 'quran':
                                $surah = $db->select_single('surah_index', array('id' => $data->surah));
                                $page['Ayat'] = $data->ayat;
                                $page['Ayat # / Verse #'] = $data->verse;
                                $page['Surah (Arabic)'] = $surah->surah;
                                $page['Surah (English)'] = $surah->trans_english;
                                $page['Surah Definition (Enlgish)'] = $surah->meaning_english;
                                $page['Surah # / Chapter #'] = $surah->id;
                                $page['Ayat Translation (English)'] = $data->trans_english;
                                $page['Ayat Translation (Malay)'] = $data->trans_malay;

                                break;

                            case 'hadith':
                                $page['Kitab'] = $data->kitab;
                                $page['Bab'] = $data->bab;
                                $page['Vol'] = $data->vol;
                                $page['Page'] = $data->page;
                                $page['Hadith #'] = $data->hadith_no;
                                $page['Hadith'] = $data->trans_arabic;
                                $page['Hadith Translation (English)'] = $data->trans_english;
                                $page['Hadith Translation (Malay)'] = $data->trans_malay;
                                break;

                            case 'manuscript':
                                if ($data->path) {
                                    $ori = '<img src="' . $data->path . '" width="100%" />';
                                    $ori .= '<br />';
                                    $ori .= $data->trans_arabic;
                                } else {
                                    $ori = $data->trans_arabic;
                                }

                                $page['Manuscript #'] = $data->manuscript_no;
                                $page['Bab'] = $data->bab;
                                $page['Page'] = $data->page;
                                $page['Original Text'] = $ori;
                                $page['English'] = $data->trans_english;
                                $page['Malay'] = $data->trans_malay;
                                break;

                            case 'scientific_article':
                                $page['Article Name / Title'] = "<a target='_blank' href='" . $data->url . "'>" . $data->name . "</a>";
                                $page['Article Author / Publisher'] = $data->author;
                                $page['Article URL'] = $data->url;
                                $page['Article URL link'] = "<a target='_blank' href='" . $data->url . "'>" . $data->url . "</a>";
                                $page['Abstract Text'] = $data->abstract;
                                $page['Concept'] = $data->concept;
                                break;

                            case 'prophetic_food':
                                $additional = "";
                                $pf = $db->select_single("additional_information", array("id" => $_GET['info_id']));
                                if (isset($pf->id)) {
                                    $objPresenter->AddParameter('pf', $pf);
                                }
                                break;

                        }

                        if ($additional) {
                            foreach ($additional as $add) {
                                $page[$add->type_title] = $add->information;
                            }
                        }

                        $objPresenter->AddParameter('data', $page);


                        $objPresenter->AddTemplate('Header');
                        $objPresenter->AddTemplate('Page');
                        $objPresenter->AddTemplate('Footer');
                    } else {
                        header("Location: " . $_SERVER['HTTP_REFERER']);

                    }
                } else {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }
                break;


            case 'admin':
                header("location:" . request::$BASE_PATH . "index.php/loginAdmin");
                break;

            case 'post':
                $obj = new stdClass();
                foreach ($_POST as $key => $value) {
                    if ($key == "data") {
                        $obj->$key = strip($value);
                    } else if ($key == "password") {
                        $obj->$key = md5($value);
                    } else {
                        $obj->$key = $value;
                    }
                }
                $r = $db->save($objPost->table, $obj);
                if ($r && $objPost->table == "user_public") {
                    alert("Successfully Registered! Please proceed to login with your new account", Request::$BASE_PATH . "index.php/login");
                } else {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }
                break;


            case 'forum':
                $topic = $db->select("forum_topic", array(), $col = "created", $sq = 'DESC');
                if (count($topic) > 0) {
                    $objPresenter->AddParameter('topic', $topic);
                }
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Forum');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Permission - Naqli Aqli');
                break;

            case 'topic':
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
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

                            }
                        }
                    }
                    $objPresenter->AddParameter('data', $data);
                    $objPresenter->AddParameter('comments', $comments);
                    $objPresenter->AddParameter('session', $session);
                    $objPresenter->AddTemplate('Header');
                    $objPresenter->AddTemplate('Topic');
                    $objPresenter->AddTemplate('Footer');
                } else {
                    header("Location: " . request::$BASE_PATH . "index.php/forum");
                }
                break;

            case 'event':
                $event = $db->select("events", array(), $col = "created", $sq = 'DESC');
                if (count($event) > 0) {
                    $objPresenter->AddParameter('event', $event);
                }
                $objPresenter->AddTemplate('Header');
                $objPresenter->AddTemplate('TopNav');
                $objPresenter->AddTemplate('Event');
                $objPresenter->AddTemplate('Footer');
                $objPresenter->AddParameter('title', 'Permission - Naqli Aqli');
                break;

            case 'events':
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $data = $db->select_single('events', array('id' => $_GET['id']));

                    $objPresenter->AddParameter('data', $data);
                    $objPresenter->AddTemplate('Header');
                    $objPresenter->AddTemplate('EventDetail');
                    $objPresenter->AddTemplate('Footer');
                } else {
                    header("Location: " . request::$BASE_PATH . "index.php/event");
                }
                break;
            case 'glob':

                header('Content-Type: application/json');
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Credentials: true');
                echo json_encode($db->select("keyword_index", "", "id", "ASC", 100));
                // $objPresenter->AddParameter('keywords',$db->select("keyword_index","","id","ASC",100));
                // $objPresenter->AddTemplate('Glob');
                break;
            case 'api':


                if (headers_sent()) {
                    die("Redirect failed.");
                } else {
                    Api::Process(Request::Parameters());
                }

                break;
                
            case 'cron':
                switch($parameters[1]){
                    case 'expiry':
                        $trans=$db->select('user_wallet_transaction',array('active'=>1));
                        if(count($trans)>0){
                            foreach($trans as $t){
                                $t->pack=$db->select_single('subscription_packages',array('id'=>$t->package_id));
                                
                                $sDate=explode(" ",$t->created);
                                $sDate=$sDate[0];
                                
                                $date1 = $sDate;
                                $date2 = date("Y-m-d");
                                
                                $ts1 = strtotime($date1);
                                $ts2 = strtotime($date2);
                                
                                $diff = (($ts2-$ts1)/ (60*60*24));
                                
                                $allow=$t->pack->duration*30;
                                
                                if($diff>$allow && $t->pack->price>0){
                                    $t->active=0;
                                    $db->save('user_wallet_transaction',$t);
                                }
                                
                                
                            }
                        }
                    break;
                }
            break;

            default:
                if (!$session->is_logged_in()) {
                    header("Location: " . request::$BASE_PATH);
                }
                break;
        }

        $objPresenter->AddParameter('title', 'Naqli Aqli');
        $objPresenter->Publish();
    }
}
