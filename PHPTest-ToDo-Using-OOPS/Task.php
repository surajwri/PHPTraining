<?php


class Task
{
    private static $conn = null;
    private static $statusResponse=array();
    public $pdo;
    public function __construct()
    {
        try{
            Task::$conn = new mysqli('localhost','root','','phptraining');
        }catch (Exception $e){
            die($e->getMessage());
        }

    }

    //============================= Event Status Task =========================================================

    public static function Status($status,$message){
        Task::$statusResponse['status'] = $status;
        Task::$statusResponse['message'] = $message;
        return Task::$statusResponse;
    }

    //============================= Get All Task =========================================================

    public function getTask($table, $where=null,$limit=null){
        $sql = "SELECT * FROM ".$table;
        if (isset($where)){
            $sql.=" WHERE ".$where;
        }
        $sql.=" ORDER BY `id` DESC ".$limit;
        $rs = Task::$conn->query($sql);
        while($row = $rs->fetch_assoc()){
            $response[]=$row;
        }
        return $response;
    }


    //============================= Get Pagination =========================================================

    public function getTaskPagination($table){
        $data = $this->getTask($table);
        $response['rpp']=5;
        $response['np']=ceil((count($data)/$response['rpp']));
        return $response;
    }

    //============================= Delete Task =========================================================

    public function deleteTask($table, $where=null){
        if (is_null($where)){
            $response = Task::Status('fail','Where clause is missing');
        }else{
            $sql = "DELETE FROM ".$table." WHERE $where";
            if (Task::$conn->query($sql)){
                $response = Task::Status('pass','Task is Deleted Successfully');
            }else{
                $response = Task::Status('fail','Something Went Wrong');
            }
        }
        return $response;
    }

    //=========================== Create A Task ===========================================================

    public function createTask($table,$input=array())
    {
        $sql = "INSERT INTO " . $table;
        if (empty($input)) {
            $response = Task::Status('fail','input values not provided');
        } else {
            if ($input === array_values($input)) {
                $response = Task::Status('fail','input array not valid');
            } else {
                $feilds = array_keys($input);
                $feildsValues = array_values($input);
                $feilds = implode("`, `", $feilds);
                $feildsValues = implode("', '", $feildsValues);
                $feilds= " (`".$feilds."`)";
                $feildsValues= "('".$feildsValues."')";
                $sql.=$feilds." VALUES ".$feildsValues;
                if (Task::$conn->query($sql)){
                    $response = Task::Status('pass','Task is Inserted Successfully');
                }else{
                    $response = Task::Status('fail','Something Went Wrong');

                }
            }
        }
        return $response;
    }

    //================================ Change Task Status ======================================================

    public function taskStatus($table,$id)
    {
        $input=array();
        $where="id=$id";
        $data = $this->getTask($table, "id=$id");
        if ($data[0]['status']==0){
            $input['status']=1;
        }else{
            $input['status']=0;
        }

        $sql = "UPDATE " . $table." SET ";
        if (empty($input)) {
            $response = Task::Status('fail','input values not provided');
        } else {
            if ($input === array_values($input)) {
                $response = Task::Status('fail','input array not valid');
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
                if (Task::$conn->query($sql)){
                    $response = Task::Status('pass','Task is Updated Successfully');
                }else{
                    $response = Task::Status('fail','Something Went Wrong');
                }

            }
        }
        return $response;
    }
}
