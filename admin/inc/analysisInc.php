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

$searchByProjectCatArr = !empty($_POST['project_category_arr'])?preg_split("/\,/", $_POST['project_category_arr']):'';
$searchByProjectIdArr = !empty($_POST['project_arr'])?preg_split("/\,/", $_POST['project_arr']):'';
$searchByEmpNameArr = !empty($_POST['emp_name_arr'])?preg_split("/\,/", $_POST['emp_name_arr']):'';

## Search
$searchQuery = " ";

if($searchByProjectCatArr != ''){
    $project_category = implode("','", $searchByProjectCatArr);
    $searchQuery .= " AND pc.project_category IN('" .$project_category. "')";
}
if($searchByProjectIdArr != ''){
    $project_name = implode("','", $searchByProjectIdArr);
    $searchQuery .= " AND td.project_id IN('" .$project_name. "')";
}
if($searchByEmpNameArr != ''){
    $emp_name = implode("','", $searchByEmpNameArr);
    $searchQuery .= " AND t.employee_id IN('" .$emp_name. "')";
}

if($searchByFromDate != '' && $searchByToDate != ''){
    $searchQuery .= " AND (from_date>='".date("Y-m-d",strtotime($searchByFromDate))."' AND to_date<='".date("Y-m-d",strtotime($searchByToDate))."')";
}

if ($searchValue != '') {
    $searchQuery .= " and (e.user_name like '%" . $searchValue . "%' or 
        e.user_unit like '%" . $searchValue . "%' or 
        td.project_task like '%" . $searchValue . "%' or 
        d.department_name like '%" . $searchValue . "%' or 
        td.result like '%" . $searchValue . "%' or 
        td.app_rating like '%" . $searchValue . "%' or 
        pc.project_category like '%" . $searchValue . "%' or 
        td.project_id like '%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($connection, "SELECT *, (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total FROM tbl_timesheets t 
                                    INNER JOIN tbl_department d ON t.department_id=d.department_id 
                                    INNER JOIN tbl_user e ON t.employee_id=e.user_id 
                                    LEFT JOIN tbl_timesheet_details td ON t.timesheet_id=td.timesheet_id
                                    INNER JOIN tbl_projects pc ON pc.project_code=td.project_id ");
//$records = mysqli_fetch_assoc($sel);
//$totalRecords = $records['allcount'];
$totalRecords = $sel->num_rows;

## Total number of records with filtering
$sel2 = mysqli_query($connection, "SELECT *, (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total FROM tbl_timesheets t 
                                    INNER JOIN tbl_department d ON t.department_id=d.department_id 
                                    INNER JOIN tbl_user e ON t.employee_id=e.user_id 
                                    LEFT JOIN tbl_timesheet_details td ON t.timesheet_id=td.timesheet_id 
                                    INNER JOIN tbl_projects pc ON pc.project_code=td.project_id 
                                    WHERE t.timesheet_id >0  $searchQuery");
//$records = mysqli_fetch_assoc($sel);
//$totalRecordWithFilter = $records['allcount'];
$totalRecordWithFilter = $sel2->num_rows;

## Fetch records
$empQuery = "SELECT *, (pro_sun+pro_mon+pro_tue+pro_wed+pro_thur+pro_fri+pro_sat) as total FROM tbl_timesheets t 
            INNER JOIN tbl_department d ON t.department_id=d.department_id 
            INNER JOIN tbl_user e ON t.employee_id=e.user_id 
            LEFT JOIN tbl_timesheet_details td ON t.timesheet_id=td.timesheet_id 
            INNER JOIN tbl_projects pc ON pc.project_code=td.project_id 
            WHERE t.timesheet_id >0 $searchQuery order by td.timesheet_id DESC" . " limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "user_name" => $row['user_name'],
        "user_unit" => $row['user_unit'],
        "project_category" => $row['project_category'],
        "project_id" => $row['project_id'],
        "project_task" => $row['project_task'],
        "department_name" => $row['department_name'],
        "from_date" => date("j-M-Y",strtotime($row['from_date'])),
        "to_date" => date("j-M-Y",strtotime($row['to_date'])),
        "result" => $row['result'],
        "app_rating" => $row['app_rating']>=60?'<span class="text-success font-weight-extra-bold">'.$row['app_rating'].'%</span>':'<span class="text-danger font-weight-extra-bold">'.$row['app_rating'].'%</span>',
        "total" => '<span class="font-weight-bold">'.number_format($row['total'],1).'</span>'
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



