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

// live search ajax API
$query = "";
if (isset($_GET['keyword'])) {
    $search = '%' . $_GET['keyword'] . '%';
    $query = "SELECT * FROM barang WHERE nama_barang LIKE '$search' ORDER BY id ASC LIMIT $start_from, $limit";
} else {
    $query = "SELECT * FROM barang ORDER BY id ASC LIMIT $start_from, $limit";
}

// eksekusi query
$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <tr>
            <td>
                <img src="<?= BASEURL . '/foto/' . $row['foto'] ?>" alt="<?= $row['nama_barang'] ?>" width="100" height="80">

            </td>
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td><span class="badge <?= $row['status'] == 'Tersedia' ? 'badge-success' : 'badge-warning' ?>"><?= $row['status'] ?></span></td>
            <td>
            <a class="btn btn-sm btn-info" href="" data-toggle="modal" data-target="#modal-update" data-id="<?= $row['id'] ?>" data-nama="<?= $row['nama_barang'] ?>" data-stok="<?= $row['stok'] ?>" data-status="<?= $row['status'] ?>"> <i class="fa fa-edit"></i> Edit</a>
                <!-- <div class="btn-group">
                    <button type="button" class="btn btn-info">Aksi</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        
                        <a class="dropdown-item" href="#">Tambah Pemasukan</a>
                        <a class="dropdown-item" href="#">Tambah Pengeluaran</a>
                    </div>
                </div> -->

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
