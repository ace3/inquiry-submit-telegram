<?php
require __DIR__ . '/vendor/autoload.php';
include_once('rb-mysql.php');

R::setup(
    'mysql:host=localhost;dbname=sma',
    'root',
    'raspberry'
); //for both mysql or mariaDB



use Josantonius\Session\Session;

$title = 'Dunia Warna';

?>