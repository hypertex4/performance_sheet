<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');

class Admin {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create_user($a_u,$a_e,$a_p,$a_uh){
        $user_query = "SELECT * FROM tbl_admin WHERE adm_email='$a_e'";
        $user_obj = $this->conn->prepare($user_query);
        if ($user_obj->execute()){
            $data = $user_obj->get_result()->num_rows;
            if ($data > 0){
                return false;
            } else {
                $pass = password_hash($a_p, PASSWORD_DEFAULT);
                $user_query = "INSERT INTO tbl_admin SET adm_name='$a_u', adm_email='$a_e',adm_password='$pass',adm_uhead=$a_uh";
                $user_obj = $this->conn->prepare($user_query);
                if ($user_obj->execute()){
                    return true;
                }
                return false;
            }
        }
        return false;
    }

    public function login_admin($a_e) {
        $email_query = "SELECT * FROM tbl_admin WHERE adm_email='$a_e'";
        $adm_obj = $this->conn->prepare($email_query);
        if ($adm_obj->execute()){
            return $adm_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function update_user_profile($a_n,$a_e,$adm_id){
        $update_query = "UPDATE tbl_admin SET adm_name='$a_n',adm_email='$a_e' WHERE adm_id=$adm_id";
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

    public function update_complete_user_profile($a_n,$a_e,$new_pwd,$adm_id){
        $update_query = "UPDATE tbl_admin SET adm_name='$a_n',adm_email='$a_e',adm_password='$new_pwd' WHERE adm_id=$adm_id";
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

    public function get_adm_dept($d_id){
        $dept_query = "SELECT * FROM tbl_department WHERE department_id=$d_id";
        $dept_obj = $this->conn->prepare($dept_query);
        if ($dept_obj->execute()) {
            return $dept_obj->get_result()->fetch_assoc();
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

    public function count_registered_employee(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_user"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_approved_timesheet(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_timesheets WHERE u_h_status='approved'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function list_all_timesheets_by_super(){
        $time_query = "SELECT * FROM tbl_timesheets t
                        INNER JOIN tbl_department d ON t.department_id=d.department_id 
                        INNER JOIN tbl_user u ON t.employee_id=u.user_id 
                        WHERE t.u_h_status!='approved222' ORDER BY t.timesheet_id DESC";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function list_all_user_weekly_project_planner(){
        $week_query = "SELECT * FROM tbl_weekly_planner p
                        INNER JOIN tbl_department d ON p.department_id=d.department_id 
                        INNER JOIN tbl_user u ON p.employee_id=u.user_id ORDER BY p.planner_id DESC";
        $week_obj = $this->conn->prepare($week_query);
        if ($week_obj->execute()) {
            return $week_obj->get_result();
        }
        return array();
    }

    public function get_user_weekly_project_planner_current_id($w_id){
        $week_query = "SELECT * FROM tbl_weekly_planner w INNER JOIN tbl_user u ON w.employee_id=u.user_id WHERE w.planner_id=$w_id LIMIT 1";
        $week_obj = $this->conn->prepare($week_query);
        if ($week_obj->execute()) {
            return $week_obj->get_result();
        }
        return array();
    }

    public function list_current_weekly_project_planner_details($w_id){
        $time_query = "SELECT * FROM tbl_weekly_planner_details wp INNER JOIN tbl_projects pj
                        ON wp.project_id = pj.project_code WHERE wp.planner_id=$w_id AND wp.p_type='CURRENT'";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function list_next_weekly_project_planner_details($w_id){
        $time_query = "SELECT * FROM tbl_weekly_planner_details wp INNER JOIN tbl_projects pj
                        ON wp.project_id = pj.project_code WHERE wp.planner_id=$w_id AND p_type='PROJECTED'";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
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

    public function list_all_timesheets_by_unit($t_uid) {
        $time_query = "SELECT * FROM tbl_timesheets t 
                        INNER JOIN tbl_department d ON t.department_id=d.department_id 
                        INNER JOIN tbl_user u ON t.employee_id=u.user_id 
                        WHERE t.department_id=$t_uid ORDER BY t.timesheet_id DESC";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function get_timesheet_by_id($t_id){
        $time_query = "SELECT * FROM tbl_timesheets t INNER JOIN tbl_user u ON t.employee_id=u.user_id 
                        INNER JOIN tbl_department d ON u.user_department = d.department_id WHERE t.timesheet_id=$t_id LIMIT 1";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
        }
        return array();
    }

    public function list_all_dept(){
        $dept_query = "SELECT * FROM tbl_department ORDER BY department_name ASC";
        $dept_obj = $this->conn->prepare($dept_query);
        if ($dept_obj->execute()) {
            return $dept_obj->get_result();
        }
        return array();
    }

    public function list_all_registered_user(){
        $ru_query = "SELECT * FROM tbl_user u
                        INNER JOIN tbl_department d ON u.user_department=d.department_id ORDER BY u.user_department ASC";
        $ru_obj = $this->conn->prepare($ru_query);
        if ($ru_obj->execute()) {
            return $ru_obj->get_result();
        }
        return array();
    }

    public function get_emp_unit($ei){
        $name_query = "SELECT DISTINCT employee_designation FROM tbl_employee WHERE department_id=$ei";
        $name_obj = $this->conn->prepare($name_query);
        if ($name_obj->execute()) {
            return $name_obj->get_result();
        }
        return array();
    }

    public function list_all_distinct_designation(){
        $proj_query = "SELECT DISTINCT employee_designation FROM tbl_employee ORDER BY employee_designation ASC";
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

    public function list_timesheet_details_full($t_id){
        $time_query = "SELECT td.*,tp.* FROM tbl_timesheet_details td INNER JOIN tbl_projects tp ON td.project_id=tp.project_code WHERE td.timesheet_id=$t_id";
        $time_obj = $this->conn->prepare($time_query);
        if ($time_obj->execute()) {
            return $time_obj->get_result();
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

    public function get_reg_emp_name($did){
        $name_query = "SELECT * FROM tbl_user WHERE user_department=$did ORDER BY user_department ASC";
        $name_obj = $this->conn->prepare($name_query);
        if ($name_obj->execute()) {
            return $name_obj->get_result();
        }
        return array();
    }

    public function get_reg_emp_designation($ei){
        $name_query = "SELECT * FROM tbl_user WHERE user_id=$ei";
        $name_obj = $this->conn->prepare($name_query);
        if ($name_obj->execute()) {
            return $name_obj->get_result();
        }
        return array();
    }

    public function update_timesheet_status($t_id,$status){
        $up_query = "UPDATE tbl_timesheets SET u_h_status='$status' WHERE timesheet_id=$t_id";
        $up_obj = $this->conn->prepare($up_query);
        if ($up_obj->execute()){
            return true;
        }
        return false;
    }

    public function delete_user_weekly_planner($p_id,$user_id){
        $u_time_query = "DELETE FROM tbl_weekly_planner WHERE planner_id=$p_id AND employee_id=$user_id";
        $u_time_query2 = "DELETE FROM tbl_weekly_planner_details WHERE planner_id=$p_id";
        $u_time_obj = $this->conn->prepare($u_time_query);
        $u_time_obj2 = $this->conn->prepare($u_time_query2);
        if ($u_time_obj->execute()) {
            $u_time_obj2->execute();
            return true;
        }
        return false;
    }

    public function add_department($d_name){
        $dep_query = "SELECT * FROM tbl_department WHERE department_name='$d_name'";
        $dep_obj = $this->conn->prepare($dep_query);
        if ($dep_obj->execute()){
            $data = $dep_obj->get_result()->num_rows;
            if ($data > 0){
                return false;
            } else {
                $admin_query = "INSERT INTO tbl_department SET department_name='$d_name'";
                $admin_obj = $this->conn->prepare($admin_query);
                if ($admin_obj->execute()){
                    return true;
                }
                return false;
            }
        }
        return false;
    }

    public function update_department($d_name,$d_id){
        $dept_query = "UPDATE tbl_department SET department_name='$d_name' WHERE department_id=$d_id";
        $dept_obj = $this->conn->prepare($dept_query);
        if ($dept_obj->execute()){
            if ($dept_obj->affected_rows > 0){
                return true;
            }
            return false;
        }
        return false;
    }

    public function delete_department($d_id){
        $del_query = "DELETE FROM tbl_department WHERE department_id=$d_id";
        $del_obj = $this->conn->prepare($del_query);
        if ($del_obj->execute()){
            if ($del_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;

    }

    public function add_project($p_name,$p_code){
        $pro_query = "SELECT * FROM tbl_projects WHERE project_name='$p_name' AND project_code='$p_code'";
        $pro_obj = $this->conn->prepare($pro_query);
        if ($pro_obj->execute()){
            $data = $pro_obj->get_result()->num_rows;
            if ($data > 0){
                return false;
            } else {
                $admin_query = "INSERT INTO tbl_projects SET project_name='$p_name', project_code='$p_code'";
                $admin_obj = $this->conn->prepare($admin_query);
                if ($admin_obj->execute()){
                    return true;
                }
                return false;
            }
        }
        return false;
    }

    public function update_project($p_name,$p_code,$p_id){
        $proj_query = "UPDATE tbl_projects SET project_name='$p_name', project_code='$p_code' WHERE project_id=$p_id";
        $proj_obj = $this->conn->prepare($proj_query);
        if ($proj_obj->execute()){
            if ($proj_obj->affected_rows > 0){
                return true;
            }
            return false;
        }
        return false;
    }

    public function delete_project($p_id){
        $del_query = "DELETE FROM tbl_projects WHERE project_id=$p_id";
        $del_obj = $this->conn->prepare($del_query);
        if ($del_obj->execute()){
            if ($del_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;

    }

//    public function add_employee($p_name,$p_code){
//        $pro_query = "SELECT * FROM tbl_user WHERE project_name='$p_name' AND project_code='$p_code'";
//        $pro_obj = $this->conn->prepare($pro_query);
//        if ($pro_obj->execute()){
//            $data = $pro_obj->get_result()->num_rows;
//            if ($data > 0){
//                return false;
//            } else {
//                $admin_query = "INSERT INTO tbl_projects SET project_name='$p_name', project_code='$p_code'";
//                $admin_obj = $this->conn->prepare($admin_query);
//                if ($admin_obj->execute()){
//                    return true;
//                }
//                return false;
//            }
//        }
//        return false;
//    }

    public function update_employee($e_name,$e_email,$e_dept,$e_design,$u_id){
        $user_query = "UPDATE tbl_user SET user_name='$e_name',user_email='$e_email',user_department=$e_dept,user_unit='$e_design' WHERE user_id=$u_id";
        $user_obj = $this->conn->prepare($user_query);
        if ($user_obj->execute()){
            if ($user_obj->affected_rows > 0){
                return true;
            }
            return false;
        }
        return false;
    }

    public function delete_employee($u_id){
        $del_query = "DELETE FROM tbl_user WHERE user_id=$u_id";
        $del_obj = $this->conn->prepare($del_query);
        if ($del_obj->execute()){
            if ($del_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;

    }

    public function list_distinct_emp() {
        $user_query = "SELECT * FROM tbl_user ORDER BY user_name";
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
            return number_format($tot_hours,0);
        }
        return 0;
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

}
?>