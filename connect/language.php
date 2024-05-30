<?php
$locale = $_COOKIE['locale'];

switch($locale) {
    case 'en':
    case 'ua':
        break;
    default:
        $locale = 'ua';
}

require_once("lang-" . $locale . ".php");
?>