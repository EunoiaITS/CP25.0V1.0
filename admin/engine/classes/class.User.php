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
			if(isset($object->user) && $object->user!="" && isset($object->password) && $object->password!=""){
				$password=md5($object->password);
				$user= $object->user;
				$data = array('username'=>$user,'password'=>$password);
				$login= $db->select_single(USER_TABLE,$data);
					if($login){
							$session->online=true;
							$session->add('user_id',$login->id);
							$session->add('user_name',$login->username);
							$session->add('user_permission',$login->type);
							return true;
					}else{
						$session->online=false;
						return false;
						}
				}
			else{
				$session->online=false;
				echo "ERROR in DATA";
				return false;
				}
		}
		
		
	}
?>