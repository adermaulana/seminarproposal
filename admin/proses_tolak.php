<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Update status proposal menjadi Ditolak
    $query = mysqli_query($koneksi, "UPDATE proposal SET status = 'Ditolak' WHERE id = '$id'");
    
    if($query) {
        echo "<script>
            alert('Proposal telah ditolak!');
            document.location='proposal.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menolak proposal!');
            document.location='proposal.php';
        </script>";
    }
}
?>