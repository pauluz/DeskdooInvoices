<?php
    global $single_name;
    $single_name = substr($mdl_document, 0, -1);
    function get_method_name($suffix = '') {
        global $single_name;
        if (!empty($suffix)) {
            return $single_name . '_' . $suffix;
        }
        return $single_name;
    }
?>
<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th><?php echo lang('status'); ?></th>
            <th><?php echo lang(get_method_name()); ?></th>
            <th><?php echo lang('created'); ?></th>
            <th><?php echo lang('created_by'); ?></th>
            <th><?php echo lang('due_date'); ?></th>
            <th><?php echo lang('client_name'); ?></th>
            <th style="text-align: right;"><?php echo lang('amount'); ?></th>
            <th style="text-align: right;"><?php echo lang('balance'); ?></th>
            <th><?php echo lang('options'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($documents as $doc) {
            if ($this->config->item('disable_read_only') == TRUE) {
                $doc->is_read_only = 0;
            }
            ?>
            <tr>
                <td>
                    <span class="label <?php echo $document_statuses[$doc->{get_method_name('status_id')}]['class']; ?>">
                        <?php echo $document_statuses[$doc->{get_method_name('status_id')}]['label'];
                        if ($doc->invoice_sign == '-1') { ?>
                            &nbsp;<i class="fa fa-credit-invoice" title="<?php echo lang('credit_invoice') ?>"></i>
                        <?php }
                        if ($doc->is_read_only == 1) { ?>
                            &nbsp;<i class="fa fa-read-only" title="<?php echo lang('read_only') ?>"></i>
                        <?php }; ?>
                    </span>
                </td>

                <td>
                    <a href="<?php echo site_url('invoices/view/' . $doc->{get_method_name('id')}); ?>" title="<?php echo lang('edit'); ?>">
                        <?php echo $doc->{get_method_name('number')}; ?>
                    </a>
                </td>

                <td>
                    <?php echo date_from_mysql($doc->{get_method_name('date_created')}); ?>
                </td>

                <td>
                    <?php echo $doc->user_name; ?><br /><span class="small"><i>(<?php echo $doc->user_company; ?>)</i></span>
                </td>

                <td>
                    <span class="<?php if ($doc->is_overdue) { ?>font-overdue<?php } ?>">
                        <?php echo date_from_mysql($doc->{get_method_name('date_due')}); ?>
                    </span>
                </td>

                <td>
                    <a href="<?php echo site_url('clients/view/' . $doc->client_id); ?>" title="<?php echo lang('view_client'); ?>">
                        <?php echo $doc->client_name; ?>
                    </a>
                </td>

                <td class="amount <?php if ($doc->invoice_sign == '-1') { echo 'text-danger'; }; ?>">
                    <?php echo format_currency($doc->{get_method_name('total')}); ?>
                </td>

                <td class="amount">
                    <?php echo format_currency($doc->{get_method_name('balance')}); ?>
                </td>

                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($doc->is_read_only != 1) { ?>
                                <li>
                                    <a href="<?php echo site_url('invoices/view/' . $doc->{get_method_name('id')}); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="<?php echo site_url('invoices/generate_pdf/' . $doc->{get_method_name('id')}); ?>" target="_blank">
                                    <i class="fa fa-print fa-margin"></i> <?php echo lang('download_pdf'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('mailer/invoice/' . $doc->{get_method_name('id')}); ?>">
                                    <i class="fa fa-send fa-margin"></i> <?php echo lang('send_email'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="invoice-add-payment"
                                   data-invoice-id="<?php echo $doc->{get_method_name('id')}; ?>"
                                   data-invoice-balance="<?php echo $doc->{get_method_name('balance')}; ?>"
                                   data-invoice-payment-method="<?php echo $doc->payment_method; ?>">
                                    <i class="fa fa-money fa-margin"></i> <?php echo lang('enter_payment'); ?>
                                </a>
                            </li>
                            <?php if ($doc->invoice_status_id == 1 || ($this->config->item('enable_invoice_deletion') === TRUE && $doc->is_read_only != 1)) { ?>
                                <li>
                                    <a href="<?php echo site_url('invoices/delete/' . $doc->{get_method_name('id')}); ?>" onclick="return confirm('<?php echo lang('delete_invoice_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>
</div>
