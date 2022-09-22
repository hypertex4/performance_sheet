<?php
session_start();
header("Content-type: application/json; charset=UTF-8");
include_once('config/database.php');
include_once('classes/User.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$user = new User($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!empty($_POST['emp_email']) && !empty($_POST['emp_password'])) {
        $user_data = $user->login_user($_POST['emp_email']);
        if (!empty($user_data)){
            $email = $user_data['user_email'];
            $password = $user_data['user_password'];

            if (password_verify($_POST['emp_password'],$password)){
                $account_arr = array(
                    "emp_id"=>$user_data['user_id'],"emp_email"=>$user_data['user_email'],"emp_name"=>$user_data['user_name'],
                    "emp_department"=>$user_data['user_department'],"emp_unit"=>$user_data['user_unit'],"user_type"=>$user_data['user_type'],
                    "approval_by"=>$user_data['approval_by']
                );
                if ($user_data['user_type']=="user"){ $location = "account/index"; }
                else if ($user_data['user_type']=="approval") { $location= "approval/index"; }
                $_SESSION['emp_login'] = $account_arr;
                $_SESSION['emp_last_login_timestamp'] = time();
                http_response_code(200);
                echo json_encode(array("status"=>200,"emp_details"=>$account_arr,"message"=>"User logged in successfully","location"=>$location));
            } else {
                http_response_code(422);
                echo json_encode(array("status"=>422,"message"=>"Password incorrect. Contact admin."));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("status"=>404,"message"=>"Email does not match any record."));
        }
    } else {
        http_response_code(500);
        echo json_encode(array("status"=>500,"message"=>"Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status"=>503,"message"=>"Access Denied"));
}