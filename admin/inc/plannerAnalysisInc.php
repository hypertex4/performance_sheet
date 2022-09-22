<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../../controllers/config/database.php');
$db = new Database();$connection = $db->connect();

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = ($_POST['length']==-1)?"10000000":$_POST['length']; // Rows display per page
//$columnIndex = $_POST['order'][0]['column']; // Column index
//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
$searchByFromDate = $_POST['from_date'];
$searchByToDate = $_POST['to_date'];

$searchByProjectIdArr = !empty($_POST['project_arr'])?preg_split("/\,/", $_POST['project_arr']):'';
$searchByEmpNameArr = !empty($_POST['emp_name_arr'])?preg_split("/\,/", $_POST['emp_name_arr']):'';
$searchByTypeArr = !empty($_POST['type_arr'])?preg_split("/\,/", $_POST['type_arr']):'';

## Search
$searchQuery = " ";

if($searchByProjectIdArr != ''){
    $project_name = implode("','", $searchByProjectIdArr);
    $searchQuery .= " AND wpd.project_id IN('" .$project_name. "')";
}
if($searchByEmpNameArr != ''){
    $emp_name = implode("','", $searchByEmpNameArr);
    $searchQuery .= " AND wp.employee_id IN('" .$emp_name. "')";
}
if($searchByTypeArr != ''){
    $type = implode("','", $searchByTypeArr);
    $searchQuery .= " AND wpd.p_type IN('" .$type. "')";
}

if($searchByFromDate != '' && $searchByToDate != ''){
    $searchQuery .= " AND (wp.from_date>='".date("Y-m-d",strtotime($searchByFromDate))."' AND wp.to_date<='".date("Y-m-d",strtotime($searchByToDate))."')";
}

if ($searchValue != '') {
    $searchQuery .= " and (user_name like '%" . $searchValue . "%' or 
        user_unit like '%" . $searchValue . "%' or 
        project_task like '%" . $searchValue . "%' or 
        department_name like '%" . $searchValue . "%' or 
        p_type like '%" . $searchValue . "%' or 
        comment like '%" . $searchValue . "%' or 
        completion_days like '%" . $searchValue . "%' or 
        completion_rate like '%" . $searchValue . "%' or 
        project_id like '%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($connection, "SELECT * FROM tbl_weekly_planner_details wpd 
                                        INNER JOIN tbl_weekly_planner wp ON wpd.planner_id=wp.planner_id 
                                        INNER JOIN tbl_department d ON wp.department_id=d.department_id 
                                        INNER JOIN tbl_user e ON wp.employee_id=e.user_id");
//$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = $sel->num_rows;

## Total number of records with filtering
$sel2 = mysqli_query($connection, "SELECT * FROM tbl_weekly_planner_details wpd 
                                        INNER JOIN tbl_weekly_planner wp ON wpd.planner_id=wp.planner_id 
                                        INNER JOIN tbl_department d ON wp.department_id=d.department_id 
                                        INNER JOIN tbl_user e ON wp.employee_id=e.user_id WHERE wp.planner_id >0" . $searchQuery);
//$records = mysqli_fetch_assoc($sel);
//$totalRecordWithFilter = $records['allcount'];
$totalRecordWithFilter = $sel2->num_rows;

## Fetch records
$empQuery = "SELECT * FROM tbl_weekly_planner_details wpd 
            INNER JOIN tbl_weekly_planner wp ON wpd.planner_id=wp.planner_id 
            INNER JOIN tbl_department d ON wp.department_id=d.department_id 
            INNER JOIN tbl_user e ON wp.employee_id=e.user_id WHERE wp.planner_id >0 " . $searchQuery .
    " ORDER BY wpd.planner_detail_id DESC" . " limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "user_name" => $row['user_name'],
        "user_unit" => $row['user_unit'],
        "project_id" => $row['project_id'],
        "project_task" => $row['project_task'],
        "department_name" => $row['department_name'],
        "p_type" => $row['p_type'],
        "from_date" => date("j-M-Y",strtotime($row['from_date'])),
        "to_date" => date("j-M-Y",strtotime($row['to_date'])),
        "completion_rate" => $row['completion_rate'],
        "completion_days" => $row['completion_days'] . " day<small>(s)</small>",
        "comment" => $row['comment']
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



