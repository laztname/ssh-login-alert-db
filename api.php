<?php
include_once("config_db.php");

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DATABASE);

if($conn->connect_error)
{
	die("Connection failed: " .$conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	$cip = $_POST['client_ip'];
	$usr = $_POST['user'];
	$htm = $_POST['hostname'];
	$sip = $_POST['server_ip'];

	if((!empty($cip)) && (!empty($usr)) && (!empty($htm)) && (!empty($sip)))
	{
		$stmt = $conn->prepare("INSERT INTO users (username, user_ip, remote_ip, remote_hostname) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $usr, $cip, $sip, $htm);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	} else
	{
		die();
	}
} else
{
	die();
}
?>
