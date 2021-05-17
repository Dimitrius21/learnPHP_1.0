<?php
session_start();
unset($_SESSION['user']); 
if (isset($_SESSION['role'])) unset($_SESSION['role']);
$url=$_SERVER['HTTP_REFERER'];
    header("Location: $url");
