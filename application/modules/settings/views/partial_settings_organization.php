<script type="text/javascript">
    $(function () {
        $("#organization_country").select2({allowClear: true});
    });
</script>

<div class="tab-info">

    <?php // pZ: ?>
    <?php foreach(array('name', 'street_address', 'city', 'zip', 'country', '---', 'bank_account', 'nip', '---', 'phone', 'email', 'web') as $field): ?>

    <?php if ($field == '---'): ?>

    <div class="form-group">
        <hr/>
    </div>

    <?php elseif ($field == 'country'): ?>
            
    <?php $selected_country = $this->mdl_settings->setting('organization_' . $field); ?>

    <div class="form-group">
        <label for="organization_<?php echo $field ?>" class="control-label">
            <?php echo lang('organization_' . $field); ?>:
        </label>
        <select name="settings[organization_<?php echo $field ?>]" id="organization_<?php echo $field ?>" class="form-control">
            <option></option>
            <?php foreach ($countries as $cldr => $country) { ?>
                <option value="<?php echo $cldr; ?>"
                        <?php if ($selected_country == $cldr) { ?>selected="selected"<?php } ?>><?php echo $country ?></option>
            <?php } ?>
        </select>
    </div>

    <?php else: ?>

    <div class="form-group">
        <label for="organization_<?php echo $field ?>" class="control-label">
            <?php echo lang('organization_' . $field); ?>:
        </label>
        <input type="text" name="settings[organization_<?php echo $field ?>]" id="organization_<?php echo $field ?>" class="input-sm form-control"
               value="<?php echo $this->mdl_settings->setting('organization_' . $field); ?>">
    </div>

    <?php endif; ?>
    
    <?php endforeach; ?>

</div>
