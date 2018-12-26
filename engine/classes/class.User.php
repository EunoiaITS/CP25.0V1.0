<?php 

/**INFORMATION**\

Created: 03-11-2012 19:09:00

Author: M.Wasiq Ghaznavi



Created: 03-11-2012 19:09:00

Modified By: M.Wasiq Ghaznavi

/**INFORMATION**/

?>

<?php 

class User{

	public static function login($object){

			global $db;

			global $session;

			if(isset($object->email) && $object->email!="" && isset($object->password) && $object->password!=""){

				$password=md5($object->password);

				$email= $object->email;

				$data = array('email'=>$email,'password'=>$password);

				$login= $db->select_single(USER_TABLE,$data);
                
					if($login){
						if($login->type!=3){

                            $wallet=$db->select('user_wallet_transaction',array('user_public_id'=>$login->id,'active'=>1),"id","DESC");
                            
                            
                            if(count($wallet)>0 && $wallet[0]->active==1){
                                
                                $p=$db->select_single('subscription_packages',array('id'=>$wallet[0]->package_id));
                                $wallet[0]->price=$p->price;

							$session->online=true;

							$session->add('public_user_id',$login->id);

							$session->add('public_user_email',$login->email);

							$session->add('public_user_name',$login->first_name);
							
							$session->add('public_package',$wallet[0]);

							$session->add('package_id',$login->subscription_package_id);

							alert("Logged In", Request::$BASE_PATH);
							
							}else{
							    
							    $session->add('public_user_id',$login->id);

							$session->add('public_user_email',$login->email);

							$session->add('public_user_name',$login->first_name);
							
							$session->add('public_package',false);

                                $session->add('package_id',$login->subscription_package_id);

							    alert("Package Expired", Request::$BASE_PATH . "index.php/packageExpired/".$login->id);
							}

						}else{

						alert("Incorrect Email / Password", Request::$BASE_PATH . "index.php/login");

						}

					}else{

						$session->online=false;

					alert("Incorrect Email / Password", Request::$BASE_PATH . "index.php/login");

						}

				}

			else{

				$session->online=false;

				echo "ERROR in DATA";

				alert("Incorrect Email / Password", Request::$BASE_PATH . "index.php/login");

				}

		}

		

		

	}

?>