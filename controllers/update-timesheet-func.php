<?php

header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

$filepath = realpath(dirname(__FILE__));
include_once($filepath."/../controllers/config/database.php");
$db = new Database();
$connect = $db->connect_pdo();

$number = count($_POST["code"]);
if ($number > 0) {
    $error=0;
    $data = array(
        ':dept'=>$_POST["department"],':emp_id'=>$_POST["employee_name"],':f_date'=>$_POST["from_date"],
        ':t_date'=>$_POST["to_date"]
    );
    $query = "UPDATE tbl_timesheets SET department_id=:dept,employee_id=:emp_id,from_date=:f_date,to_date=:t_date WHERE timesheet_id=".$_POST['ts_id'];
    $statement = $connect->prepare($query);
    $statement->execute($data);

    $query2 = "DELETE FROM tbl_timesheet_details WHERE timesheet_id=".$_POST['ts_id'];
    $statement2 = $connect->prepare($query2);
    $statement2->execute();

    for ($i = 1; $i <= $number; $i++) {
        if ($_POST["code"][$i]=='' || $_POST["task"][$i]=='') {
            $error = $error + 1;
        } else {
            $data_det = array(
                ':ts_id'=>$_POST['ts_id'],':code'=>$_POST["code"][$i], ':task'=>$_POST["task"][$i],
                ':sun'=>!empty($_POST["sun"][$i]) ? $_POST["sun"][$i]:0,':mon'=>!empty($_POST["mon"][$i]) ? $_POST["mon"][$i]:0,
                ':tue'=>!empty($_POST["tue"][$i]) ? $_POST["tue"][$i]:0,':wed'=>!empty($_POST["wed"][$i]) ? $_POST["wed"][$i]:0,
                ':thur'=>!empty($_POST["thur"][$i]) ? $_POST["thur"][$i]:0,':fri'=>!empty($_POST["fri"][$i]) ? $_POST["fri"][$i]:0,
                ':sat'=>!empty($_POST["sat"][$i]) ? $_POST["sat"][$i]:0,
                ':p_complete'=>!empty($_POST["p_comp"][$i]) ? $_POST["p_comp"][$i]:'',
                ':c_days'=>!empty($_POST["com_days"][$i]) ? $_POST["com_days"][$i]:'',
                ':result'=>!empty($_POST["result"][$i]) ? $_POST["result"][$i]:''
            );
            $query_det = "INSERT tbl_timesheet_details (timesheet_id,project_id,project_task,pro_sun,pro_mon,pro_tue,pro_wed,pro_thur,pro_fri,pro_sat,percent_complete,completion_days,result) 
                        VALUES (:ts_id,:code,:task,:sun,:mon,:tue,:wed,:thur,:fri,:sat,:p_complete,:c_days,:result)";
            $statement_det = $connect->prepare($query_det);
            $statement_det->execute($data_det);
        }
    }

    if ($error == 0) {
        http_response_code(200);echo json_encode(array("status"=>200,"message"=>'Timesheet updated successfully'));
    } else {
        http_response_code(400);echo json_encode(array("status"=>400,"message"=>'Task/project code cannot be empty'));
    }
} else {
    http_response_code(400);
    echo json_encode(array("status"=>400,"message"=>"No timesheet added."));
}

?>
