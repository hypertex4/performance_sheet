<?php ob_start(); session_start();
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
$filepath = realpath(dirname(__FILE__));
include_once($filepath."/../controllers/config/database.php");
include_once($filepath."/../controllers/classes/User.class.php");
$db = new Database();
$connection = $db->connect();
$user = new User($connection);

if (isset($_POST['t_id']) && isset($_POST['action_code']) && $_POST['action_code']==101){
    if ($user->delete_user_timesheet($_POST['t_id'],$_SESSION['emp_login']['emp_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Timesheet deleted successfully."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to delete timesheet, try again later"));
    }
}

if (isset($_POST['time_id']) && isset($_POST['status']) && isset($_POST['action_code']) && $_POST['action_code']==103){
    if ($user->update_timesheet_status($_POST['time_id'],$_POST['status'],"")){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Timesheet status updated and mark as approved."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to update status"));
    }
}

if (isset($_POST['time_id']) && isset($_POST['status']) && isset($_POST['action_code']) && $_POST['action_code']==102){
    if ($user->update_timesheet_status($_POST['time_id'],$_POST['status'],$_POST['comment'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Timesheet status updated and mark as declined."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to update status"));
    }
}

if (isset($_POST['rating']) && isset($_POST['td_id']) && isset($_POST['action_code']) && $_POST['action_code']==403){
    if ($user->update_timesheet_details_rating($_POST['rating'],$_POST['td_id'])){
        http_response_code(200);
        echo json_encode(array("status"=>200,"message"=>"Task rating completed successfully."));
    } else {
        http_response_code(400);
        echo json_encode(array("status"=>400,"message"=>"Fail to update task rating"));
    }
}

?>