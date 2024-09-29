<?php
include('db_connection.php');

$usertype = $_POST['usertype'];
?>
<div class="row form-group mb-3">
	<table class="table table-bordered">
	<?php
	$i=1;
	$select_psection = mysqli_query($con, "SELECT id, section, description FROM pages ORDER BY section_order, page_order");
	while($result_psection = mysqli_fetch_array($select_psection)){
	
		$select_pri = mysqli_query($con, "SELECT * FROM user_privilege WHERE user_type = '$usertype' AND page = '{$result_psection['id']}'");
		if(mysqli_num_rows($select_pri) > 0){
			$checked = 'checked';
		} else {
			$checked = '';
		}
	?>
		<tr>
			<td><?php echo $result_psection['section'] ?></td>
			<td><?php echo $result_psection['description'] ?><input type="hidden" name="pageid<?php echo $i; ?>" id="pageid<?php echo $i; ?>" value="<?php echo $result_psection['id'] ?>" /></td>
			<td align="center"><input type="checkbox" name="enable<?php echo $i; ?>" id="enable<?php echo $i; ?>" <?php echo $checked; ?> /></td>
		</tr>
	<?php
	$i++;
	}
	?>
	<input type="hidden" name="num" id="num" value="<?php echo $i-1; ?>" />
	</table>
</div>

<div class="row form-group mb-3">
	<div class="col-4">
		<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" />
	</div>
</div>