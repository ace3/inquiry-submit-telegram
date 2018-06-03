<?php
require __DIR__ . '/vendor/autoload.php';


$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$hostname = getenv('DATABASE_HOSTNAME');
$username = getenv('DATABASE_USERNAME');
$password = getenv('DATABASE_PASSWORD');
$database = getenv('DATABASE_DBNAME_FETCH');


include_once('rb-mysql.php');

R::setup(
    "mysql:host=$hostname;dbname=$database"
    ,
    $username,
    $password
); //for both mysql or mariaDB



// R::setup(
//     'mysql:host=localhost;dbname=sma',
//     'root',
//     'raspberry'
// ); //for both mysql or mariaDB

