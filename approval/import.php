<?php
session_start();
header('Content-type: text/html; charset=utf-8');
header("Cache-Control: no-cache; must-revalidate");
header("Pragma: no-cache");

$filepath = realpath(dirname(__FILE__));
include_once($filepath."/../controllers/config/database.php");
$db = new Database();
$connect = $db->connect_pdo();

if (isset($_SESSION['csv_file_name'])){
    $file_data = fopen('file/' . $_SESSION['csv_file_name'], 'r');
    fgetcsv($file_data);

    $data = array(
        ':dept'=>$_POST["dept"],':name'=>$_POST["name"],':f_date'=>$_POST["from"],':t_date'=>$_POST["to"]
    );
    $query = "INSERT tbl_timesheets (department_id,employee_id,from_date,to_date) VALUES (:dept,:name,:f_date,:t_date)";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $ts_id = $connect->lastInsertId();

    while ($row = fgetcsv($file_data)){
        $data_det = array(
            ':ts_id'=>$ts_id,
            ':code'=>!empty($row[0]) ? $row[0]:0,':task'=>!empty($row[1]) ? $row[1]:0,':sun' => !empty($row[2])? $row[2]:0,
            ':mon' => !empty($row[3])? $row[3]:0, ':tue' => !empty($row[4])? $row[4]:0, ':wed' => !empty($row[5])? $row[5]:0,
            ':thur' => !empty($row[6])? $row[6]:0, ':fri' => !empty($row[7])? $row[7]:0, ':sat' => !empty($row[8])? $row[8]:0,
            ':percent_complete' => !empty($row[9])? $row[9]:'',':completion_days' => !empty($row[9])? $row[9]:'',':result' => !empty($row[9])? $row[9]:''
        );


        $query_det = "INSERT tbl_timesheet_details (timesheet_id,project_id,project_task,pro_sun,pro_mon,pro_tue,pro_wed,pro_thur,pro_fri,pro_sat,percent_complete,completion_days,result)
                        VALUES (:ts_id,:code,:task,:sun,:mon,:tue,:wed,:thur,:fri,:sat,:percent_complete,:completion_days,:result)";
        $statement_det = $connect->prepare($query_det);
        $statement_det->execute($data_det);
    }
    fclose($file_data);
    unset($_SESSION['csv_file_name']);
}

?>