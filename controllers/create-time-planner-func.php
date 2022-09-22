<?php

header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

$filepath = realpath(dirname(__FILE__));
include_once($filepath."/../controllers/config/database.php");
$db = new Database();
$connect = $db->connect_pdo();

$number = count($_POST["pro_name"]);
$nxt_number = count($_POST["nxt_pro_name"]);
if ($number > 0 && $nxt_number>0) {
    $error=0;
    $nxt_error=0;
    $data = array(
        ':dept'=>$_POST["department"],':name'=>$_POST["employee_name"],':f_date'=>$_POST["from_date"],':t_date'=>$_POST["to_date"]
    );
    $query = "INSERT tbl_weekly_planner (department_id,employee_id,from_date,to_date) VALUES (:dept,:name,:f_date,:t_date)";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $wp_id = $connect->lastInsertId();

    for ($i = 0; $i < $number; $i++) {
        if ($_POST["pro_name"][$i]=='' || $_POST["task"][$i]=='') {
            $error = $error + 1;
        } else {
            $data_det = array(
                ':wp_id'=>$wp_id,
                ':pro_name'=>$_POST["pro_name"][$i],
                ':task'=>$_POST["task"][$i],
                ':com_rate'=> $_POST["com_rate"][$i],
                ':com_days'=> !empty($_POST["com_days"][$i]) ? $_POST["com_days"][$i]:0,
                ':comment'=>!empty($_POST["comment"][$i]) ? $_POST["comment"][$i]:'',
                ':type'=> $_POST["type"]
            );
            $query_det = "INSERT tbl_weekly_planner_details (planner_id,project_id,project_task,completion_rate,completion_days,comment,p_type) 
                        VALUES (:wp_id,:pro_name,:task,:com_rate,:com_days,:comment,:type)";
            $statement_det = $connect->prepare($query_det);
            $statement_det->execute($data_det);
        }
    }

    for ($i = 0; $i < $nxt_number; $i++) {
        if ($_POST["nxt_task"][$i]=='' || $_POST["nxt_pro_name"][$i]=='') {
            $nxt_error = $nxt_error + 1;
        } else {
            $data_det2 = array(
                ':wp_id'=>$wp_id,
                ':nxt_pro_name'=>$_POST["nxt_pro_name"][$i],
                ':nxt_task'=>$_POST["nxt_task"][$i],
                ':nxt_com_rate'=> $_POST["nxt_com_rate"][$i],
                ':nxt_com_days'=> !empty($_POST["nxt_com_days"][$i]) ? $_POST["nxt_com_days"][$i]:0,
                ':nxt_comment'=>!empty($_POST["nxt_comment"][$i]) ? $_POST["nxt_comment"][$i]:'',
                ':nxt_type'=>$_POST["nxt_type"]
            );
            $query_det2 = "INSERT tbl_weekly_planner_details (planner_id,project_id,project_task,completion_rate,completion_days,comment,p_type) 
                        VALUES (:wp_id,:nxt_pro_name,:nxt_task,:nxt_com_rate,:nxt_com_days,:nxt_comment,:nxt_type)";
            $statement_det2 = $connect->prepare($query_det2);
            $statement_det2->execute($data_det2);
        }
    }

    if ($error == 0 && $nxt_error == 0) {
        http_response_code(200);echo json_encode(array("status"=>200,"message"=>'Weekly time & project planner created'));
    } else {
        http_response_code(400);echo json_encode(array("status"=>400,"message"=>'Task/project code cannot be empty'));
    }
} else {
    http_response_code(400);
    echo json_encode(array("status"=>400,"message"=>"No Weekly time & project planner added."));
}

?>
