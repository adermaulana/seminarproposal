<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");

}

function upload_file($file) {
    $target_dir = "../admin/uploads/proposal/";
    $file_name = time() . '_' . basename($file["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Buat direktori jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Validasi ukuran file (5MB)
    if ($file["size"] > 5000000) {
        return false;
    }
    
    // Validasi tipe file
    if($file_type != "pdf" && $file_type != "doc" && $file_type != "docx") {
        return false;
    }
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $file_name;
    }
    
    return false;
}

// Proses update data
if(isset($_POST['bupdate'])) {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $judul = $_POST['judul'];
    $old_file = $_POST['old_file'];
    $tanggal_pengajuan = date('Y-m-d H:i:s');
    $status = "Menunggu Persetujuan";
    
    // Cek apakah ada file baru yang diupload
    if(!empty($_FILES['file_proposal']['name'])) {
        // Upload file baru
        $file_name = upload_file($_FILES['file_proposal']);
        
        if($file_name) {
            // Hapus file lama
            $old_file_path = "../admin/uploads/proposal/" . $old_file;
            if(file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        } else {
            echo "<script>
                    alert('Upload file gagal! Pastikan ukuran file maksimal 5MB dan format sesuai ketentuan.');
                    document.location='edit_proposal.php?id=$id';
                 </script>";
            exit;
        }
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $file_name = $old_file;
    }
    
    // Update database
    $update = mysqli_query($koneksi, "UPDATE proposal SET 
                                     judul = '$judul',
                                     file_proposal = '$file_name',
                                     tanggal_pengajuan = '$tanggal_pengajuan',
                                     status = '$status'
                                     WHERE id = '$id'");
    
    if($update) {
        echo "<script>
                alert('Update data sukses!');
                document.location='proposal.php';
             </script>";
    } else {
        echo "<script>
                alert('Update data GAGAL!!');
                document.location='edit_proposal.php?id=$id';
             </script>";
    }
}

$nim = $_SESSION['nim'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../assets/images/favicon.ico" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav me-lg-2">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link" href="#" data-bs-toggle="dropdown" id="profileDropdown">
              <img src="../assets/images/faces/face5.jpg" alt="profile"/>
              <span class="nav-profile-name"><?= $_SESSION['nama_mahasiswa'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="logout.php">
                <i class="typcn typcn-eject text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">      
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="proposal.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Proposal</span>
            </a>
          </li>                                     
          <li class="nav-item">
            <a class="nav-link" href="jadwal.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Jadwal Seminar</span>
            </a>
          </li>                                                                      
          <li class="nav-item">
            <a class="nav-link" href="laporan.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Laporan</span>
            </a>
          </li>                                    
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="typcn typcn-mortar-board menu-icon"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
        <div class="main-panel">        
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit Proposal</h4>
                                <?php
                                // Ambil data proposal yang akan diedit
                                $id = $_GET['id'];
                                $query = mysqli_query($koneksi, "SELECT * FROM proposal WHERE id='$id'");
                                $data = mysqli_fetch_array($query);
                                
                                // Pastikan proposal ditemukan dan statusnya 'Revisi'
                                if(!$data || $data['status'] != 'Revisi') {
                                    echo "<script>
                                            alert('Data proposal tidak ditemukan atau tidak dapat diedit!');
                                            document.location='proposal.php';
                                        </script>";
                                    exit;
                                }
                                ?>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                    <input type="hidden" name="old_file" value="<?= $data['file_proposal'] ?>">
                                    
                                    <div class="form-group">
                                        <label for="nim">NIM</label>
                                        <input type="text" class="form-control" name="nim" id="nim" 
                                            value="<?= $data['nim'] ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="judul">Judul Proposal</label>
                                        <textarea class="form-control" name="judul" id="judul" rows="3" 
                                                placeholder="Masukkan Judul Proposal" required><?= $data['judul'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="file_proposal">File Proposal</label>
                                        <input type="file" class="form-control" name="file_proposal" id="file_proposal" 
                                            accept=".pdf,.doc,.docx">
                                        <small class="form-text text-muted">
                                            File yang diizinkan: PDF, DOC, DOCX. Maksimal 5MB
                                        </small>
                                        <small class="form-text text-muted">
                                            File saat ini: <?= $data['file_proposal'] ?>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                                        <input type="text" class="form-control" name="tanggal_pengajuan" 
                                            value="<?= date('Y-m-d H:i:s') ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <input type="text" class="form-control" name="status" 
                                            value="Menunggu Persetujuan" readonly>
                                    </div>
                                    <button type="submit" name="bupdate" class="btn btn-primary me-2">Update</button>
                                    <a href="proposal.php" class="btn btn-light">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../assets/vendors/chart.js/chart.umd.js"></script>
  <script src="../assets/js/jquery.cookie.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/template.js"></script>
  <script src="../assets/js/settings.js"></script>
  <script src="../assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../assets/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

