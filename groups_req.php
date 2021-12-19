<?php

session_start();

require("config.php");

if (!isset($_SESSION["id_user"])){
	echo "Es obligatorio identificarse";
	exit();
}


if ($_SESSION["id_user"] != 1){
	echo "No tienes permiso para estar aqui";
	exit();
}
if (!isset($_POST["group"]) || !isset($_POST["course"]) || !isset($_POST["jamyear"]) || !isset($_POST["mark"])){
	echo "Completa del todo el formulario";
	exit();
}

$group = $_POST["group"];
$course = $_POST["course"];
$year = $_POST["jamyear"];
$mark = $_POST["mark"];

$query = <<<EOD
INSERT INTO groups (group, course, jam_year, mark) VALUES ("{$group}", "{$course}","{$year}","{$mark}");
EOD;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);

$res = $conn->query($query);
if (!$res){
	echo "No se ha podido conectar con la base de datos";
	exit();
}

Header("Location: index.php");
?>
