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
            cursor:pointer;
        }
        tr:hover {
            color:blue;
        }
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
                <?php
                    $select_mat = mysqli_query($con, "SELECT id, name, uom FROM rawmaterial");
                    $i=1;
                    while($result_mat = mysqli_fetch_array($select_mat)){

                        $select_uom = mysqli_query($con, "SELECT name FROM unit_of_measure WHERE id = '{$result_mat['uom']}'");
                        $result_uom = mysqli_fetch_array($select_uom);
                ?>    
                <tr onclick="getValue(<?php echo $row; ?>,<?php echo $i; ?>)">
                    <td><?php echo $result_mat['name']; ?>
                        <input type="hidden" name="sel_itmid<?php echo $i; ?>" id="sel_itmid<?php echo $i; ?>" value="<?php echo $result_mat['id']; ?>" />
                        <input type="hidden" name="sel_itmna<?php echo $i; ?>" id="sel_itmna<?php echo $i; ?>" value="<?php echo $result_mat['name']; ?>" />
                        <input type="hidden" name="sel_uom<?php echo $i; ?>" id="sel_uom<?php echo $i; ?>" value="<?php echo $result_uom['name']; ?>" />
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
        window.opener.document.getElementById("uom"+j).innerHTML = document.getElementById("sel_uom"+i).value;
        window.close();
    }
    </script>
</body>