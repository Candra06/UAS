<?php
// define('BASEURL', "http://" . $_SERVER['SERVER_NAME'] . '/' . basename(__DIR__) . '/');
error_reporting(E_ALL);
ini_set('display_errors', '1');
define('BASEURL', "http://pbw.ilkom.unej.ac.id/ifd/ifd172410103012/uas_172410103012");
$host = "localhost";
$user = "172410103012";
$password = "secret";
$database = "uas_172410103012";

$con = mysqli_connect($host, $user, $password, $database);

if ($con->connect_error) {
    die("Koneksi gagal");
}
?>