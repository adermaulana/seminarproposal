<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");

}


if(isset($_POST['bsimpan'])) {
    $proposal_id = $_POST['proposal_id'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $ruangan = $_POST['ruangan'];
    $status = $_POST['status'];
    
    // Insert pembimbing 1
    mysqli_query($koneksi, "INSERT INTO pembimbing (proposal_id, nip, status) 
        VALUES ('$proposal_id', '$_POST[pembimbing1]', 'Pembimbing 1')");
    
    // Insert pembimbing 2
    mysqli_query($koneksi, "INSERT INTO pembimbing (proposal_id, nip, status) 
        VALUES ('$proposal_id', '$_POST[pembimbing2]', 'Pembimbing 2')");
    
    // Insert ke tabel seminar
    $query = mysqli_query($koneksi, "INSERT INTO seminar 
        (proposal_id, tanggal, waktu, ruangan, status) 
        VALUES 
        ('$proposal_id', '$tanggal', '$waktu', '$ruangan', '$status')");
    
    // Mendapatkan id seminar yang baru saja diinsert
    $seminar_id = mysqli_insert_id($koneksi);
    
    // Insert penguji 1
    mysqli_query($koneksi, "INSERT INTO penguji (seminar_id, nip) 
        VALUES ('$seminar_id', '$_POST[penguji1]')");
    
    // Insert penguji 2
    mysqli_query($koneksi, "INSERT INTO penguji (seminar_id, nip) 
        VALUES ('$seminar_id', '$_POST[penguji2]')");
    
    if($query) {
        echo "<script>
            alert('Data Berhasil Disimpan!');
            document.location='jadwal.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Gagal Disimpan!');
            document.location='jadwal.php';
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
                            <h4 class="card-title">Jadwal Seminar</h4>
                            <form class="forms-sample" method="POST">
                                <div class="form-group">
                                    <label for="proposal_id">Proposal</label>
                                    <select class="form-control" name="proposal_id" id="proposal_id" required>
                                        <option value="">Pilih Proposal</option>
                                        <?php
                                        // Mengambil proposal yang sudah disetujui
                                        $query_proposal = mysqli_query($koneksi, "
                                            SELECT p.id, p.judul, m.nim, m.nama 
                                            FROM proposal p 
                                            JOIN mahasiswa m ON p.nim = m.nim 
                                            WHERE p.status = 'Disetujui' 
                                            AND p.id NOT IN (SELECT proposal_id FROM seminar WHERE status != 'Ditunda')
                                            ORDER BY p.id DESC
                                        ");
                                        while($proposal = mysqli_fetch_array($query_proposal)):
                                        ?>
                                        <option value="<?= $proposal['id'] ?>">
                                            <?= $proposal['nim'] ?> - <?= $proposal['nama'] ?> - <?= $proposal['judul'] ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal Seminar</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                                </div>

                                <div class="form-group">
                                    <label for="waktu">Waktu Seminar</label>
                                    <input type="time" class="form-control" name="waktu" id="waktu" required>
                                </div>

                                <div class="form-group">
                                    <label for="ruangan">Ruangan</label>
                                    <input type="text" class="form-control" name="ruangan" id="ruangan" placeholder="Masukkan Ruangan" required>
                                </div>

                                <div class="form-group">
                                    <label for="pembimbing1">Pembimbing 1</label>
                                    <select class="form-control" name="pembimbing1" id="pembimbing1" required>
                                        <option value="">Pilih Pembimbing 1</option>
                                        <?php
                                        $query_dosen = mysqli_query($koneksi, "SELECT nip, nama FROM dosen ORDER BY nama");
                                        while($dosen = mysqli_fetch_array($query_dosen)):
                                        ?>
                                        <option value="<?= $dosen['nip'] ?>"><?= $dosen['nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="pembimbing2">Pembimbing 2</label>
                                    <select class="form-control" name="pembimbing2" id="pembimbing2" required>
                                        <option value="">Pilih Pembimbing 2</option>
                                        <?php
                                        $query_dosen = mysqli_query($koneksi, "SELECT nip, nama FROM dosen ORDER BY nama");
                                        while($dosen = mysqli_fetch_array($query_dosen)):
                                        ?>
                                        <option value="<?= $dosen['nip'] ?>"><?= $dosen['nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="penguji1">Penguji 1</label>
                                    <select class="form-control" name="penguji1" id="penguji1" required>
                                        <option value="">Pilih Penguji 1</option>
                                        <?php
                                        $query_dosen = mysqli_query($koneksi, "SELECT nip, nama FROM dosen ORDER BY nama");
                                        while($dosen = mysqli_fetch_array($query_dosen)):
                                        ?>
                                        <option value="<?= $dosen['nip'] ?>"><?= $dosen['nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="penguji2">Penguji 2</label>
                                    <select class="form-control" name="penguji2" id="penguji2" required>
                                        <option value="">Pilih Penguji 2</option>
                                        <?php
                                        $query_dosen = mysqli_query($koneksi, "SELECT nip, nama FROM dosen ORDER BY nama");
                                        while($dosen = mysqli_fetch_array($query_dosen)):
                                        ?>
                                        <option value="<?= $dosen['nip'] ?>"><?= $dosen['nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control" name="status" id="status" 
                                        value="Dijadwalkan" readonly>
                                </div>

                                <button type="submit" name="bsimpan" class="btn btn-primary me-2">Submit</button>
                                <a href="seminar.php" class="btn btn-light">Cancel</a>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
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

