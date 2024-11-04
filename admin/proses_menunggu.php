<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Update status proposal menjadi Revisi
    $query = mysqli_query($koneksi, "UPDATE proposal SET status = 'Menunggu Persetujuan' WHERE id = '$id'");
    
    if($query) {
        echo "<script>
            alert('Proposal diminta untuk menunggu persetujuan!');
            document.location='proposal.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menunggu persetujuan!');
            document.location='proposal.php';
        </script>";
    }
}
?>