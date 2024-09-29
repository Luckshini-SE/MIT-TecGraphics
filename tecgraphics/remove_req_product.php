<?php
include('db_connection.php');

$rowid = $_GET['rowid'];

mysqli_query($con, "DELETE FROM requests WHERE id = '$rowid' AND status = 'open'");
?>