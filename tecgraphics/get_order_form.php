<?php
include('db_connection.php');

$ordid = $_GET['ord'];

$select_prod = mysqli_query($con, "SELECT * FROM requests WHERE req_id = '$ordid'");
while($result_prod = mysqli_fetch_array($select_prod)){

                        $select_prodname = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_prod['prod_id']}'");
                        $result_prodname = mysqli_fetch_array($select_prodname);

                        $description = '';

                        if($result_prod['material'] != ''){
                            $select_mat = mysqli_query($con, "SELECT name FROM pro_material WHERE id = '{$result_prod['material']}'");
                            $result_mat = mysqli_fetch_array($select_mat);

                            $description .= $result_mat['name'];
                        }
                        
                        if($result_prod['size'] != ''){
                            $select_siz = mysqli_query($con, "SELECT name FROM pro_size WHERE id = '{$result_prod['size']}'");
                            $result_siz = mysqli_fetch_array($select_siz);

                            $description .= ' | '.$result_siz['name'];
                        }
                        
                        if($result_prod['finishing'] != ''){
                            $select_fin = mysqli_query($con, "SELECT name FROM pro_finishing WHERE id = '{$result_prod['finishing']}'");
                            $result_fin = mysqli_fetch_array($select_fin);

                            $description .= ' | '.$result_fin['name'];
                        }
                        
                        if($result_prod['color'] != ''){
                            $select_col = mysqli_query($con, "SELECT name FROM pro_color WHERE id = '{$result_prod['color']}'");
                            $result_col = mysqli_fetch_array($select_col);

                            $description .= ' | '.$result_col['name'];
                        }
                        
                        if($result_prod['spec1'] != ''){
                            $select_sp1 = mysqli_query($con, "SELECT name FROM pro_spec1 WHERE id = '{$result_prod['spec1']}'");
                            $result_sp1 = mysqli_fetch_array($select_sp1);

                            $description .= ' | '.$result_sp1['name'];
                        }
                        
                        if($result_prod['spec2'] != ''){
                            $select_sp2 = mysqli_query($con, "SELECT name FROM pro_spec2 WHERE id = '{$result_prod['spec2']}'");
                            $result_sp2 = mysqli_fetch_array($select_sp2);

                            $description .= ' | '.$result_sp2['name'];
                        }
?>
<div class="row" style="font-size: 13px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #eb5d1e;" >
    <div class="col-md-9">
         <b><?php echo $result_prodname['name']; ?></b><br/><?php echo $description; ?>
    </div>
    <div class="col-md-3" >
         Qty : <?php echo $result_prod['qty']; ?>
    </div>
 </div>
<?php } ?>