<?php 
/**INFORMATION**\
Created: 03-11-2012 19:09:00
Author: M.Wasiq Ghaznavi

Created: 03-11-2012 19:09:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php 
class Pagination{
			
	public static function query($table,$num,$page=0){
		global $db;
		$noPages=self::noPages($table,$num);
		if($page>0 && $page<=$noPages){
			$lower=(($_GET['p']-1)*$num);
			$upper=$lower+$num;
			$result=$db->select($table,"","id","ASC",$lower,$upper);	
		}else{
			$result=$db->select($table,"","id","ASC","0",$num);							
		}
		return $result;
	}

	public static function queryD($table,$num,$page=0){
		global $db;
		$noPages=self::noPages($table,$num);
		if($page>0 && $page<=$noPages){
			$lower=(($_GET['p']-1)*$num);
			$upper=$lower+$num;
			$result=$db->select($table,"","id","DESC",$lower,$upper);	
		}else{
			$result=$db->select($table,"","id","DESC","0",$num);							
		}
		return $result;
	}

	public static function noPages($table,$num){
		global $db;

		$total=mysqli_num_rows($db->query("SELECT id FROM ".$table));
		$noPages=ceil($total/$num);
		return $noPages;
	}

	public static function pagesBlock($table,$num,$url){
		$noPages=self::noPages($table,$num);
	?>
			<br />
            <hr />
            <div class="row">
                <div class="col-md-12 text-center">
                    <b>Pages:</b>
                    <?php if($noPages>0){ for($i=1; $i<=$noPages; $i++){ ?>
                    <a href="<?php echo $url; ?>?p=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php }} ?>
                </div>
            </div>
            <hr />
            <br /><br />
    <?php
	}
}
?>