<?php
include '../config/app.php';
//Pagination
$limit = 5;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

$query = '';
//sorting
if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == 'name_asc') {
        $query = "SELECT pengeluaran.*, barang.nama_barang FROM pengeluaran JOIN barang ON pengeluaran.barang_id=barang.id ORDER BY barang.nama_barang ASC LIMIT $start_from, $limit";
    }elseif ($_GET['sort_by'] == 'name_desc') {
        $query = "SELECT pengeluaran.*, barang.nama_barang FROM pengeluaran JOIN barang ON pengeluaran.barang_id=barang.id ORDER BY barang.nama_barang DESC LIMIT $start_from, $limit";
    }elseif ($_GET['sort_by'] == 'created_asc') {
        $query = "SELECT pengeluaran.*, barang.nama_barang FROM pengeluaran JOIN barang ON pengeluaran.barang_id=barang.id ORDER BY pengeluaran.created_at ASC";
    }else{
        $query = "SELECT pengeluaran.*, barang.nama_barang FROM pengeluaran JOIN barang ON pengeluaran.barang_id=barang.id ORDER BY pengeluaran.created_at DESC LIMIT $start_from, $limit";
    }
}else{
    $query = "SELECT pengeluaran.*, barang.nama_barang FROM pengeluaran JOIN barang ON pengeluaran.barang_id=barang.id ORDER BY pengeluaran.id DESC LIMIT $start_from, $limit";
}
echo $query;
$result = mysqli_query($con, $query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
 <tr>
           
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                
            <a data-toggle="modal" data-target="#modal-delete" data-id_pengeluaran="<?= $row['id'] ?>" class="btn btn-sm btn-danger "><i class="fa fa-trash"></i> Hapus</a>

                <!-- /.modal -->
            </td>
        </tr>
    <?php
    }
} else {
    ?>
    <tr>
        <td colspan="5" class="float-center">Data tidak ditemukan</td>
    </tr>
<?php
}

?>
