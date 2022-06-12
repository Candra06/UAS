<!DOCTYPE html>
<html lang="en">
<?php
include 'config/app.php';
include 'layout/head.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php
    include 'layout/navbar.php';
    ?>
    <?php
    include 'layout/sidebar.php';
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Data Barang </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Barang</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <?php
      $limit = 5;
      $sql = "SELECT COUNT(id) FROM barang";
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
              <a href="barang/add.php" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Tambah Data</a>
            </div>
          </div>
          <!-- Main row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Barang</h3>

                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Cari nama barang">

                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>Foto</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="data-barang">


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
        <div class="modal fade" id="modal-update">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nama Barang</label>
                      <input type="hidden" name="id" id="id">
                      <input type="text" class="form-control" id="nama_barang" required name="nama_barang" placeholder="Nama Barang">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Stok</label>
                      <input type="number" class="form-control" id="stok" required name="stok" placeholder="Jumlah">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" required id="status" name="status">
                        <option value="">Pilih Status</option>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Habis">Habis</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInputFile">File input</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="foto" required name="foto" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>

                      </div>
                      <i>*) Kosongkan jika tidak ingin merubah foto</i>
                    </div>

                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="update-data" class="btn btn-primary">Simpan</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <script>
          $(document).ready(function() {

            $(function() {
              $('#modal-update').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var nama_barang = button.data('nama');
                var stok = button.data('stok');
                var status = button.data('status');
                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#nama_barang').val(nama_barang);
                modal.find('#stok').val(stok);
                modal.find('#status').val(status);
                // modal.find('#id_modal').val(id);
              });
            });
            $(document).on("click", "#update-data", function() {
              var data = new FormData();
              data.append("nama_barang", $('#nama_barang').val());
              data.append("id", $('#id').val());
              data.append("stok", $('#stok').val());
              data.append("status", $('#status').val());
              data.append("foto", document.getElementById('foto').files[0]);
              // console.log(foto);
              $.ajax({
                url: "barang/updateData.php",
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                data: data,
                // data: {
                //   id: $('#id').val(),
                //   nama_barang: $('#nama_barang').val(),
                //   stok: $('#stok').val(),
                //   status: $('#status').val(),
                //   foto: foto,
                // },
                success: function(dataResult) {
                  console.log(dataResult);
                  var hasil = JSON.parse(dataResult);
                  // var dataResult = JSON.stringify(dataResult, ["statusCode"]);
                  // var result = JSON.parse(dataResult);
                  // console.log(hasil.statusCode);
                  if (hasil.statusCode == 200) {
                    $('#modal-update').modal().hide();
                    alert('Berhasil mengubah data !');
                    location.reload();
                  }
                }
              });
            });
          });
        </script>
        <!-- /.row -->
        <script>
          $(document).ready(function() {
            load_data();

            function load_data(keyword) {
              $.ajax({
                method: "GET",
                url: "barang/viewData.php",
                data: {
                  keyword: keyword
                },
                success: function(hasil) {
                  $('#data-barang').html(hasil);
                }
              });
            }
            $('#search').keyup(function() {
              var keyword = $("#search").val();
              load_data(keyword);
            });

          });

          $(document).ready(function() {
            $("#data-barang").load("barang/viewData.php?page=1");
            $(".page-link").click(function() {
              var id = $(this).attr("data-id");
              var select_id = $(this).parent().attr("id");
              $.ajax({
                url: "barang/viewData.php",
                type: "GET",
                data: {
                  page: id
                },
                cache: false,
                success: function(dataResult) {
                  $("#data-barang").html(dataResult);
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
  include 'layout/footer.php';
  ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php include 'layout/script.php'; ?>
  <script>
    $(function() {
      bsCustomFileInput.init();
    });
  </script>
</body>

</html>