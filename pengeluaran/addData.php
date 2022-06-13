<?php
include '../config/app.php';

$barang = $_POST['barang'];
$jumlah = $_POST['jumlah'];
$created = date("Y-m-d h:i:s");
$data = mysqli_query($con, "SELECT * FROM barang WHERE id = $barang");

$result =  mysqli_fetch_array($data);
$stBaru = $result['stok'] - $jumlah;

$pemasukan = mysqli_query($con, "INSERT INTO pengeluaran (barang_id,jumlah,created_at,updated_at) VALUES ($barang,$jumlah,'$created','$created')");
if ($pemasukan) {
    $updateStok = mysqli_query($con, "UPDATE barang SET stok=$stBaru WHERE id=$barang");
    if ($updateStok) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 300));
    }
    
}else{
    echo json_encode(array("statusCode" => 300));
}
?>
