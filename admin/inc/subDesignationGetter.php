<?php
include_once('../../controllers/config/database.php');
include_once('../../controllers/classes/Admin.class.php');
$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);

$out = "";
if ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_GET['dept_id'])) {
    $unit = $admin->get_emp_unit($_GET['dept_id']);
    if ($unit->num_rows > 0) {
        while ($emp_unit = $unit->fetch_assoc()) {
            $out.="<option value='".$emp_unit['employee_designation']."'>" .$emp_unit['employee_designation']."</option>";
        }
    }
}
echo $out;
?>