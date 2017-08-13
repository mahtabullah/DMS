<div class="row">
            <div class="col-md-12">
                <span class="help-block">
                    Select <?php echo $arr[0]['text']; ?> <span style="color: red">*</span>
                </span>
                <select class="form-control input-xlarge" data-placeholder="Select..." id="layer<?php echo $arr[0]['layer_number']+1; ?>" onchange="layer_change(<?php echo $arr[0]['layer_number']+1; ?>)" name="layer<?php echo $arr[0]['layer_number']+1; ?>" required>
                    <option value=""></option>
                    <?php foreach ($arr as $key) { ?>
                        <option value="<?php echo $key['id'] ?>" data-category="<?php echo $arr[0]['biz_zone_category_id']?>"><?php echo $key['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
