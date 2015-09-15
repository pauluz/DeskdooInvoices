<h2>
    <a href="<?php echo site_url('clients/view/' . $document->client_id); ?>"><?php echo $document->client_name; ?></a>
    <?php if (isset($status_id_field) && ($document->$status_id_field == 1)) { ?>
        <span id="doc_change_client" class="fa fa-edit cursor-pointer small" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('change_client'); ?>"></span>
    <?php } ?>
</h2><br>
<span>
    <?php echo ($document->client_address_1) ? $document->client_address_1 . '<br>' : ''; ?>
    <?php echo ($document->client_address_2) ? $document->client_address_2 . '<br>' : ''; ?>
    <?php echo ($document->client_zip) ? $document->client_zip : ''; ?>
    <?php echo ($document->client_city) ? $document->client_city : ''; ?>
    <?php echo ($document->client_state) ? $document->client_state : ''; ?>
    <?php echo ($document->client_country) ? '<br>' . get_country_name(lang('cldr'), $document->client_country) : ''; ?>
</span>
<br><br>
<?php if ($document->client_phone) { ?>
    <span><strong><?php echo lang('phone'); ?>
            :</strong> <?php echo $document->client_phone; ?></span><br>
<?php } ?>
<?php if ($document->client_email) { ?>
    <span><strong><?php echo lang('email'); ?>
            :</strong> <?php echo $document->client_email; ?></span>
<?php } ?>
