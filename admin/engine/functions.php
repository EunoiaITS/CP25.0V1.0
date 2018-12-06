<?php 
/**INFORMATION**\
Created: 17-10-2012 04:40:00
Author: M.Wasiq Ghaznavi

Last Modified: 17-10-2012 04:40:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php
function strip($str) {    return get_magic_quotes_gpc() ? stripslashes($str) : $str; }

function remove_p($data){
	$data=strip_tags($data);
	return $data;
	}

function editor($id){
echo	'<script type="text/javascript">';
echo "CKEDITOR.replace( '".$id."',
	{
	});
function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}
</script>";

	}
function editor_full($id){
echo	'<script type="text/javascript">';
echo "CKEDITOR.replace( '".$id."',
	{
		height:500
	});
function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}
</script>";

	}	 
	
function table_exists($table){
	global $db;
	$haystack=$db->make_array_array($db->query("SHOW TABLES"));
	$tables=array();
	foreach($haystack as $hay){
		$tables[]=$hay[0];
	}

	return in_array($table, $tables);
}

function message($message){
	if($message != NULL){
		echo "<p>".$message."</p>";
		}
	}
function redirect_to($location){
	if($location != NULL){
		header("location:".$location);
		} 
	}
function redirect_back(){
	$loc= $_SERVER['HTTP_REFERER'];
	header("location:".$loc);
	}
function alert($message, $location=""){
	if($location==""){
		if(isset($_SERVER['HTTP_REFERER'])){
			$location=$_SERVER['HTTP_REFERER'];
		}else{
			$location=Request::$BASE_URL;
		}
	}
	if($message != NULL && $location != NULL){
		echo '<script type="text/javascript">alert("'.$message.'")
			window.location = "'.$location.'"
			</script>';
		}
	}
function signed_in(){
	if($_SESSION['UserName'] != NULL){
		return true;
		}
	}
function price($price){
	$price=str_replace(",","",$price);
	return number_format($price);
	}
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function delete_image($path){
	if(unlink($path)){
		return true;
		}
	else{
		return false;
		}
	}


//Thumb Nail Creator


$final_width_of_image = 100;  
//$path_to_image_directory = 'images/slider/';  
$path_to_thumbs_directory = '../images/thumb/';



function image_upload($name,$tmp,$path_to_image_directory = 'images/'){
$source= $_FILES['path']['tmp_name'];
$target= '../images/';
$filename= $_FILES['path']['name'];

		$filename = $name;  
        $source = $tmp;  
        $target = $path_to_image_directory . $filename;  
        move_uploaded_file($source, $target);  
        //createThumbnail($filename);  
	}


function createThumbnail($filename) {  
	global	$final_width_of_image;  
	global	$path_to_image_directory ;  
	global	$path_to_thumbs_directory;
	global	$source;
	global	$target;
	global	$filename;


       if(preg_match('/[.](jpg)$/', $filename) || preg_match('/[.](JPG)$/', $filename)) {  
        $im = imagecreatefromjpeg($path_to_image_directory . $filename);  
    } else if (preg_match('/[.](gif)$/', $filename) || preg_match('/[.](GIF)$/', $filename)) {  
        $im = imagecreatefromgif($path_to_image_directory . $filename);  
    } else if (preg_match('/[.](png)$/', $filename) || preg_match('/[.](PNG)$/', $filename)) {  
        $im = imagecreatefrompng($path_to_image_directory . $filename);  
    }  

  	
	
	
    $ox = imagesx($im);  
    $oy = imagesy($im);  
  
    $nx = $final_width_of_image;  
    $ny = floor($oy * ($final_width_of_image / $ox));  
  
    $nm = imagecreatetruecolor($nx, $ny);  
  
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);  
  
    if(!file_exists($path_to_thumbs_directory)) {  
      if(!mkdir($path_to_thumbs_directory)) {  
           die("There was a problem. Please try again!");  
      }  
       }  
  
    imagejpeg($nm, $path_to_thumbs_directory . $filename);  
    $tn = '<img src="' . $path_to_thumbs_directory . $filename . '" alt="image" />';  
    $tn .= '<br />Congratulations. Your file has been successfully uploaded, and a      thumbnail has been created.';  
    //echo $tn;  
}  

//Thumb Nail Creator Ends


function upload_image($path,$name,$tmp){
		$target_path = $path . basename($name); 
		if(move_uploaded_file($tmp, $target_path)){
			return true;
			}
		else{
			return false;
			}
	}
	
function check_value($table,$column,$value){
	global $db;
	$sql= "SELECT * FROM ".$table." WHERE ".$column." = '".$value."'";
	$rs= $db->query($sql);
	$count= $db->count_rows($rs);
		if($count == 0){
			return true;
			}
		else{
			return false;
			}
	}

function mailer($from,$to,$sub,$Body){
$EmailFrom = Trim(stripslashes($from));
$EmailTo = $to;
$Subject = $sub;

$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
  exit;
}
$headers= "From: <$EmailFrom>\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$success = mail($EmailTo, $Subject, $Body,$headers);

// redirect to success page 
if ($success){
	
}
else{
	return false;
}
	}


?>