<?php

function check_auth_or_redirect($extra_condition) {
    global $login_id;
    if(!$login_id || !$extra_condition) {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = "index.php?short=1"; // need authorization
        header("Location: http://$host$uri/$extra");
        exit();
    }
}

function multiline($lines) {
    return str_replace("\n", "<br/>", $lines);
}

$missing = @$_GET['missing'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);

function field_label_style($field) { // move to vignettes.php
    global $mfieldkeys;
    return array_key_exists($field, $mfieldkeys) ? "block-label-red" : "block-label-white";
}

?>
