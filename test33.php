<?php


$dbhost = 'localhost';
 $dbuser = 'root';
 $dbpass = '';
 $dbName = 'performance_sheet';
 
 $mysqli = new mysqli($dbhost, $dbuser, $dbpass,$dbName);
 
 if($mysqli->connect_errno ) {
	printf("Connect failed: %s<br />", $mysqli->connect_error);
	exit();
 }

$sql = "SELECT * FROM tbl_user INTO OUTFILE 'C:/laragon/www/new_csv.csv' FIELDS TERMINATED BY ','";
$result = $mysqli->query($sql);
           
 if ($result->num_rows > 0) {
	echo "Done and Ready";
} else {
	echo "Not Done";
}


?>