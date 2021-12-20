<?php
$sessionname = '';
if (isset($_SESSION['name'])) {
$sessionname = $_SESSION['name'];
}
include "includes/functions/functions.php";
include 'admin/config.php';
include 'includes/language/english.php';
include "includes/templates/header.php";


?>