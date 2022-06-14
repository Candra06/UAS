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
    $query = "SELECT * FROM barang WHERE nama_barang LIKE '$search' ORDER BY id DESC LIMIT $start_from, $limit";
} else {
    $query = "SELECT * FROM barang ORDER BY id DESC LIMIT $start_from, $limit";
}

// eksekusi query
$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <tr>
            <td>
                <!-- <a href=""  data-image="<?= BASEURL . '/foto/' . $row['foto'] ?>" data-toggle="modal"> -->
                    <img src="<?= BASEURL . '/foto/' . $row['foto'] ?>" alt="<?= $row['nama_barang'] ?>" class="getSrc" width="100" height="80">
                <!-- </a> -->

            </td>
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td><span class="badge <?= $row['status'] == 'Tersedia' ? 'badge-success' : 'badge-warning' ?>"><?= $row['status'] ?></span></td>
            <td>
                <a class="btn btn-sm btn-info" href="" data-toggle="modal" data-target="#modal-update" data-id="<?= $row['id'] ?>" data-nama="<?= $row['nama_barang'] ?>" data-stok="<?= $row['stok'] ?>" data-status="<?= $row['status'] ?>"> <i class="fa fa-edit"></i> Edit</a>
                <!-- <a class="btn btn-sm btn-warning" href="" data-toggle="modal" data-target="#modal-detail" data-foto="<?= BASEURL . '/foto/' . $row['foto'] ?>" data-nama="<?= $row['nama_barang'] ?>" data-stok="<?= $row['stok'] ?>" data-status="<?= $row['status'] ?>"> <i class="fa fa-eye"></i> Detail</a> -->
                
                <!-- /.modal -->
            </td>
        </tr>
    <?php
    }
} else {
    ?>
    <tr>
        <td colspan="5" class="text-center">Data tidak ditemukan</td>
    </tr>
<?php
}

?>