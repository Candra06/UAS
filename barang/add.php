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
              <h1 class="m-0">Tambah Data Barang</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item ">Data Barang</li>
                <li class="breadcrumb-item active">Tambah</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- Main row -->
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Input Data</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Nama Barang</label>
                          <input type="text" class="form-control" required name="nama_barang" placeholder="Nama Barang">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Stok</label>
                          <input type="number" class="form-control" required name="stok" placeholder="Jumlah">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" required name="status">
                            <option value="">Pilih Status</option>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Habis">Habis</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputFile">File input</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" required name="foto" id="exampleInputFile">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>

                          </div>
                        </div>

                      </div>
                    </div>


                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
          <?php
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
          if (isset($_POST['submit'])) {
            $nama = $_POST['nama_barang'];
            $stok = $_POST['stok'];
            $status = $_POST['status'];

            $allowed_ext  = array('png', 'jpg');
            $ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
            $filename = getName() . '.' . $ext;
            $tempname = $_FILES["foto"]["tmp_name"];
            $folder = "../foto/" . $filename;

            $q = $con->query("INSERT INTO barang (nama_barang,stok,status,foto) VALUES ('$nama','$stok','$status','$filename')");
            if (!$q) {
              echo "error".mysqli_error($con);
            }
            // if ($q) {
            //   if (move_uploaded_file($tempname, $folder)) {
            //     echo " <script>
            //           alert('Berhasil menambah data !');
            //           window.location = 'http://pbw.ilkom.unej.ac.id/ifd/ifd172410103012/uas_172410103012';
            //           </script>";
            //   } else {

            //     echo " <script>
            //           alert('Gagal mengunggah foto !');
            //           </script>";
            //   }
            // } else {
            //   echo $con->error;
              // echo " <script>
              //         alert('Gagal menambah data !');
              //         </script>";
            // }
          }
          ?>
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