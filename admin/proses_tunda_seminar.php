<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Update status proposal menjadi Disetujui
    $query = mysqli_query($koneksi, "UPDATE seminar SET status = 'Ditunda' WHERE id = '$id'");
    
    if($query) {
        echo "<script>
            alert('Seminar berhasil ditunda!');
            document.location='jadwal.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menunda seminar!');
            document.location='jadwal.php';
        </script>";
    }
}
?>