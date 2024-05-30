<?php
require_once("../connect/database.php");
require_once("../connect/language.php");

unset($login);
unset($login_id);
unset($role);
unset($is_contractor);
unset($is_customer);
$pretended_login = @$_COOKIE['login'];
$pretended_shash = @$_COOKIE['session_hash'];

$literal_abracadabra = "at434wry3e5";

function salted_password_hash($password)
{
    $random_val = rand(4096, 65535);
    $salt = dechex($random_val);
    $hash = hash(
        "sha256",
        $salt.$password
    );

    return $salt."$".$hash;
}

if($pretended_login && $pretended_shash){
    $stmt = $mysqli->prepare("SELECT id AS user_id, session_secret, first_name, last_name, `role` FROM Participant "
        ."WHERE login=? AND NOT ISNULL(session_secret)");
    $stmt->bind_param("s", $pretended_login);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()){
        extract($row, EXTR_OVERWRITE);
        $session_hash = hash(
            "sha256",
            $session_secret.$literal_abracadabra.$pretended_login
        );
        if($session_hash === $pretended_shash){
            $login = $pretended_login;
            $login_id = $user_id;
            $is_contractor = ($role == 'contractor');
            $is_customer = ($role == 'client');
        }
    }
}

define("PROJECT_QUERY",
    "SELECT Project.*, ProjectType.title AS `type`,
        CONCAT(Client.first_name, ' ', Client.last_name) AS `client`,
        CONCAT(Contractor.first_name, ' ', Contractor.last_name) AS `contractor`
     FROM Project
        INNER JOIN ProjectType ON ProjectType.id = projecttype_id
        INNER JOIN Participant AS Client ON Client.id = client_id
        LEFT JOIN Participant AS Contractor ON Contractor.id = contractor_id");

define("COMMENT_QUERY",
    "SELECT Commentary.*,
        CONCAT(Author.first_name, ' ', Author.last_name) AS `author`
     FROM Commentary
        INNER JOIN Participant AS Author ON participant_id=Author.id");

function retrieve_project($id) {
    global $mysqli;
    $stmt = $mysqli->prepare(PROJECT_QUERY . " WHERE Project.id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function retrieve_comments($id) {
    global $mysqli;
    $stmt = $mysqli->prepare(COMMENT_QUERY . " WHERE project_id=? ORDER BY id ASC");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result();
}

?>