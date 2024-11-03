<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Update status proposal menjadi Revisi
    $query = mysqli_query($koneksi, "UPDATE proposal SET status = 'Revisi' WHERE id = '$id'");
    
    if($query) {
        echo "<script>
            alert('Proposal diminta untuk direvisi!');
            document.location='proposal.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal meminta revisi proposal!');
            document.location='proposal.php';
        </script>";
    }
}
?>