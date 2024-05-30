<?php
require_once("../connect/session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$user_id = 0 + @$_POST["user_id"];

$target_dir = "../uploads/";
// Path of the file to be uploaded
$target_file = $target_dir . "image".$user_id;
$success = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

$stmt = $mysqli -> prepare("UPDATE Participant SET image_data = 1 WHERE id = ?;");
$stmt -> bind_param("i", $user_id);
$stmt->execute();
$stmt->close();
$mysqli->close();



header("Location: http://$host$uri/user.php?img=$success");