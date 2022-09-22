<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create_user($a_username,$a_email,$a_password,$unit){
        $user_query = "SELECT * FROM tbl_user WHERE user_email='$a_email'";
        $user_obj = $this->conn->prepare($user_query);
        if ($user_obj->execute()){
            $data = $user_obj->get_result()->num_rows;
            if ($data > 0){
                return false;
            } else {
                $pass = password_hash($a_password, PASSWORD_DEFAULT);
                $user_query = "INSERT INTO tbl_user SET user_name='$a_username', user_email='$a_email',user_unit='$unit',user_password='$pass'";
                $user_obj = $this->conn->prepare($user_query);
                if ($user_obj->execute()){
                    return true;
                }
                return false;
            }
        }
        return false;
    }

    public function create_employee_account($e_n,$e_e,$e_u,$e_d,$a_by,$e_p) {
        $user_query = "INSERT INTO tbl_user SET user_name='$e_n',user_email='$e_e',user_password='$e_p',user_department='$e_d',
                        user_unit='$e_u',approval_by=$a_by";
        $user_obj = $this->conn->prepare($user_query);
        if ($user_obj->execute()) {
            return true;
        }
        return false;
    }

    public function check_email($e_e){
        $e_e = htmlspecialchars(strip_tags($e_e));
        $email_query = "SELECT * FROM tbl_user WHERE user_email='$e_e'";
        $user_obj = $this->conn->prepare($email_query);
        if ($user_obj->execute()){
            return $user_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function login_user($email) {
        $email_query = "SELECT * FROM tbl_user WHERE user_email='$email'";
        $user_obj = $this->conn->prepare($email_query);
        if ($user_obj->execute()){
            return $user_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function count_user_total_timesheets($e_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_timesheets WHERE employee_id=$e_id"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_user_approved_total_timesheets($e_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_timesheets WHERE employee_id=$e_id 
                    AND u_h_status='approved'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }


    public function count_user_last_hour_on_timesheets($e_id){
        $email_query = "SELECT *, (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total FROM tbl_timesheets t 
                        INNER JOIN tbl_user u ON t.employee_id=u.user_id LEFT JOIN tbl_timesheet_details td ON t.timesheet_id=td.timesheet_id 
                        WHERE t.u_h_status='approved' AND u.user_id=$e_id ORDER BY td.timesheet_detail_id DESC LIMIT 1";
        $user_obj = $this->conn->prepare($email_query);
        if ($user_obj->execute()){
            $data = $user_obj->get_result()->fetch_assoc();
            return $data['total'];
        }
        return 0;
    }

    public function list_all_dept(){
        $dept_query = "SELECT * FROM tbl_department ORDER BY department_name ASC";
        $dept_obj = $this->conn->prepare($dept_query);
        if ($dept_obj->execute()) {
            return $dept_obj->get_result();
        }
        return array();
    }

    public function get_user_timesheet_dept($t_id){
        $dept_query = "SELECT * FROM tbl_timesheets t INNER JOIN tbl_department d ON t.department_id=d.department_id WHERE t.timesheet_id=$t_id ";
        $dept_obj = $this->conn->prepare($dept_query);
        if ($dept_obj->execute()) {
            return $dept_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_user_weekly_project_dept($t_id){
        $dept_query = "SELECT * FROM tbl_weekly_planner w INNER JOIN tbl_department d ON w.department_id=d.department_id WHERE w.planner_id=$t_id ";
        $dept_obj = $this->conn->prepare($dept_query);
        if ($dept_obj->execute()) {
            return $dept_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_user_dept($d_id){
        $dept_query = "SELECT * FROM tbl_department WHERE department_id=$d_id ";
        $dept_obj = $this->conn->prepare($dept_query);
        if ($dept_obj->execute()) {
            return $dept_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_emp_units($e_d){
        $dep_query = "SELECT DISTINCT employee_designation FROM tbl_employee WHERE employee_designation IS NOT NULL AND department_id=$e_d";
        $dep_obj = $this->conn->prepare($dep_query);
        if ($dep_obj->execute()) {
            return $dep_obj->get_result();
        }
        return array();
    }



    public function get_employee_approval($app_id){
        $ru_query = "SELECT * FROM tbl_user WHERE user_id =$app_id";
        $ru_obj = $this->conn->prepare($ru_query);
        if ($ru_obj->execute()) {
            return $ru_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function list_all_aprroval_user(){
        $ru_query = "SELECT * FROM tbl_user u INNER JOIN tbl_department d ON u.user_department=d.department_id 
                     WHERE u.user_type<='approval' ORDER BY u.user_name ASC";
        $ru_obj = $this->conn->prepare($ru_query);
        if ($ru_obj->execute()) {
            return $ru_obj->get_result();
        }
        return array();
    }

    public function list_all_approval_timesheet($a_id){
        $ru_query = "SELECT * FROM tbl_timesheets t INNER JOIN tbl_department d ON t.department_id=d.department_id 
                    INNER JOIN tbl_user u ON t.employee_id=u.user_id WHERE u.approval_by=$a_id AND t.u_h_status !='approved' 
                    ORDER BY t.timesheet_id DESC";
        $ru_obj = $this->conn->prepare($ru_query);
        if ($ru_obj->execute()) {
            return $ru_obj->get_result();
        }
        return array();
    }

    public function list_all_user_timesheets($e_id){
        $u_time_query = "SELECT * FROM tbl_timesheets t
                        INNER JOIN tbl_department d ON t.department_id=d.department_id 
                        INNER JOIN tbl_user u ON t.employee_id=u.user_id WHERE u.user_id=$e_id ORDER BY t.timesheet_id DESC";
        $u_time_obj = $this->conn->prepare($u_time_query);
        if ($u_time_obj->execute()) {
            return $u_time_obj->get_result();
        }
        return array();
    }

    public function list_all_user_weekly_project_planner($e_id){
        $u_time_query = "SELECT * FROM tbl_weekly_planner w
                        INNER JOIN tbl_department d ON w.department_id=d.department_id 
                        INNER JOIN tbl_user u ON w.employee_id=u.user_id WHERE u.user_id=$e_id ORDER BY w.planner_id DESC";
        $u_time_obj = $this->conn->prepare($u_time_query);
        if ($u_time_obj->execute()) {
            return $u_time_obj->get_result();
        }
        return array();
    }

    public function get_timesheet_by_id($t_id){
        $time_query = "SELECT * FROM tbl_timesheets t INNER JOIN tbl_user u ON t.employee_id=u.user_id WHERE t.timesheet_id=$t_id LIMIT 1";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function get_weekly_project_planner_by_id($w_id){
        $week_query = "SELECT * FROM tbl_weekly_planner w INNER JOIN tbl_user u ON w.employee_id=u.user_id WHERE w.planner_id=$w_id LIMIT 1";
        $week_obj = $this->conn->prepare($week_query);
        if ($week_obj->execute()) {
            return $week_obj->get_result();
        }
        return array();
    }

    public function list_all_projects(){
        $proj_query = "SELECT * FROM tbl_projects ORDER BY project_name ASC";
        $proj_obj = $this->conn->prepare($proj_query);
        if ($proj_obj->execute()) {
            return $proj_obj->get_result();
        }
        return array();
    }

    public function list_distinct_project_category(){
        $proj_query = "SELECT DISTINCT project_category FROM tbl_projects ORDER BY project_category ASC";
        $proj_obj = $this->conn->prepare($proj_query);
        if ($proj_obj->execute()) {
            return $proj_obj->get_result();
        }
        return array();
    }

    public function list_timesheet_details($t_id){
        $time_query = "SELECT * FROM tbl_timesheet_details WHERE timesheet_id=$t_id";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function list_timesheet_details_approval($t_id){
        $time_query = "SELECT td.*,tp.* FROM tbl_timesheet_details td INNER JOIN tbl_projects tp ON td.project_id=tp.project_code WHERE td.timesheet_id=$t_id";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function list_current_weekly_project_planner_details($w_id){
        $time_query = "SELECT * FROM tbl_weekly_planner_details WHERE planner_id=$w_id AND p_type='CURRENT'";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function list_next_weekly_project_planner_details($w_id){
        $time_query = "SELECT * FROM tbl_weekly_planner_details WHERE planner_id=$w_id AND p_type='PROJECTED'";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function delete_user_timesheet($t_id,$e_id){
        $u_time_query = "DELETE FROM tbl_timesheets WHERE timesheet_id=$t_id AND employee_id=$e_id";
        $u_time_query2 = "DELETE FROM tbl_timesheet_details WHERE timesheet_id=$t_id";
        $u_time_obj = $this->conn->prepare($u_time_query);
        $u_time_obj2 = $this->conn->prepare($u_time_query2);
        if ($u_time_obj->execute()) {
            $u_time_obj2->execute();
            return true;
        }
        return false;
    }

    public function update_user_profile($e_n,$e_e,$e_u,$user_id){
        $update_query = "UPDATE tbl_user SET user_name='$e_n',user_email='$e_e',user_department='$e_u' WHERE user_id=$user_id";
        $update_obj = $this->conn->prepare($update_query);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_complete_user_profile($e_n,$e_e,$e_u,$new_pwd,$user_id){
        $update_query = "UPDATE tbl_user SET user_name='$e_n',user_email='$e_e',user_department='$e_u',user_password='$new_pwd' WHERE user_id=$user_id";
        $update_obj = $this->conn->prepare($update_query);
        if ($update_obj->execute()) {
            if ($update_obj->affected_rows > 0) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function get_user_emp_unit($e_id,$e_d){
        $dep_query = "SELECT * FROM tbl_user WHERE user_id=$e_id ";
        $dep_obj = $this->conn->prepare($dep_query);
        if ($dep_obj->execute()) {
            return $dep_obj->get_result();
        }
        return array();
    }

    public function count_total_employee(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_employee"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_total_projects_code(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_projects"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_total_timesheet(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_timesheets"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function list_all_timesheets(){
        $time_query = "SELECT * FROM tbl_timesheets t
                        INNER JOIN tbl_department d ON t.department_id=d.department_id 
                        INNER JOIN tbl_employee e ON t.employee_id=e.employee_id ORDER BY t.timesheet_id DESC";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function list_all_timesheets_by_super(){
        $time_query = "SELECT * FROM tbl_timesheets t
                        INNER JOIN tbl_department d ON t.department_id=d.department_id 
                        INNER JOIN tbl_employee e ON t.employee_id=e.employee_id 
                        WHERE t.u_h_status='approved' ORDER BY t.timesheet_id DESC";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function list_all_timesheets_by_unit($t_uid){
        $time_query = "SELECT * FROM tbl_timesheets t 
                        INNER JOIN tbl_department d ON t.department_id=d.department_id 
                        INNER JOIN tbl_employee e ON t.employee_id=e.employee_id
                        WHERE t.department_id=$t_uid ORDER BY t.timesheet_id DESC";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function get_emp_name($did){
        $name_query = "SELECT * FROM tbl_employee WHERE department_id=$did ORDER BY employee_name ASC";
        $name_obj = $this->conn->prepare($name_query);
        if ($name_obj->execute()) {
            return $name_obj->get_result();
        }
        return array();
    }

    public function get_emp_unit($ei){
        $name_query = "SELECT * FROM tbl_employee WHERE employee_id=$ei";
        $name_obj = $this->conn->prepare($name_query);
        if ($name_obj->execute()) {
            return $name_obj->get_result();
        }
        return array();
    }

    public function list_all_employee(){
        $proj_query = "SELECT * FROM tbl_employee e
                        INNER JOIN tbl_department d ON e.department_id=d.department_id ORDER BY e.department_id ASC";
        $proj_obj = $this->conn->prepare($proj_query);
        if ($proj_obj->execute()) {
            return $proj_obj->get_result();
        }
        return array();
    }

    public function list_distinct_emp(){
        $proj_query = "SELECT * FROM tbl_employee ORDER BY employee_name";
        $proj_obj = $this->conn->prepare($proj_query);
        if ($proj_obj->execute()) {
            return $proj_obj->get_result();
        }
        return array();
    }

    public function update_timesheet_status($t_id,$status,$comment){
        $up_query = "UPDATE tbl_timesheets SET u_h_status='$status' WHERE timesheet_id=$t_id";
        $up_obj = $this->conn->prepare($up_query);
        if ($up_obj->execute()){
            if ($status=='declined'){
                $res = $this->get_timesheet_by_id($t_id);
                while ($time = $res->fetch_assoc()) {
                    $this->send_declined_mail($time['user_name'],$time['user_email'],$time['from_date'],$time['to_date'],$comment);
                }
            }
            return true;
        }
        return false;
    }

    public function get_timesheet_approval_status($t_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_timesheets WHERE timesheet_id=$t_id AND u_h_status !='approved'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function send_declined_mail($name,$email,$from,$to,$message){
        $subject = "Timesheet Declined Alert!";
        $content = "<html>
                        <head>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>TEP Timesheet</title>
                            <style>
                                @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,700;0,900;1,300&display=swap');
                                body {font-family: 'Roboto', sans-serif;font-weight: 400}
                                .wrapper {max-width: 600px;margin: 0 auto}
                                .company-name {text-align: left}
                                table {width: 80%;}
                            </style>
                        </head>
                        <body>
                        <div class='wrapper'>
                            <table>
                                <thead>
                                    <tr><th class='table-head' colspan='4'><h1 class='company-name'>TEP Timesheet</h1></th></tr>
                                </thead>
                                <tbody>
                                    <div class='mt-3'>
                                        <p>Hi, ".$name."</p>
                                        <p>Your timesheet for <b>".$from."</b> to <b>".$to."</b> has been declined for the following reason: </p>
                                        <p>".$message."</a></p>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                        </body>
                        </html>";
        $mailHeaders ="MIME-Version: 1.0"."\r\n";
        $mailHeaders .="Content-type:text/html;charset=UTF-8"."\r\n";
        $mailHeaders .= "From: TEPTimesheet <".$email.">\r\n";
        if (mail($email, $subject, $content, $mailHeaders)) {
            return true;
        }
        return false;
    }

    public function list_distinct_emp_for_approval($u_id) {
        $user_query = "SELECT * FROM tbl_user WHERE approval_by=$u_id ORDER BY user_name";
        $user_obj = $this->conn->prepare($user_query);
        if ($user_obj->execute()) {
            return $user_obj->get_result();
        }
        return array();
    }

    public function estimated_days_worked($t_id){
        $q1 = mysqli_num_rows(mysqli_query($this->conn, "SELECT pro_sun FROM tbl_timesheet_details WHERE timesheet_id=$t_id AND pro_sun > 0"));
        if ($q1 > 0) $q1 =1; else $q1=0;
        $q2 = mysqli_num_rows(mysqli_query($this->conn, "SELECT pro_mon FROM tbl_timesheet_details WHERE timesheet_id=$t_id AND pro_mon > 0"));
        if ($q2 > 0) $q2 =1; else $q2=0;
        $q3 = mysqli_num_rows(mysqli_query($this->conn, "SELECT pro_tue FROM tbl_timesheet_details WHERE timesheet_id=$t_id AND pro_tue > 0"));
        if ($q3 > 0) $q3 =1; else $q3=0;
        $q4 = mysqli_num_rows(mysqli_query($this->conn, "SELECT pro_wed FROM tbl_timesheet_details WHERE timesheet_id=$t_id AND pro_wed > 0"));
        if ($q4 > 0) $q4 =1; else $q4=0;
        $q5 = mysqli_num_rows(mysqli_query($this->conn, "SELECT pro_thur FROM tbl_timesheet_details WHERE timesheet_id=$t_id AND pro_thur > 0"));
        if ($q5 > 0) $q5 =1; else $q5=0;
        $q6 = mysqli_num_rows(mysqli_query($this->conn, "SELECT pro_fri FROM tbl_timesheet_details WHERE timesheet_id=$t_id AND pro_fri > 0"));
        if ($q6 > 0) $q6 =1; else $q6=0;
        $q7 = mysqli_num_rows(mysqli_query($this->conn, "SELECT pro_sat FROM tbl_timesheet_details WHERE timesheet_id=$t_id AND pro_sat > 0"));
        if ($q7 > 0) $q7 =1; else $q7=0;

        return $q1+$q2+$q3+$q4+$q5+$q6+$q7;
    }

    public function count_total_timesheet_details($t_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_timesheet_details WHERE timesheet_id=$t_id"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function performance_sheet_approval_analysis($em_id){
        $ana_query = "SELECT *, (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total FROM tbl_timesheets t 
                                    INNER JOIN tbl_department d ON t.department_id=d.department_id 
                                    INNER JOIN tbl_user e ON t.employee_id=e.user_id LEFT JOIN tbl_timesheet_details td 
                                    ON t.timesheet_id=td.timesheet_id WHERE e.approval_by=$em_id ORDER BY t.timesheet_id DESC";
        $ana_obj = $this->conn->prepare($ana_query);
        if ($ana_obj->execute()) {
            return $ana_obj->get_result();
        }
        return array();
    }

    public function update_timesheet_details_rating($rating,$td_id){
        $up_query = "UPDATE tbl_timesheet_details SET app_rating=$rating WHERE timesheet_detail_id=$td_id";
        $up_obj = $this->conn->prepare($up_query);
        if ($up_obj->execute()){
            if ($up_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function sum_timesheet_details_rating($t_id){
        $td_query = "SELECT SUM(app_rating) AS sumRating FROM tbl_timesheet_details WHERE timesheet_id=$t_id";
        $td_obj = $this->conn->prepare($td_query);
        if ($td_obj->execute()) {
            $data = $td_obj->get_result();
            $sum =  $data->fetch_assoc();
            return $sum['sumRating'];
        }
        return 0;
    }

    public function get_total_emp_worked_hour_monthly($emp_id,$month,$year){
        $month = date("m",strtotime($month));
        $tot_hours = 0;
        $time_query = "SELECT (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total 
                        FROM tbl_timesheet_details td INNER JOIN tbl_timesheets t ON t.timesheet_id=td.timesheet_id 
                        WHERE t.employee_id=$emp_id AND MONTH(t.from_date)='$month' AND YEAR(t.from_date)='$year'";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            $lu = $time_obj->get_result();
            while ($emp = $lu->fetch_assoc()) {
                $tot_hours = $tot_hours + $emp['total'];
            }
            return $tot_hours;
        }
        return 0;
    }

    public function count_approval_total_user($app_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_user WHERE approval_by=$app_id"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_approval_timesheet_rating($t_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_timesheet_details WHERE timesheet_id=$t_id AND app_rating !=0"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_approval_timesheet($t_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_timesheet_details WHERE timesheet_id=$t_id"));
        if ($cnt > 0) return $cnt;
        return 0;
    }
}


?>