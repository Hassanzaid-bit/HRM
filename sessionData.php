<?php

session_start(); 
require_once 'apis/HRM.class.php';
if(!isset($_SESSION["userId"])){
    header("Location: login.html");
    return;
}
$obj = new HRM();

$userId = $_SESSION["userId"];
$userName = $_SESSION["userName"];
$role = $_SESSION["role"];
$rolename = json_decode($obj->getRoleById($role))->name;
$department =  $_SESSION["department"];
$logo = "dist/img/HRIS.png";
$siteName = "HRIS";

?>