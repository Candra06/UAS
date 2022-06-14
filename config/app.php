<?php
// define('BASEURL', "http://" . $_SERVER['SERVER_NAME'] . '/' . basename(__DIR__) . '/');
define('BASEURL', "http://pbw.ilkom.unej.ac.id/ifd/ifd172410103012/uas_172410103012");
$host = "proxy.ilkom.unej.ac.id";
$user = "172410103012";
$password = "secret";
$database = "uas_172410103012";

$con = mysqli_connect($host, $user, $password, $database);

if ($con->connect_error) {
    die("Koneksi gagal");
}
?>