<?php
session_start();

include('db_connection.php');

$rmvId = $_POST['rmvId'];

$delete = mysqli_query($con, "DELETE FROM requests WHERE id = '$rmvId' AND status = 'open'");
?>
<script>
	setTimeout('window.location="get_quotation.php"',0);
</script>