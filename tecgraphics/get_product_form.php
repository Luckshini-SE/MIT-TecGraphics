<?php
include('db_connection.php');

$prod = $_GET['product'];

    $select_prod = mysqli_query($con, "SELECT * FROM products WHERE id = '$prod'");
    $result_prod = mysqli_fetch_array($select_prod);

    $select_unit = mysqli_query($con, "SELECT measure FROM pricing WHERE id = '{$result_prod['pricing']}'");
    $result_unit = mysqli_fetch_array($select_unit);
?>

                <div class="row mb-3">
                    
                    <?php if($result_prod['material'] == 1){ ?>
                    <div class="form-group col-md-6 mb-2">
                      <label for="artwork">Type/Material</label>
                      <select class="form-select" name="material" id="material" >
                        <?php
                        $select_mat = mysqli_query($con, "SELECT * FROM pro_material WHERE prod_id = '{$result_prod['id']}'");
						while($result_mat = mysqli_fetch_array($select_mat)){
                        ?>
                        <option value="<?php echo $result_mat['id']; ?>"><?php echo $result_mat['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="material_error" ></span>
                    </div>
                    <?php } ?>

                    <input type="hidden" class="form-control" name="price_para" id="price_para" value="<?php echo $result_prod['pricing']; ?>" />
                    <?php 
                    if($result_prod['pricing'] == 1){ 
                    if($result_prod['size'] == 1){ 
                    ?>
                    <div class="form-group col-md-6 mb-2">
                      <label for="artwork">Size</label>
                      <select class="form-select" name="size" id="size" >
                        <?php
                        $select_siz = mysqli_query($con, "SELECT * FROM pro_size WHERE prod_id = '{$result_prod['id']}'");
						while($result_siz = mysqli_fetch_array($select_siz)){
                        ?>
                        <option value="<?php echo $result_siz['id']; ?>"><?php echo $result_siz['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php }} else { ?>
                    <div class="form-group col-md-3 mb-2">
                      <label for="artwork">Size (<?php echo $result_unit['measure']; ?>)</label>
                      <input type="text" class="form-control" name="width" id="width" placeholder="Width" onkeypress="return isNumberKeyn(event);" />
                      <span class="error_msg" id="wd_error" ></span>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                      <label for="artwork">&nbsp;</label>
                      <input type="text" class="form-control" name="height" id="height" placeholder="Height" onkeypress="return isNumberKeyn(event);" />
                      <span class="error_msg" id="ht_error" ></span>
                    </div>
                    <?php } ?>
                    
                    <?php if($result_prod['finishing'] == 1){ ?>
                    <div class="form-group col-md-6 mb-2">
                      <label for="artwork">Finishing</label>
                      <select class="form-select" name="finishing" id="finishing" >
                        <?php
                        $select_fin = mysqli_query($con, "SELECT * FROM pro_finishing WHERE prod_id = '{$result_prod['id']}'");
						while($result_fin = mysqli_fetch_array($select_fin)){
                        ?>
                        <option value="<?php echo $result_fin['id']; ?>"><?php echo $result_fin['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php } ?>
                    
                    <?php if($result_prod['color'] == 1){ ?>
                    <div class="form-group col-md-6 mb-2">
                      <label for="artwork">Colour</label>
                      <select class="form-select" name="color" id="color" >
                        <?php
                        $select_col = mysqli_query($con, "SELECT * FROM pro_color WHERE prod_id = '{$result_prod['id']}'");
						while($result_col = mysqli_fetch_array($select_col)){
                        ?>
                        <option value="<?php echo $result_col['id']; ?>"><?php echo $result_col['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php } ?>
                    
                    <?php if($result_prod['spec1'] == 1){ ?>
                    <div class="form-group col-md-6" mb-2>
                      <label for="artwork">Specification 1</label>
                      <select class="form-select" name="spec1" id="spec1" >
                        <?php
                        $select_spo = mysqli_query($con, "SELECT * FROM pro_spec1 WHERE prod_id = '{$result_prod['id']}'");
						while($result_spo = mysqli_fetch_array($select_spo)){
                        ?>
                        <option value="<?php echo $result_spo['id']; ?>"><?php echo $result_spo['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php } ?>
                    
                    <?php if($result_prod['spec2'] == 1){ ?>
                    <div class="form-group col-md-6 mb-2">
                      <label for="artwork">Specification 2</label>
                      <select class="form-select" name="spec2" id="spec2" >
                        <?php
                        $select_spt = mysqli_query($con, "SELECT * FROM pro_spec2 WHERE prod_id = '{$result_prod['id']}'");
						while($result_spt = mysqli_fetch_array($select_spt)){
                        ?>
                        <option value="<?php echo $result_spt['id']; ?>"><?php echo $result_spt['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php } ?>

                    <div class="form-group col-md-6 mb-2">
                      <label for="quantity">Quantity</label>
                      <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity" onkeypress="return isNumberKey(event);" />
                      <span class="error_msg" id="quantity_error" ></span>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                      <label for="artwork">Artwork</label>
                      <select class="form-select" name="artwork" id="artwork" >
                        <option value="need">I need artwork</option>
                        <option value="not">I will provide artwork</option>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    
                    <div class="form-group col-md-6 mb-2">
                      <label for="service">Service Type</label>
                      <select class="form-select" name="service" id="service" >
                        <option value="standard">Standard</option>
                        <option value="oneday">One Day</option>
                      </select>
                      <span id="st_error" ></span>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                      <label for="upload1">Upload 1</label>
                      <input type="file" class="form-control" name="upload1" id="upload1" />
                    </div>
                    
                    <div class="form-group col-md-6 mb-2">
                      <label for="upload2">Upload 2</label>
                      <input type="file" class="form-control" name="upload2" id="upload2" />
                    </div>

                    <div class="form-group col-md-12">
                      <label for="spnote">Special Note</label>
                      <textarea class="form-control" name="spnote" id="spnote" rows="3" ></textarea>
                    </div>

                 </div>