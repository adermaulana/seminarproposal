<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:admin");
    }

    if(isset($_POST['login'])){

        $nip = $_POST['nip'];
        $password = md5($_POST['password']);

        $login = mysqli_query($koneksi, "SELECT * FROM dosen WHERE nip='$nip' and password='$password'");
        $cek = mysqli_num_rows($login);

        if($cek > 0) {
            $admin_data = mysqli_fetch_assoc($login);
            $_SESSION['nip'] = $admin_data['nip'];
            $_SESSION['nama_dosen'] = $admin_data['nama'];
            $_SESSION['username_dosen'] = $username;
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
        <form method="post">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
                <a class="btn btn-success btn-lg btn-block" href="loginmahasiswa.php">Mahasiswa</a>
                <a class="btn btn-primary btn-lg btn-block" href="index.php">Admin</a>

                <h3 class="mb-5 mt-3">Sign in</h3>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="nip">Nip</label>
                <input type="text" id="nip" name="nip" class="form-control form-control-lg" />
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" />
                </div>


                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>


            </div>
            </div>
        </form>

        </div>
        </div>
    </div>
    </section>

    <script src="assets/login/js/bootstrap.bundle.min.js"></script>

</body>
</html>