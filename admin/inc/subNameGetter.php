<?php
include_once('../../controllers/config/database.php');
include_once('../../controllers/classes/Admin.class.php');
$db = new Database();
$connection = $db->connect();
$adm = new Admin($connection);

$out = "<option value=''>Select Employee Name</option>";
if ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_GET['dept_id'])) {
    $name = $adm->get_reg_emp_name($_GET['dept_id']);
    if ($name->num_rows > 0) {
        while ($emp_name = $name->fetch_assoc()) {
            $out.="<option value='".$emp_name['user_id']."'>" .$emp_name['user_name']."</option>";
        }
    }
}
echo $out;
?>