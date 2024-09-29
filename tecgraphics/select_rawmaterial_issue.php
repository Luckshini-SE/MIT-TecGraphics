<!DOCTYPE html>
<html lang="en">
   
<head>
    <title>Raw Materials</title>
	<style>
        body {
            background-color: #f5f5f5;
            font-family:Verdana;
            font-size:0.85em;
            color:#5b6269;
        }
		.popup-content {
            background-color:#fff;
            border-radius:.25rem;
            box-shadow: 1px 1px 5px 6px #f2f2f2;
            margin: 25px;
            padding: 20px;
        }
        tr {
            height:35px;
        }
        /*tr:hover {
            color:blue;
        }*/
	</style>
</head>

<body>
    <?php 
    include('db_connection.php'); 
    $row = $_GET['row'];
    ?>
	<div class="popup">
        <div class="popup-content">
            <table width="100%">
                <tr>
                    <td><b>Raw Material</b></td>
                    <td><b>Available Qty</b></td>
                </tr>
                <?php
                    $select_mat = mysqli_query($con, "SELECT id, name FROM rawmaterial");
                    $i=1;
                    while($result_mat = mysqli_fetch_array($select_mat)){

                    $select_stock = mysqli_query($con, "SELECT SUM(available_qty) FROM grn_stock WHERE item_id = '{$result_mat['id']}'");
                    $result_stock = mysqli_fetch_array($select_stock);
                        $available = $result_stock[0];

                    if($available == '') $available = 0;
                ?>    
                <tr <?php if($available>0){ ?> style="cursor:pointer;" onclick="getValue(<?php echo $row; ?>,<?php echo $i; ?>)" onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='#5b6269'" <?php } ?>>
                    <td><?php echo $result_mat['name']; ?>
                        <input type="hidden" name="sel_itmid<?php echo $i; ?>" id="sel_itmid<?php echo $i; ?>" value="<?php echo $result_mat['id']; ?>" />
                        <input type="hidden" name="sel_itmna<?php echo $i; ?>" id="sel_itmna<?php echo $i; ?>" value="<?php echo $result_mat['name']; ?>" />
                    </td>
                    <td><?php echo $available; ?>
                        <input type="hidden" name="sel_stock<?php echo $i; ?>" id="sel_stock<?php echo $i; ?>" value="<?php echo $available; ?>" />
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
    </div>

    <script>
    function getValue(j,i){
        window.opener.document.getElementById("item"+j).value = document.getElementById("sel_itmna"+i).value;
        window.opener.document.getElementById("itemid"+j).value = document.getElementById("sel_itmid"+i).value;
        window.opener.document.getElementById("ava"+j).value = document.getElementById("sel_stock"+i).value;
        window.opener.chkava(j);
        window.close();
    }
    </script>
</body>