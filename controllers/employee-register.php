<?php
header("Content-type: application/json; charset=UTF-8");
include_once('config/database.php');
include_once('classes/User.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$user = new User($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $e_n = htmlspecialchars(strip_tags($_POST['emp_name']));
    $e_e = htmlspecialchars(strip_tags($_POST['emp_email']));
    $e_d = htmlspecialchars(strip_tags($_POST['emp_department']));
    $e_u = htmlspecialchars(strip_tags($_POST['emp_unit']));
    $a_by = htmlspecialchars(strip_tags($_POST['emp_approval']));
    $e_p = htmlspecialchars(strip_tags($_POST['emp_password']));
    $e_r = htmlspecialchars(strip_tags($_POST['emp_rep_password']));
    $captcha_answer = htmlspecialchars(strip_tags($_POST['captcha_answer']));

    if (!empty($e_n) && !empty($e_e) && !empty($e_u) && !empty($e_d) && !empty($a_by) && !empty($e_p) && !empty($e_r) && !empty($captcha_answer)) {
        if ($e_p !== $e_r){
            http_response_code(500);
            echo json_encode(array("status"=>500,"message"=>"Password combination did not match."));
        } else {
            if ($captcha_answer != 48){
                http_response_code(500);
                echo json_encode(array("status"=>500,"message"=>"Incorrect caption answer."));
            } else {
                $email_data = $user->check_email($e_e);
                if (!empty($email_data)) {
                    http_response_code(422);
                    echo json_encode(array("status" => 422, "message" => "Email already in use"));
                } else {
                    $result = $user->create_employee_account($e_n,$e_e,$e_u,$e_d,$a_by,password_hash($e_p, PASSWORD_DEFAULT));
                    if ($result) {
                        http_response_code(200);
                        echo json_encode(array(
                            "status" => 200, "message" => "Employee account created successfully, click ok to proceed to login."
                        ));
                    } else {
                        http_response_code(400);
                        echo json_encode(array("status" => 400, "message" => "Failed to create account"));
                    }
                }
            }
        }
    } else {
        http_response_code(500);
        echo json_encode(array("status"=>500,"message"=>"Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status"=>503,"message"=>"Access Denied"));
}