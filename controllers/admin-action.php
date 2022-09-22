<?php
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
include_once ('../controllers/classes/Admin.class.php');

$db = new Database();
$connection = $db->connect();
$adm = new Admin($connection);

if (isset($_POST['time_id']) && isset($_POST['status']) && isset($_POST['action_code']) && $_POST['action_code']==101){
    if ($adm->update_timesheet_status($_POST['time_id'],$_POST['status'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Timesheet status updated and mark as approved."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to update status"));
    }
}

if (isset($_POST['p_id']) && isset($_POST['action_code']) && $_POST['action_code']==106){
    if ($adm->delete_user_weekly_planner($_POST['p_id'],$_POST['user_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Weekly Time Project Planner deleted successfully."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to delete Weekly Time Project Planner, try again later"));
    }
}

if (isset($_POST['time_id']) && isset($_POST['status']) && isset($_POST['action_code']) && $_POST['action_code']==102){
    if ($adm->update_timesheet_status($_POST['time_id'],$_POST['status'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Timesheet status updated and mark as declined."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to update status"));
    }
}

if (isset($_POST['dept_name']) && isset($_POST['action_code']) && $_POST['action_code']==201){
    if ($adm->add_department($_POST['dept_name'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Department successfully added."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to add department."));
    }
}

if (isset($_POST['edit_dept_id']) && isset($_POST['edit_dept_name']) && isset($_POST['action_code']) && $_POST['action_code']==202){
    if ($adm->update_department($_POST['edit_dept_name'],$_POST['edit_dept_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Department successfully updated."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to update department."));
    }
}

if (isset($_POST['d_id']) && isset($_POST['action_code']) && $_POST['action_code']==203){
    if ($adm->delete_department($_POST['d_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Department successfully deleted."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to delete department."));
    }
}

if (isset($_POST['proj_name']) && isset($_POST['proj_code']) && isset($_POST['action_code']) && $_POST['action_code']==301){
    if ($adm->add_project($_POST['proj_name'],$_POST['proj_code'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Project successfully added."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to add project."));
    }
}

if (isset($_POST['edit_proj_id']) && isset($_POST['edit_proj_name']) && isset($_POST['action_code']) && $_POST['action_code']==302){
    if ($adm->update_project($_POST['edit_proj_name'],$_POST['edit_proj_code'],$_POST['edit_proj_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Project successfully updated."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to update project."));
    }
}

if (isset($_POST['p_id']) && isset($_POST['action_code']) && $_POST['action_code']==303){
    if ($adm->delete_project($_POST['p_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Project successfully deleted."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to delete project."));
    }
}

if (isset($_POST['emp_name']) && isset($_POST['emp_email']) && isset($_POST['emp_dept']) && isset($_POST['action_code']) && $_POST['action_code']==401){
    if ($adm->add_employee($_POST['emp_name'],$_POST[''],$_POST['emp_dept'],$_POST['emp_design'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Employee successfully added."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to add employee."));
    }
}

if (isset($_POST['edit_emp_name']) && isset($_POST['edit_emp_email']) && isset($_POST['action_code']) && $_POST['action_code']==402){
    if ($adm->update_employee($_POST['edit_emp_name'],$_POST['edit_emp_email'],$_POST['edit_emp_dept'],$_POST['edit_emp_design'],$_POST['edit_user_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Employee record successfully updated."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to update employee record / No changes detected."));
    }
}

if (isset($_POST['u_id']) && isset($_POST['action_code']) && $_POST['action_code']==403){
    if ($adm->delete_employee($_POST['u_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Employee successfully deleted."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to delete employee."));
    }
}

?>