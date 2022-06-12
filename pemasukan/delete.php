<?php
include '../config/app.php';

$id = $_POST['id'];
$data = mysqli_query($con, "SELECT * FROM pemasukan WHERE id = $id");

$result =  mysqli_fetch_array($data);
//mencari data barang berdasarkan id dari data pemasukan
$barang = mysqli_query($con, "SELECT * FROM barang WHERE id = " . $result['barang_id']);

$resultBarang =  mysqli_fetch_array($barang);

$stBaru = $resultBarang['stok'] - $result['jumlah'];

//proses update menjadi stok baru
$update = mysqli_query($con, "UPDATE barang SET stok=$stBaru WHERE id = " . $result['barang_id']);
if ($update) {
    $delete = mysqli_query($con, "DELETE FROM pemasukan WHERE id=$id");
    if ($delete) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201));
    }
}
mysqli_close($con);
