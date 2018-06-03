<?php
session_start();

if(isset($_POST))
{
    $profile = $_POST;
}
$_SESSION['profile'] = $profile;

$newURL = 'index.php';
header('Location: '.$newURL);
?>