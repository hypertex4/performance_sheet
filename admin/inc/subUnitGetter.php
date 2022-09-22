<?php
include_once('../../controllers/config/database.php');
include_once('../../controllers/classes/Admin.class.php');
$db = new Database();
$connection = $db->connect();
$adm = new Admin($connection);

$out = "";
if ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_GET['emp_id'])) {
    $unit = $adm->get_reg_emp_designation($_GET['emp_id']);
    if ($unit->num_rows > 0) {
        while ($emp_unit = $unit->fetch_assoc()) {
            $out.="<option value='".$emp_unit['user_id']."'>" .$emp_unit['user_unit']."</option>";
        }
    }
}
echo $out;
?>