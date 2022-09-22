<?php
ob_start(); session_start();
header("Content-type: application/json; charset=UTF-8");
include_once('config/database.php');
include_once('classes/Admin.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$adm = new Admin($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $a_n = $_POST['adm_name'];
    $a_e = $_POST['adm_email'];
    $a_n_p = $_POST['adm_new_pwd'];
    $a_rn_p = $_POST['adm_rep_new_pwd'];

    if (!empty($a_n) && !empty($a_e)) {
        if (!empty(trim($a_n_p))){
            if (empty(trim($a_rn_p)) || strlen($a_n_p) < 6) {
                http_response_code(404);
                echo json_encode(array("status"=>404,"message"=>"New/Repeat password must be at least six(6) character"));
            } else {
                if (trim($a_n_p) !== trim($a_rn_p)) {
                    http_response_code(500);
                    echo json_encode(array("status"=>500,"message"=>"New password combination did not match, try again."));
                } else {
                    $email = $_SESSION['adm_login']['adm_email'];
                    $adm_data = $adm->login_admin($email);
                    if (password_verify($a_n_p,$adm_data['adm_password'])) {
                        http_response_code(500);
                        echo json_encode(array("status" =>500,"message"=>"Password already in use."));
                    } else {
                        $adm_id = $_SESSION['adm_login']['adm_id'];
                        $new_pwd = password_hash($a_n_p,PASSWORD_DEFAULT);

                        if ($adm->update_complete_user_profile($a_n,$a_e,$new_pwd,$adm_id)){
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
            $adm_id = $_SESSION['adm_login']['adm_id'];
            if ($adm->update_user_profile($a_n,$a_e,$adm_id)) {
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