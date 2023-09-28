<?php
include("conn.php");
if (isset($_POST['delete'])) {
    $record_id = $_POST['delete'];
    
    $query = "DELETE FROM properties WHERE id = '$record_id'"; 
    $query_run = mysqli_query($conn,$query);
    
    if ($query_run) {
        header("location:project_mng.php");
        exit(0);
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


