<?php
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$faulty_fields = array();
if(!@$_POST["new_login"]){
    $faulty_fields[] = 'new_login';
}
if(!@$_POST["password"]){
    $faulty_fields[] = 'password';
}
if(!@$_POST["first_name"]){
    $faulty_fields[] = 'first_name';
}
if(!@$_POST["last_name"]){
    $faulty_fields[] = 'last_name';
}
if(!@$_POST["role"]){
    $faulty_fields[] = 'role';
}

if(!empty($faulty_fields)){
    $extra = 'register.php'.'?missing='.join('+', $faulty_fields);
}
else if($_POST['password'] != @$_POST['passcopy']){
    $extra = 'register.php?passmatch=1';
}
else {
    extract($_POST);
    require_once("../connect/session.php");
    $hash = salted_password_hash($password);

    $role = $_POST['role']; //  It just does not work the way it was intended to, so I have to do it manually.

    $stmt = $mysqli->prepare("INSERT INTO Participant (login, hash, first_name, last_name, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $new_login, $hash, $first_name, $last_name, $role);
    $stmt->execute();

    if($mysqli->errno){
        $errno = $mysqli->errno;
        $count_stmt = $mysqli->prepare("SELECT COUNT(*) FROM Participant WHERE login=?;");
        $count_stmt->bind_param("s", $new_login);
        $count_stmt->execute();

        $extra = 'register.php'
            .'?errno='.$errno
            .'&collision='.mysqli_fetch_row($count_stmt->get_result())[0];
    }
    else{
        $extra = 'sign-in.php';
    }

    $stmt->close();
    $mysqli->close();
}
header("Location: http://$host$uri/$extra");
