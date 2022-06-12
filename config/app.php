<?php
// define('BASEURL', "http://" . $_SERVER['SERVER_NAME'] . '/' . basename(__DIR__) . '/');
define('BASEURL', "http://" . $_SERVER['SERVER_NAME'] . '/UAS');
$host = "localhost";
$user = "root";
$password = "bismillah5758-";
$database = "uas";

$con = mysqli_connect($host, $user, $password, $database);

if ($con->connect_error) {
    die("Koneksi gagal");
}
?>