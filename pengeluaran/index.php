<!DOCTYPE html>
<html lang="en">
<?php
include '../config/app.php';
include '../layout/head.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php
        include '../layout/navbar.php';
        ?>
        <?php
        include '../layout/sidebar.php';
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Riwayat Pengeluaran </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Riwayat Pengeluaran</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <?php
            $limit = 10;
            $sql = "SELECT COUNT(id) FROM pengeluaran";
            $rs_result = mysqli_query($con, $sql);
            $row = mysqli_fetch_row($rs_result);
            $total_records = $row[0];
            $total_pages = ceil($total_records / $limit);
            ?>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <a href="" data-toggle="modal" data-target="#modal-tambah" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
                        </div>
                    </div>
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pengeluaran</h3>

                                    <div class="card-tools">
                                        <form class="form-inline" action="" method="get">
                                            <div class="input-group input-group-sm mr-2" style="width: 150px;">

                                                <input type="text" id="search" name="search" class="form-control float-right" placeholder="Cari nama barang">

                                            </div>
                                            <div class="input-group input-group-sm mr-2" style="width: 200px;">
                                                <select class="form-control" id="sort_by" name="sort_by">
                                                    <option value="">Urutkan Berdasar</option>

                                                    <option value="name_asc">Nama(A-Z)</option>
                                                    <option value="name_desc">Nama(Z-A)</option>
                                                    <option value="created_asc">Tanggal Keluar(Terlama)</option>
                                                    <option value="created_desc">Tanggal Keluar(Terbaru)</option>

                                                </select>
                                                <!-- <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Cari nama barang"> -->

                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary ">Filter</button>
                                        </form>

                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Keluar</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <!-- <tbody id="data-pengeluaran"> -->
                                        <tbody>
                                            <?php
                                            $query = "SELECT pengeluaran.*, barang.nama_barang FROM pengeluaran JOIN barang ON pengeluaran.barang_id=barang.id";
                                            if (isset($_GET['search']) && $_GET['search'] != '') {
                                                $query = $query . " WHERE barang.nama_barang LIKE '" . "%" . $_GET['search'] . "%" . "'";
                                            }else {
                                                $query = $query;
                                            }
                                            if (isset($_GET['sort_by'])) {
                                                if ($_GET['sort_by'] == ''){
                                                    $query = $query;
                                                } else if ($_GET['sort_by'] == 'name_asc') {
                                                    $query = $query . " ORDER BY barang.nama_barang ASC";
                                                } elseif ($_GET['sort_by'] == 'name_desc') {
                                                    $query = $query . " ORDER BY barang.nama_barang DESC";
                                                } elseif ($_GET['sort_by'] == 'created_asc') {
                                                    $query = $query . " ORDER BY pengeluaran.created_at ASC";
                                                } else {
                                                    $query = $query . " ORDER BY pengeluaran.created_at DESC";
                                                }
                                            }

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
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="5" class="text-center"> <span>Data tidak ditemukan</span> </td>
                                                </tr>
                                            <?php
                                            }

                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                                
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <!-- modal update -->
                <div class="modal fade" id="modal-tambah">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Pengeluaran</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nama Barang</label>
                                            <select class="form-control" required id="barang" name="barang">
                                                <option value="">Pilih Barang</option>
                                                <?php
                                                $barang = mysqli_query($con, "SELECT * FROM barang");
                                                if ($barang->num_rows > 0) {
                                                    while ($row = $barang->fetch_assoc()) {
                                                ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['nama_barang'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" class="form-control" id="jumlah" required name="jumlah" placeholder="Jumlah">
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="input-data" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <!-- modal konfirmsi hapus -->
                <div id="modal-delete" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form>
                                <div class="modal-header">
                                    <h4 class="modal-title">Hapus Data</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="id_pengeluaran" name="id_pengeluaran" class="form-control">
                                    <p>Apakah anda yakin ingin menghapus data?</p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="button" class="btn btn-danger" id="delete">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        //mendapatkan id untuk dikirim ke modal
                        $(function() {
                            $('#modal-delete').on('show.bs.modal', function(event) {
                                var button = $(event.relatedTarget);
                                var id = button.data('id_pengeluaran');

                                var modal = $(this);
                                modal.find('#id_pengeluaran').val(id);

                            });
                        });
                        // ajax untuk menambah data
                        $(document).on("click", "#input-data", function() {
                            var data = new FormData();
                            data.append("barang", $('#barang').val());
                            data.append("jumlah", $('#jumlah').val());
                            $.ajax({
                                url: "addData.php",
                                type: "POST",
                                enctype: 'multipart/form-data',
                                processData: false,
                                contentType: false,
                                data: data,
                                success: function(dataResult) {
                                    console.log(dataResult);
                                    var hasil = JSON.parse(dataResult);

                                    if (hasil.statusCode == 200) {
                                        $('#modal-tambah').modal().hide();
                                        alert('Berhasil menambah data !');
                                        location.reload();
                                    }
                                }
                            });
                        });
                    });
                </script>
                <!-- /.row -->
                <script>
                    // menampilkan data dan sorting dengan ajax
                    $(document).ready(function() {
                        load_data();

                        function load_data(keyword) {

                            $.ajax({
                                method: "GET",
                                url: "viewData.php",
                                data: {
                                    sort_by: keyword
                                },
                                success: function(hasil) {
                                    $('#data-pengeluaran').html(hasil);
                                }
                            });
                        }
                        $('#sort_by').change(function() {
                            var keyword = $("#sort_by").val();
                            load_data(keyword);
                        });

                    });
                    // delete dengan ajax
                    $(document).on("click", "#delete", function() {
                        console.log($("#id_pengeluaran").val());
                        $.ajax({
                            url: "delete.php",
                            type: "POST",
                            cache: false,
                            data: {
                                id: $("#id_pengeluaran").val()
                            },
                            success: function(dataResult) {
                                console.log(dataResult);
                                var hasil = JSON.parse(dataResult);

                                if (hasil.statusCode == 200) {
                                    $('#modal-delete').modal().hide();
                                    alert('Berhasil menghapus data !');
                                    location.reload();
                                }

                            }
                        });
                    });
                    //pagination dengan ajax
                    $(document).ready(function() {
                        $("#data-pengeluaran").load("viewData.php?page=1");
                        $(".page-link").click(function() {
                            var id = $(this).attr("data-id");
                            var select_id = $(this).parent().attr("id");
                            $.ajax({
                                url: "viewData.php",
                                type: "GET",
                                data: {
                                    page: id
                                },
                                cache: false,
                                success: function(dataResult) {
                                    $("#data-pengeluaran").html(dataResult);
                                }
                            });
                        });
                    });
                </script>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <?php
    include '../layout/footer.php';
    ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include '../layout/script.php'; ?>

</body>

</html>