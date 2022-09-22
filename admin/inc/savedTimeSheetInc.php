<?php
if (!isset($_SESSION)){ session_start(); }
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../../controllers/config/database.php');
include_once ($filepath.'/../../controllers/classes/Admin.class.php');

$db = new Database();$connection = $db->connect();
$admin = new Admin($connection);
// Default limit
$limit = isset($_GET['per_page']) ? $_GET['per_page'] : 200;

// Default offset
$offset = 0;
$current_page = 1;
if(isset($_GET['page-number'])) {
    $current_page = (int)$_GET['page-number'];
    $offset = ($current_page * $limit) - $limit;
}

$whereSQL = $orderSQL = '';
if(!empty($_GET['unit'])){
    $unit = implode("','", $_GET['unit']);
    $whereSQL .= " AND t.department_id IN('" .$unit. "')";
}
if(!empty($_GET['emp_name'])){
    $emp_name = implode("','", $_GET['emp_name']);
    $whereSQL .= " AND t.employee_id IN('" .$emp_name. "')";
}
if(!empty($_GET['_from']) && !empty($_GET['_to'])){
    $whereSQL .= " AND (from_date>='".$_GET['_from']."' AND to_date<='". $_GET['_to']."')";
}
if(!empty($_GET['_from2']) && !empty($_GET['_to2'])){
    $whereSQL .= " AND (from_date>='".$_GET['_from2']."' AND to_date<='". $_GET['_to2']."')";
}

$time_query = "";

if (isset($_SESSION['adm_login']) && $_SESSION['adm_login']['adm_uhead']==100) {
    $query = $connection->query("SELECT * FROM tbl_timesheets t INNER JOIN tbl_department d ON t.department_id=d.department_id 
                                        INNER JOIN tbl_user u ON t.employee_id=u.user_id WHERE t.u_h_status !='approved22' $whereSQL 
                                        ORDER BY t.timesheet_id DESC");
} else if(isset($_SESSION['adm_login']) && $_SESSION['adm_login']['adm_uhead']>0 && $_SESSION['adm_login']['adm_uhead']<=7){
    $t_uid = $_SESSION['adm_login']['adm_uhead'];
    $query = $connection->query("SELECT * FROM tbl_timesheets t INNER JOIN tbl_department d ON t.department_id=d.department_id 
                                        INNER JOIN tbl_user u ON t.employee_id=u.user_id WHERE t.department_id=$t_uid $whereSQL 
                                        ORDER BY t.timesheet_id DESC");
}

if($query->num_rows > 0){
    $timesheet_arr = array();
    while ($row = $query->fetch_assoc()){
        $timesheet_arr[] = array(
            "timesheet_id"=>$row['timesheet_id'],"user_name"=>$row['user_name'],"user_unit"=>$row['user_unit'],"u_h_status"=>$row['u_h_status'],
            "department_name"=>$row['department_name'],"from_date"=>date("j - M - Y",strtotime($row['from_date'])),
            "to_date"=> date("j - M - Y",strtotime($row['to_date'])),
        );
    }
    $timesheets = $timesheet_arr;
    $paged_timesheets = array_slice($timesheets, $offset, $limit);
    $total_timesheets = count($timesheets);

// Get the total pages rounded up the nearest whole number
    $total_pages = ceil( $total_timesheets / $limit );
    $paged = $total_timesheets > count($paged_timesheets) ? true : false;

    if (count($paged_timesheets)) {
            foreach ($paged_timesheets as $timesheet) { ?>
                <tr>
                    <th scope="row"><?= $timesheet['department_name'];?></th>
                    <td><?= $timesheet['user_name'];?></td>
                    <td><?= $timesheet['user_unit'];?></td>
                    <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['from_date']));?></td>
                    <td class="text-uppercase"><?= date("j - M - Y",strtotime($timesheet['to_date']));?></td>
                    <td><?= $admin->estimated_days_worked($timesheet['timesheet_id'])?></td>
                    <?php if ($timesheet['u_h_status']=='pending'){ ?>
                        <td><span class="badge badge-danger">pending</span></td>
                    <?php } elseif ($timesheet['u_h_status']=='approved'){ ?>
                        <td><span class="badge badge-success">approved</span></td>
                    <?php } elseif ($timesheet['u_h_status']=='declined'){ ?>
                        <td><span class="badge badge-dark">declined</span></td>
                    <?php } ?>
                    <td class="bg_primary text-center bg_primary_hover">
                        <a href="aedit-timesheet/<?=$timesheet['timesheet_id'];?>" class="default_link text-white">EDIT FILE</a>
                    </td>
                </tr>
            <?php } if ($paged) {require($filepath.'/../pagination.php');}
    }  else {
        echo '<tr><td colspan="7">No record found.</td></tr>';
    }
} else {
    echo '<tr><td colspan="7">No record found.</td></tr>';
}


