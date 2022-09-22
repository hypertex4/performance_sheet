<?php
include_once(getcwd().'/../controllers/config/database.php');
include_once(getcwd().'/../controllers/classes/User.class.php');
$db = new Database();
$connection = $db->connect();
$user = new User($connection);

$out = "<option value=''>Select code</option>";
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $code = $user->list_all_projects();
    if ($code->num_rows > 0) {
        while ($p_code = $code->fetch_assoc()) {
            $out.="<option value='".$p_code['project_code']."'>" .$p_code['project_name']."</option>";
        }
    }
}
echo $out;
?>