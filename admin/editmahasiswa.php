<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");

}


// Proses Update Data
if(isset($_POST['bupdate'])) {
    // Persiapan update data
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    
    // Buat query update sesuai dengan ada tidaknya perubahan password
    if(!empty($_POST['password'])) {
        // Jika password diisi, update dengan password baru
        $password = md5($_POST['password']);
        $update = mysqli_query($koneksi, "UPDATE mahasiswa SET 
                                         nama = '$nama',
                                         email = '$email',
                                         jurusan = '$jurusan',
                                         password = '$password'
                                         WHERE nim = '$nim'");
    } else {
        // Jika password kosong, update tanpa mengubah password
        $update = mysqli_query($koneksi, "UPDATE mahasiswa SET 
                                         nama = '$nama',
                                         email = '$email',
                                         jurusan = '$jurusan'
                                         WHERE nim = '$nim'");
    }
    
    if($update) {
        echo "<script>
                alert('Update data sukses!');
                document.location='mahasiswa.php';
             </script>";
    } else {
        echo "<script>
                alert('Update data GAGAL!!');
                document.location='mahasiswa.php?hal=edit&nim=" . $nim . "';
             </script>";
    }
}

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
              <span class="nav-profile-name"><?= $_SESSION['nama_admin'] ?></span>
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
            <a class="nav-link" href="mahasiswa.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Mahasiswa</span>
            </a>
          </li>                                    
          <li class="nav-item">
            <a class="nav-link" href="dosen.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dosen</span>
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
                              <h4 class="card-title">Edit Mahasiswa</h4>
                              <?php
                              // Memeriksa parameter hal dan nim
                              if(isset($_GET['hal']) && $_GET['hal'] == "edit" && isset($_GET['nim'])) {
                                  $nim = mysqli_real_escape_string($koneksi, $_GET['nim']);
                                  
                                  // Query untuk mendapatkan data mahasiswa
                                  $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim = '$nim'");
                                  $data = mysqli_fetch_assoc($query);

                                  // Jika data ditemukan
                                  if($data) {
                              ?>
                              <form class="forms-sample" method="POST">
                                  <div class="form-group">
                                      <label for="nim">NIM</label>
                                      <input type="text" class="form-control" name="nim" id="nim" value="<?= $data['nim'] ?>" readonly>
                                  </div>
                                  <div class="form-group">
                                      <label for="nama">Nama Lengkap</label>
                                      <input type="text" class="form-control" name="nama" id="nama" value="<?= $data['nama'] ?>" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="email">Email</label>
                                      <input type="email" class="form-control" name="email" id="email" value="<?= $data['email'] ?>" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="jurusan">Jurusan</label>
                                      <select class="form-control" name="jurusan" id="jurusan" required>
                                          <option value="">Pilih Jurusan</option>
                                          <option value="Teknik Informatika" <?= ($data['jurusan'] == 'Teknik Informatika') ? 'selected' : '' ?>>Teknik Informatika</option>
                                          <option value="Sistem Informasi" <?= ($data['jurusan'] == 'Sistem Informasi') ? 'selected' : '' ?>>Sistem Informasi</option>
                                          <option value="Teknik Komputer" <?= ($data['jurusan'] == 'Teknik Komputer') ? 'selected' : '' ?>>Teknik Komputer</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="password">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                      <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password Baru">
                                  </div>
                                  <button type="submit" name="bupdate" class="btn btn-primary me-2">Update</button>
                                  <a href="mahasiswa.php" class="btn btn-light">Cancel</a>
                              </form>
                              <?php
                                  } else {
                                      echo "<div class='alert alert-danger'>Data mahasiswa tidak ditemukan.</div>";
                                  }
                              } else {
                                  echo "<div class='alert alert-danger'>Parameter tidak valid.</div>";
                              }
                              ?>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
              <div class="card">
                  <div class="card-body">
                      <div class="d-sm-flex justify-content-center justify-content-sm-between">
                          <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 <a href="https://www.bootstrapdash.com/" class="text-muted" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
                          <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center text-muted">Hand-crafted & made with <i class="typcn typcn-heart-full-outline text-danger"></i></span>
                      </div>
                  </div>    
              </div>        
          </footer>
          <!-- partial -->
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

