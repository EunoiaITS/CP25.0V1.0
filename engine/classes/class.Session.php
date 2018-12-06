<?php 
/**INFORMATION**\
Created: 17-10-2012 04:40:00
Author: M.Wasiq Ghaznavi

Last Modified: 17-10-2012 04:40:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php
class session{
	
	public  $online= false;
	public  $user_online= false;
	public  $user_id;
	public  $user_name;
	
	function __construct(){
		session_start();
		if(isset($_SESSION['user_name']) && isset($_SESSION['user_id'])){
				$this->online= true;
				$this->user_id= $_SESSION['user_id'];
				$this->user_name= $_SESSION['user_name'];
			}
		else{
				$this->online= false;
			}
		}
		
	public function is_logged_in(){
		return $this->online;
		}	
	public function user_is_logged_in(){
		return $this->user_online;
		}		
	
	public function add($variable,$value){
		if($variable != NULL && $value != NULL){
			$_SESSION[$variable]= $value;
			}
		else{
			echo ERROR;
			}
		}
		
	public function remove($variable){
		if($variable != NULL){
			unset($_SESSION[$variable]);
			}
		else{
			echo ERROR;
			}
		}
	public function destroy(){
		if(session_destroy()){
			return true;
			}
		}
	
	}
?>