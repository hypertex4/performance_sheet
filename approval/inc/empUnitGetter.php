<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath."/../../controllers/config/database.php");
include_once($filepath."/../../controllers/classes/User.class.php");
$db = new Database();
$connection = $db->connect();
$user = new User($connection);

$out = "";
if ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_GET['dep_id'])) {
    $unit = $user->get_emp_units($_GET['dep_id']);
    if ($unit->num_rows > 0) {
        while ($emp_unit = $unit->fetch_assoc()) {
            $out.="<option value='".$emp_unit['employee_designation']."'>" .$emp_unit['employee_designation']."</option>";
        }
    }
}
echo $out;
?>