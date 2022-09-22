<?php
ob_start(); session_start();
header("Content-type: application/json; charset=UTF-8");
include_once('config/database.php');
include_once('classes/User.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$user = new User($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $e_n = $_POST['emp_name'];
    $e_e = $_POST['emp_email'];
    $e_u = $_POST['emp_unit'];
    $e_n_p = $_POST['emp_new_pwd'];
    $e_rn_p = $_POST['emp_rep_new_pwd'];

    if (!empty($e_n) && !empty($e_e) && !empty($e_u)) {
        if (!empty(trim($e_n_p))){
            if (empty(trim($e_rn_p)) || strlen($e_n_p) < 6) {
                http_response_code(404);
                echo json_encode(array("status"=>404,"message"=>"New/Repeat password must be at least six(6) character"));
            } else {
                if (trim($e_n_p) !== trim($e_rn_p)) {
                    http_response_code(500);
                    echo json_encode(array("status"=>500,"message"=>"New password combination did not match, try again."));
                } else {
                    $email = $_SESSION['emp_login']['emp_email'];
                    $user_data = $user->login_user($email);
                    if (password_verify($e_n_p,$user_data['user_password'])) {
                        http_response_code(500);
                        echo json_encode(array("status" =>500,"message"=>"Password already in use."));
                    } else {
                        $user_id = $_SESSION['emp_login']['emp_id'];
                        $new_pwd = password_hash($e_n_p,PASSWORD_DEFAULT);

                        if ($user->update_complete_user_profile($e_n,$e_e,$e_u,$new_pwd,$user_id)){
                            http_response_code(200);
                            echo json_encode(array("status"=>200,"message"=>"Your account has been updated. N.B.Changes will take effect on your next login."));
                        } else {
                            http_response_code(500);
                            echo json_encode(array("status" =>500,"message"=>"Failed to update account, contact admin via the help line"));
                        }
                    }
                }
            }
        } else {
            $user_id = $_SESSION['emp_login']['emp_id'];
            if ($user->update_user_profile($e_n,$e_e,$e_u,$user_id)) {
                http_response_code(200);
                echo json_encode(array("status" => 200, "message" => "Your account has been updated. N.B. Changes will take effect on your next login."));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => 400, "message" => "Hey!, no changes on user profile"));
            }
        }
    } else {
        http_response_code(500);
        echo json_encode(array("status" => 500, "message" => "Kindly fill the required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}