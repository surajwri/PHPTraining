<?php


class DB
{
    private $conn=null;
        private static $statusResponse=array();

    public function connect(){
        $this->conn = new mysqli('localhost','root','','phptraining');
        return $this->conn;
    }

    public static function Status($status,$message){
        DB::$statusResponse['status'] = $status;
        DB::$statusResponse['message'] = $message;
        return DB::$statusResponse;
    }

    public function getQuery($table, $where=null){

        $sql = "SELECT * FROM ".$table;
        if (isset($where)){
            $sql.=" WHERE ".$where;
        }
        $sql.=" ORDER BY `id` ASC";

        $rs = $this->conn->query($sql);

        while($row = $rs->fetch_assoc()){
            $response[]=$row;
        }

        return $response;
    }

    public function deleteQuery($table, $where=null){
        if (is_null($where)){
            $response = DB::Status('fail','Where clause is missing');
        }else{
            $sql = "DELETE FROM ".$table." WHERE $where";
            if ($this->conn->query($sql)){
                $response = DB::Status('pass','Record is Deleted Successfully');
            }else{
                $response = DB::Status('fail','Something Went Wrong');
            }
        }
        return $response;
    }

    public function insertQuery($table,$input=array())
    {

        $sql = "INSERT INTO " . $table;
        if (empty($input)) {
            $response = DB::Status('fail','input values not provided');
        } else {
            if ($input === array_values($input)) {
                $response = DB::Status('fail','input array not valid');
            } else {

                $feilds = array_keys($input);
                $feildsValues = array_values($input);
                $feilds = implode("`, `", $feilds);

                $feildsValues = implode("', '", $feildsValues);

                $feilds= " (`".$feilds."`)";
                $feildsValues= "('".$feildsValues."')";

                $sql.=$feilds." VALUES ".$feildsValues;
                if ($this->conn->query($sql)){
                    $response = DB::Status('pass','Record is Inserted Successfully');
                }else{
                    $response = DB::Status('fail','Something Went Wrong');

                }

            }
        }
        return $response;
    }

    public function UpdateQuery($table,$input=array(),$where=null)
    {
        $sql = "UPDATE " . $table." SET ";
        if (empty($input)) {
            $response = DB::Status('fail','input values not provided');
        } else {
            if ($input === array_values($input)) {
                $response = DB::Status('fail','input array not valid');
            } else {
                $updates = "";
                $i=1;
                $argNo = count($input);
                foreach ($input as $key=>$value){
                    $updates.="`$key`='$value'";
                    if ($i<$argNo){
                        $updates.= ", ";
                    }
                    $i++;
                }
                $sql.=$updates." WHERE ".$where;
                if ($this->conn->query($sql)){
                    $response = DB::Status('pass','Record is Updated Successfully');
                }else{
                    $response = DB::Status('fail','Something Went Wrong');
                }

            }
        }
        return $response;
    }
}