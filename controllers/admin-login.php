<?php
session_start();
header("Content-type: application/json; charset=UTF-8");
include_once('config/database.php');
include_once('classes/Admin.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$adm = new Admin($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!empty($_POST['adm_email']) && !empty($_POST['adm_password'])) {
        $adm_data = $adm->login_admin($_POST['adm_email']);
        if (!empty($adm_data)){
            $email = $adm_data['adm_email'];
            $password = $adm_data['adm_password'];

            if (password_verify($_POST['adm_password'],$password)){
                $account_arr = array(
                    "adm_id"=>$adm_data['adm_id'],"adm_email"=>$adm_data['adm_email'],"adm_name"=>$adm_data['adm_name'],
                    "adm_uhead"=>$adm_data['adm_uhead']
                );
                http_response_code(200);
                echo json_encode(array("status"=>200,"adm_details"=>$account_arr,"message"=>"Admin logged in successfully"));
                $_SESSION['adm_login'] = $account_arr;
                $_SESSION['adm_last_login_timestamp'] = time();
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