<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
$em_id = $_SESSION['emp_login']['emp_id'];
include_once 'config.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
$searchByFromDate = $_POST['from_date'];
$searchByToDate = $_POST['to_date'];

## Search
$searchQuery = " ";

if($searchByFromDate != '' && $searchByToDate != ''){
    $searchQuery .= " and (from_date>='".$searchByFromDate."' AND to_date<='".$searchByToDate."')";
}

if ($searchValue != '') {
    $searchQuery .= " and (user_name like '%" . $searchValue . "%' or 
        user_unit like '%" . $searchValue . "%' or 
        project_task like '%" . $searchValue . "%' or 
        department_name like '%" . $searchValue . "%' or 
        result like '%" . $searchValue . "%' or 
        comment like '%" . $searchValue . "%' or 
        project_id like'%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($connection, "SELECT *, (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total FROM tbl_timesheets t 
                                    INNER JOIN tbl_department d ON t.department_id=d.department_id 
                                    INNER JOIN tbl_user e ON t.employee_id=e.user_id LEFT JOIN tbl_timesheet_details td 
                                    ON t.timesheet_id=td.timesheet_id WHERE e.approval_by=$em_id");
//$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = $sel->num_rows;

## Total number of records with filtering
$sel2 = mysqli_query($connection, "SELECT *, (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total FROM tbl_timesheets t 
                                    INNER JOIN tbl_department d ON t.department_id=d.department_id 
                                    INNER JOIN tbl_user e ON t.employee_id=e.user_id LEFT JOIN tbl_timesheet_details td 
                                    ON t.timesheet_id=td.timesheet_id WHERE e.approval_by=$em_id " . $searchQuery);
//$records = mysqli_fetch_assoc($sel);
//$totalRecordWithFilter = $records['allcount'];
$totalRecordWithFilter = $sel2->num_rows;

## Fetch records
$empQuery = "SELECT *, (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total FROM tbl_timesheets t 
            INNER JOIN tbl_department d ON t.department_id=d.department_id 
            INNER JOIN tbl_user e ON t.employee_id=e.user_id LEFT JOIN tbl_timesheet_details td 
            ON t.timesheet_id=td.timesheet_id WHERE e.approval_by=$em_id " . $searchQuery .
    " order by t.timesheet_id DESC limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "user_name" => $row['user_name'],
        "user_unit" => $row['user_unit'],
        "project_id" => $row['project_id'],
        "project_task" => $row['project_task'],
        "department_name" => $row['department_name'],
        "from_date" => date("j-M-Y",strtotime($row['from_date'])),
        "to_date" => date("j-M-Y",strtotime($row['to_date'])),
        "result" => $row['result'],
        "comment" => $row['comment'],
        "total" => number_format($row['total'],1)."Hrs"
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordWithFilter,
    "aaData" => $data
);

echo json_encode($response);



