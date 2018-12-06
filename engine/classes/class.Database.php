<?php
/**INFORMATION**\

Created: 17-10-2012 04:40:00

Author: M.Wasiq Ghaznavi



Last Modified: 17-10-2012 05:27:00

Modified By: M.Wasiq Ghaznavi

/**INFORMATION**/
?>
<?php
class database{



    private $connection;	//Private variable so it cannot be accessed outside of the class



    function __construct(){

        $this->connect();

    }



    function connect(){





        $link = mysqli_init();

        $success = mysqli_real_connect(

            $link,

            DB_SERVER,

            DB_USER,

            DB_PASS,

            DB_NAME

        );



        $this->connection=$link;



        $this->query("SET CHARACTER SET utf8");



    }



    public function query($sql){
        
        $result= mysqli_query($this->connection,$sql);

        if($result){

            return $result;

        }



    }



    public function make_array($rs){

        if($rs != NULL){

            $obj = array();

            while($row= mysqli_fetch_object($rs))

            {$obj[]= $row;}

            return $obj;

        }

    }

    public function make_array_array($rs){

        if($rs != NULL){

            $obj = array();

            while($row= mysqli_fetch_array($rs))

            {$obj[]= $row;}

            return $obj;

        }

    }



    public function count_rows($table){

        $sql="SELECT * FROM ".$table." WHERE is_active='1'";

        $rs=$this->query($sql);

        $num= mysqli_num_rows($rs);

        return $num;

    }



    public function escape_value( $value ) {

        $value = stripslashes( $value );

        $value = mysqli_real_escape_string( $this->connection,$value );



        return $value;

    }



    public function insert_id() {

        // get the last id inserted over the current db connection

        return mysqli_insert_id($this->connection);

    }



    //IMPORTANT METHODS\\

    public function select($table,$data,$col="id",$sq="ASC",$limit=" "){

        if($table != NULL && $data != NULL){

            if($table !="query_log" && $table !="user" && $table !="user_public" && $table !="surah_index" && $table !="synonyms" && $table !="subscription_packages" && $table !="user_wallet_transaction"){

                $sql="SELECT * FROM ".$table." WHERE is_active='1' AND is_approved='1' AND ";

            }else{

                $sql="SELECT * FROM ".$table." WHERE is_active='1' AND ";

            }

            $conditions = array();

            foreach($data as $key=>$value){

                $conditions[]= $key." = '".$value."' ";

            }

            $sql.= join("AND ",$conditions);

        }

        elseif($table != NULL && $data == NULL){

            if($table !="query_log" && $table !="user" && $table !="user_public" && $table !="surah_index" && $table !="synonyms" && $table !="subscription_packages" && $table !="user_wallet_transaction"){

                $sql="SELECT * FROM ".$table." WHERE is_active='1' AND is_approved='1' ";

            }else{

                $sql="SELECT * FROM ".$table." WHERE is_active='1' ";

            }

        }

        else{

            echo "ERROR in data";

            exit;

        }



        $sql.= "ORDER BY ".$col." ".$sq." ";

        if($limit!=" "){

            $sql.="LIMIT ".$limit;

        }

        $rs= $this->query($sql);

        $object= $this->make_array($rs);

        return $object;

    }



    public function select_single($table,$data){

        if($table != NULL && $data != NULL){

            if($table !="query_log" && $table !="user" && $table !="user_public" && $table !="surah_index" && $table !="synonyms" && $table !="subscription_packages" && $table !="user_wallet_transaction"){

                $sql="SELECT * FROM ".$table." WHERE is_active='1' AND is_approved='1' AND ";

            }else{

                $sql="SELECT * FROM ".$table." WHERE is_active='1' AND ";

            }

            $conditions = array();

            $data = str_replace("'","",$data);

            foreach($data as $key=>$value){

                $conditions[]= $key." = '".$value."' ";

            }

            $sql.= join("AND ",$conditions);

        }

        elseif($table != NULL && $data == NULL){

            if($table !="query_log" && $table !="user" && $table !="user_public" && $table !="surah_index" && $table !="synonyms" && $table !="subscription_packages" && $table !="user_wallet_transaction"){

                $sql="SELECT * FROM ".$table." WHERE is_active='1' AND is_approved='1' ";

            }else{

                $sql="SELECT * FROM ".$table." WHERE is_active='1' ";

            }

        }

        else{

            echo "ERROR in data";

            exit;

        }

        $sql.= "ORDER BY id ASC ";

        $rs= $this->query($sql);

        $object= mysqli_fetch_object($rs);

        return $object;

    }

    public function save($table,$data){

        if (empty($table) || count($data) < 1) {

            trigger_error("DB:Save() Illegal SQL:\n", E_USER_ERROR);

            exit;

        }

        $sql = "";

        $columns = array_keys((array)$data);

        $result = mysqli_query($this->connection,"DESC ".$table);

        $error_no = mysqli_errno($this->connection);

        if($error_no){

            $err_string = mysqli_error($this->connection);

            trigger_error("DB:Save() failed, err no ".$error_no.

                "\nMessage: ".$err_string."\n", E_USER_ERROR);

            exit;

        }else{

            while($row = mysqli_fetch_object($result)){

                if($row->Field != 'id' && in_array($row->Field,$columns)){

                    if($sql != "") $sql .= ", ";

                    $sql .= $row->Field . " = '" . mysqli_real_escape_string($this->connection,$data->{$row->Field}) . "'";

                }







            }

            if(isset($data->id) && $data->id != ""){

                $sql = "UPDATE ".$table." SET ".$sql." WHERE id = '".$data->id."' ";

                if($this->Update($sql)){

                    return $data->id;

                }

                else{

                    return false;

                }

            }

            else{

                $sql .= ", created = '".date("Y-m-d H:i:s")."'";

                $sql .= ", is_active = '1'";

                $sql = "INSERT INTO ".$table." SET ".$sql;

                return $this->Insert($sql);

            }

        }

    }



    function insert($sql){

        if (empty($sql) || !preg_match("/^INSERT/",$sql."")) {

            trigger_error("DB:Insert() Illegal SQL:\n".$sql, E_USER_ERROR);

            exit;

        }

        $result = mysqli_query($this->connection,$sql);

        $error_no = mysqli_errno($this->connection);

        if($error_no){

            if($error_no==1062){

                alert("Duplicate Entry Attempt",$_SERVER['HTTP_REFERER']);

                exit;

            }

            $err_string = mysqli_error($this->connection);

            trigger_error("DB:Insert() failed, err no ".$error_no.

                "\nMessage: ".$err_string.

                "\nSQL: ".$sql."\n", E_USER_ERROR);

            exit;

        }else{

            return $this->insert_id();

        }

    }



    function update($sql){

        if (empty($sql) || !preg_match("/^UPDATE/",$sql."\n")) {

            trigger_error("DB:Update() Illegal SQL:\n".$sql, E_USER_ERROR);

            exit;

        }

        $results = mysqli_query($this->connection,$sql) or die("Invalid query:<br/>".$sql."<br/>".mysqli_error());

        if (!$results) return false;

        return true;

    }



    //IMPORTANT METHODS\\

}

?>