<?php
include('db_connection.php');

$cus_id = $_GET['cus_id'];

$select_creq = mysqli_query($con, "SELECT * FROM requests WHERE cust_id = '$cus_id' AND status = 'open'");

if(mysqli_num_rows($select_creq) > 0){
?>
<table class="table table-bordered" width="75%">
	<tr>
		<td><b>Product</b></td>
		<td><b>Qty</b></td>
		<td>&nbsp;</td>
	</tr>
<?php
$i=1;
while($result_creq = mysqli_fetch_array($select_creq)){

		$select_proname = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_creq['prod_id']}'");
		$result_proname = mysqli_fetch_array($select_proname);
?>
	<tr>
		<td><?php echo $result_proname['name']; ?><input type="hidden" name="rowid<?php echo $i; ?>" id="rowid<?php echo $i; ?>" value="<?php echo $result_creq['id']; ?>" /></td>
		<td><?php echo $result_creq['qty']; ?></td>
		<td><button type="button" class="btn btn-danger" name="delete" id="delete" onclick="deleteRow(<?php echo $i; ?>)" >Delete</button></td>
	<tr>
<?php
$i++;
}
?>
</table>
<?php }?>