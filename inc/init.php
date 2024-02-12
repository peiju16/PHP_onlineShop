<?php

$pdo = new PDO('mysql:host=localhost;dbname=onlineshop', 'root', '',
    array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ));

    session_start();

    require_once("function.php");

    define("URL", "http://" . $_SERVER["HTTP_HOST"] . "/onlineshop_static_version_CORRECTION/");
    define("SITE_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/onlineshop_static_version_CORRECTION/");

    $content = "";

?>