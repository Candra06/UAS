<?php
include '../config/app.php';

$id = $_POST['id'];
$namaBarang = $_POST['nama_barang'];
$stok = $_POST['stok'];
$status = $_POST['status'];
$foto = $_FILES['foto']['name'];
$query = '';
function getName()
{
  $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomString = '';

  for ($i = 0; $i < 5; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $randomString .= $characters[$index];
  }

  return $randomString;
}
if ($foto) {

  $ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
  $filename = getName() . '.' . $ext;
  $tempname = $_FILES["foto"]["tmp_name"];
  $folder = "../foto/" . $filename;

  $query = "UPDATE barang SET nama_barang='$namaBarang', stok='$stok', status='$status', foto='$filename' WHERE id=$id";
  move_uploaded_file($tempname, $folder);
} else {
  $query = "UPDATE barang SET nama_barang='$namaBarang', stok='$stok', status='$status' WHERE id=$id";
}



if (mysqli_query($con, $query)) {
  echo json_encode(array("statusCode" => 200));
} else {
  echo json_encode(array("statusCode" => 201));
}
mysqli_close($con);
