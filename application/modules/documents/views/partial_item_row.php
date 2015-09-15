<?php if (!isset($disabled)) { $disabled = ''; } ?>
<?php if (!isset($item)) { $item = null; } ?>

<tbody <?php echo ($item) ? 'class="item"' : 'id="new_row" style="display: none;"'; ?>>
<tr>
    <td rowspan="2" class="td-icon"><i class="fa fa-arrows cursor-move"></i></td>
    <td class="td-text">
        <input type="hidden" name="<?php echo $document; ?>_id" value="<?php echo ${$document . '_id'}; ?>">
        <input <?php echo $disabled; ?> type="hidden" name="item_id" value="<?php echo ($item) ? $item->item_id : ''; ?>">

        <div class="input-group">
            <span class="input-group-addon"><?php echo lang('item'); ?></span>
            <input <?php echo $disabled; ?> type="text" id="typeahead_name_<?php echo ($item) ? $item->item_id : 'new'; ?>" name="item_name" class="input-sm form-control" value="<?php echo ($item) ? html_escape($item->item_name) : ''; ?>"
                data-provide="typeahead"
                autocomplete="off"
                placeholder="Nazwa produktu"
                data-items="5"
                data-minLength="0">
            <div class="input-group-addon typeahead_button" id="typeahead_button_<?php echo ($item) ? $item->item_id : 'new'; ?>"></div>
        </div>
    </td>
    <td class="td-amount td-quantity">
        <div class="input-group">
            <span class="input-group-addon"><?php echo lang('quantity'); ?></span>
            <input <?php echo $disabled; ?> type="text" id="typeahead_quantity_<?php echo ($item) ? $item->item_id : 'new'; ?>" name="item_quantity" class="input-sm form-control amount" value="<?php echo ($item) ? format_amount($item->item_quantity) : ''; ?>">
        </div>
    </td>
    <td class="td-amount">
        <div class="input-group">
            <span class="input-group-addon"><?php echo lang('price'); ?></span>
            <input <?php echo $disabled; ?> type="text" id="typeahead_price_<?php echo ($item) ? $item->item_id : 'new'; ?>" name="item_price" class="input-sm form-control amount" value="<?php echo ($item) ? format_amount($item->item_price) : ''; ?>">
        </div>
    </td>
    <td class="td-amount ">
        <div class="input-group">
            <span class="input-group-addon"><?php echo lang('item_discount'); ?></span>
            <input <?php echo $disabled; ?> type="text" name="item_discount_amount" class="input-sm form-control amount" value="<?php echo ($item) ? format_amount($item->item_discount_amount) : ''; ?>">
            <div class="input-group-addon">&percnt;</div>
        </div>
    </td>
    <td class="td-amount">
        <div class="input-group">
            <span class="input-group-addon"><?php echo lang('tax_rate'); ?></span>
            <select <?php echo $disabled; ?> name="item_tax_rate_id" name="item_tax_rate_id" class="form-control input-sm">
                <option value="0"><?php echo lang('none'); ?></option>
                <?php foreach ($tax_rates as $tax_rate) { ?>
                    <?php
                        $selected = '';
                        if ($item) {
                            if ($item->item_tax_rate_id == $tax_rate->tax_rate_id) {
                                $selected = 'selected="selected"';
                            }
                        } else {
                            $default_item_tax_rate = $this->mdl_settings->setting('default_item_tax_rate');
                            if ($default_item_tax_rate == $tax_rate->tax_rate_id) {
                                $selected = 'selected="selected"';
                            }
                        }
                    ?>
                    <option value="<?php echo $tax_rate->tax_rate_id; ?>" <?php echo $selected ?>>
                        <?php echo $tax_rate->tax_rate_percent . '% - ' . $tax_rate->tax_rate_name; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </td>
    <td class="td-icon text-right td-vert-middle">
        <?php if ($item):  ?>
            <?php if (!( ($document == 'invoice') && (${$document}->is_read_only == 1) )): ?>
            <a href="<?php echo site_url(($document . 's') . '/delete_item/' . ${$document . '_id'} . '/' . $item->item_id); ?>" title="<?php echo lang('delete'); ?>"
                onclick="return confirm('<?php echo lang('delete_record_warning'); ?>')">
                <i class="fa fa-trash-o text-danger"></i>
            </a>
            <?php endif; ?>
        <?php else: ?>
            <a href="#" title="<?php echo lang('delete'); ?>" class="btn_delete_row">
                <i class="fa fa-trash-o text-danger"></i>
            </a>
        <?php endif; ?>
    </td>
</tr>
<tr>
    <td class="td-textarea">
        <div class="input-group">
            <span class="input-group-addon"><?php echo lang('description'); ?></span>
            <textarea <?php echo $disabled; ?> name="item_description" class="input-sm form-control"><?php echo ($item) ? $item->item_description : ''; ?></textarea>
        </div>
    </td>

    <td colspan="2" class="td-amount td-vert-middle">
<?php if ($item): ?>
        <span><?php echo lang('subtotal'); ?></span>:&nbsp;
        <span name="subtotal" class="amount"><?php echo format_currency($item->item_subtotal); ?></span>
<?php endif; ?>
    </td>
    <td class="td-amount td-vert-middle">
<?php if ($item): ?>
        <span><?php echo lang('discount'); ?></span>:&nbsp;
        <span name="item_discount_total" class="amount"><?php echo format_currency($item->item_discount); ?></span><br/>
        <span><?php echo lang('subtotal'); ?> z rabatem</span>:&nbsp;
        <span name="item_discount_total" class="amount"><?php echo format_currency($item->item_subtotal - $item->item_discount); ?></span>
<?php endif; ?>
    </td>
    <td class="td-amount td-vert-middle">
<?php if ($item): ?>
        <span><?php echo lang('tax'); ?> po rabacie</span>:<br/>
        <span name="item_tax_total" class="amount"><?php echo format_currency($item->item_tax_total); ?></span>
<?php endif; ?>
    </td>
    <td class="td-amount">
<?php if ($item): ?>
        <span><?php echo lang('total'); ?> brutto</span><br/>
        <span name="item_total" class="amount"><strong><?php echo format_currency($item->item_total); ?></strong></span>
<?php endif; ?>
    </td>
</tr>
</tbody>
