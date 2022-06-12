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
                            <h1 class="m-0">Riwayat Pemasukan </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Riwayat Pemasukan</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <?php
            $limit = 10;
            $sql = "SELECT COUNT(id) FROM pemasukan";
            $rs_result = mysqli_query($con, $sql);
            $row = mysqli_fetch_row($rs_result);
            $total_records = $row[0];
            $total_pages = ceil($total_records / $limit);
            ?>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <a href="" data-toggle="modal" data-target="#modal-tambah" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Tambah Pemasukan</a>
                        </div>
                    </div>
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pemasukan</h3>

                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 200px;">
                                            <select class="form-control" required id="sort_by" name="sort_by">
                                                <option value="">Urutkan Berdasar</option>

                                                <option value="name_asc">Nama(A-Z)</option>
                                                <option value="name_desc">Nama(Z-A)</option>
                                                <option value="created_asc">Tanggal Masuk(Terlama)</option>
                                                <option value="created_desc">Tanggal Masuk(Terbaru)</option>

                                            </select>
                                            <!-- <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Cari nama barang"> -->

                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-pemasukan">


                                        </tbody>
                                    </table>

                                </div>
                                <!-- pagination number -->
                                <div class="card-footer clearfix">

                                    <ul class="pagination pagination-sm m-0 float-right">
                                        <?php
                                        if (!empty($total_pages)) {
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i == 1) {
                                        ?>
                                                    <li class="page-item" id="<?= $i; ?>"><a data-id="<?= $i; ?>" class="page-link"><?= $i; ?></a></li>

                                                <?php
                                                } else {
                                                ?>
                                                    <li class="page-item" id="<?= $i; ?>"><a class="page-link" data-id="<?= $i; ?>"><?= $i; ?></a></li>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
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
                                <h4 class="modal-title">Tambah Pemasukan</h4>
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
                                                        <option value="<?= $row['id']?>"><?= $row['nama_barang']?></option>
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
                                    <input type="hidden" id="id_pemasukan" name="id_pemasukan" class="form-control">
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
                                var id = button.data('id_pemasukan');

                                var modal = $(this);
                                modal.find('#id_pemasukan').val(id);

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
                                    $('#data-pemasukan').html(hasil);
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
                        console.log($("#id_pemasukan").val());
                        $.ajax({
                            url: "delete.php",
                            type: "POST",
                            cache: false,
                            data: {
                                id: $("#id_pemasukan").val()
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
                        $("#data-pemasukan").load("viewData.php?page=1");
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
                                    $("#data-pemasukan").html(dataResult);
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
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>