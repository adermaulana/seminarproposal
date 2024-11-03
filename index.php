<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:admin");
    }

    if(isset($_POST['login'])){

        $username = $_POST['username'];
        $nim = $_POST['nim'];
        $nip = $_POST['nip'];
        $password = md5($_POST['password']);

        $login = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' and password='$password'");
        $cek = mysqli_num_rows($login);

        $loginMahasiswa = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim='$nim' and password='$password'");
        $cekMahasiswa = mysqli_num_rows($loginMahasiswa);

        $loginDosen = mysqli_query($koneksi, "SELECT * FROM dosen WHERE nip='$nip' and password='$password'");
        $cekDosen = mysqli_num_rows($loginDosen);

        if($cek > 0) {
            $admin_data = mysqli_fetch_assoc($login);
            $_SESSION['id_admin'] = $admin_data['id'];
            $_SESSION['nama_admin'] = $admin_data['nama'];
            $_SESSION['username_admin'] = $username;
            $_SESSION['status'] = "login";
            header('location:admin');

        } else if ($cekMahasiswa > 0) {
            $admin_data = mysqli_fetch_assoc($loginMahasiswa);
            $_SESSION['id_admin'] = $admin_data['id'];
            $_SESSION['nama_admin'] = $admin_data['nama'];
            $_SESSION['username_admin'] = $username;
            $_SESSION['status'] = "login";
            header('location:mahasiswa');

        } else if ($cekDosen > 0) {
            $admin_data = mysqli_fetch_assoc($loginDosen);
            $_SESSION['id_admin'] = $admin_data['id'];
            $_SESSION['nama_admin'] = $admin_data['nama'];
            $_SESSION['username_admin'] = $username;
            $_SESSION['status'] = "login";
            header('location:dosen');

        }  else {
            echo "<script>
            alert('Login Gagal, Periksa Username dan Password Anda!');
            header('location:index.php');
                 </script>";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/login/css/bootstrap.min.css">
    <title>Login</title>

    <style>



    </style>

</head>
<body>

<section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">

        <form method="post" action="">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <h3 class="mb-5">Sign in</h3>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="role">Login Sebagai</label>
                    <select class="form-select form-select-lg" id="role" name="role" onchange="updateForm(this.value)">
                        <option value="" selected disabled>Pilih Role</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Form untuk Mahasiswa -->
                <div id="form-mahasiswa" style="display: none;">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="nim">NIM</label>
                        <input type="text" id="nim" name="nim" class="form-control form-control-lg" />
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" />
                    </div>
                </div>

                <!-- Form untuk Dosen -->
                <div id="form-dosen" style="display: none;">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="nip">NIP</label>
                        <input type="text" id="nip" name="nip" class="form-control form-control-lg" />
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" />
                    </div>
                </div>

                <!-- Form untuk Admin -->
                <div id="form-admin" style="display: none;">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control form-control-lg" />
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="password_admin">Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" />
                    </div>
                </div>

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>

            </div>
            </div>
        </form>

        </div>
        </div>
    </div>

    <script>
    function updateForm(role) {
        // Sembunyikan semua form
        document.getElementById('form-mahasiswa').style.display = 'none';
        document.getElementById('form-dosen').style.display = 'none';
        document.getElementById('form-admin').style.display = 'none';
        
        // Tampilkan form yang dipilih
        if(role) {
            document.getElementById('form-' + role).style.display = 'block';
        }
    }
    </script>
</section>

    <script src="assets/login/js/bootstrap.bundle.min.js"></script>

</body>
</html>