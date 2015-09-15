<script type="text/javascript">

    $(function () {

<?php $this->layout->load_view('documents/add_product_and_row.js'); ?>

<?php if (!$items) { ?>
        // pZ: brak Items - więc dodaje pusty wiersz
        add_row_function();
<?php } ?>

        $('#doc_change_client').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_change_client'); ?>", {
                invoice_id: <?php echo $invoice_id; ?>,
                client_name: "<?php echo $this->db->escape_str($invoice->client_name); ?>"
            });
        });

        $('#btn_create_recurring').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_create_recurring'); ?>", {invoice_id: <?php echo $invoice_id; ?>});
        });

        $('#btn_save_doc').click(function () {
            var items = [];
            var item_order = 1;
            $('table tbody.item').each(function () {
                var row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        row[$(this).attr('name')] = $(this).val();
                    }
                });
                row['item_order'] = item_order;
                item_order++;
                items.push(row);
            });
            $.post("<?php echo site_url('invoices/ajax/save'); ?>", {
                    invoice_id: <?php echo $invoice_id; ?>,
                    invoice_number: $('#invoice_number').val(),
                    invoice_date_created: $('#invoice_date_created').val(),
                    invoice_date_due: $('#invoice_date_due').val(),
                    invoice_status_id: $('#invoice_status_id').val(),
                    invoice_password: $('#invoice_password').val(),
                    items: JSON.stringify(items),
                    invoice_discount_amount: $('#invoice_discount_amount').val(),
                    invoice_discount_percent: $('#invoice_discount_percent').val(),
                    invoice_terms: $('#invoice_terms').val(),
                    payment_method: $('#payment_method').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                    if (response.success == '1') {
                        window.location = "<?php echo site_url('invoices/view'); ?>/" + <?php echo $invoice_id; ?>;
                    }
                    else {
                        $('#fullpage-loader').hide();
                        $('.control-group').removeClass('has-error');
                        $('div.alert[class*="alert-"]').remove();
                        var resp_errors = response.validation_errors,
                            all_resp_errors = '';
                        for (var key in resp_errors) {
                            $('#' + key).parent().addClass('has-error');
                            all_resp_errors += resp_errors[key];
                        }
                        $('#invoice_form').prepend('<div class="alert alert-danger">' + all_resp_errors + '</div>');
                    }
                });
        });

        $('#btn_generate_pdf').click(function () {
            window.open('<?php echo site_url('invoices/generate_pdf/' . $invoice_id); ?>', '_blank');
        });

<?php if ($invoice->is_read_only != 1): ?>
        var fixHelper = function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width())
            });
            return $helper;
        };

        $("#item_table").sortable({
            items: 'tbody',
            helper: fixHelper
        });
<?php endif; ?>

    });

</script>

<?php
    echo $modal_delete_doc;

    if ($this->config->item('disable_read_only') == TRUE) {
        $invoice->is_read_only = 0;
    }
?>

<div id="headerbar">
    <h1><?php echo lang('invoice'); ?> <?php echo $invoice->invoice_number; ?></h1>

    <div class="pull-right <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) { ?>btn-group<?php } ?>">

        <div class="options btn-group pull-left">
            <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                <?php echo lang('options'); ?> <i class="fa fa-caret-down no-margin"></i>
            </a>
            <ul class="dropdown-menu">
<?php /* pZ:
                <li>
                    <a href="#" id="btn_create_credit" data-invoice-id="<?php echo $invoice_id; ?>">
                        <i class="fa fa-minus fa-margin"></i> <?php echo lang('create_credit_invoice'); ?>
                    </a>
                </li>
*/ ?>
                <li>
                    <a href="#" class="invoice-add-payment"
                       data-invoice-id="<?php echo $invoice_id; ?>"
                       data-invoice-balance="<?php echo $invoice->invoice_balance; ?>"
                       data-invoice-payment-method="<?php echo $invoice->payment_method; ?>">
                        <i class="fa fa-credit-card fa-margin"></i>
                        <?php echo lang('enter_payment'); ?>
                    </a>
                </li>
                <li>
                    <a href="#" id="btn_generate_pdf"
                       data-invoice-id="<?php echo $invoice_id; ?>">
                        <i class="fa fa-print fa-margin"></i>
                        <?php echo lang('download_pdf'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>">
                        <i class="fa fa-send fa-margin"></i>
                        <?php echo lang('send_email'); ?>
                    </a>
                </li>
                <li class="divider"></li>
<?php /* pZ:
                <li>
                    <a href="#" id="btn_create_recurring" data-invoice-id="<?php echo $invoice_id; ?>">
                        <i class="fa fa-repeat fa-margin"></i>
                        <?php echo lang('create_recurring'); ?>
                    </a>
                </li>
*/ ?>
                <li>
                    <a href="#" id="btn_copy_invoice"
                       data-invoice-id="<?php echo $invoice_id; ?>">
                        <i class="fa fa-copy fa-margin"></i>
                        <?php echo lang('copy_invoice'); ?>
                    </a>
                </li>
                <?php if ($invoice->invoice_status_id == 1 || ($this->config->item('enable_invoice_deletion') === TRUE && $invoice->is_read_only != 1)) { ?>
                    <li>
                        <a href="#delete-modal" data-toggle="modal">
                            <i class="fa fa-trash-o fa-margin"></i>
                            <?php echo lang('delete'); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <?php if ($invoice->is_read_only != 1): ?>
        <a href="#" class="btn_add_row btn btn-sm btn-default">
            <i class="fa fa-plus"></i> <?php echo lang('add_new_row'); ?>
        </a>
        <a href="#" class="btn_add_product btn btn-sm btn-default">
            <i class="fa fa-database"></i> <?php echo lang('add_product'); ?>
        </a>
        <?php endif; ?>
        <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4): ?>
        <a href="#" class="btn btn-sm btn-success ajax-loader" id="btn_save_doc">
            <i class="fa fa-check"></i> <?php echo lang('save'); ?>
        </a>
        <?php endif; ?>
    </div>

    <div class="invoice-labels pull-right">
        <?php if ($invoice->invoice_is_recurring) { ?>
            <span class="label label-info"><?php echo lang('recurring'); ?></span>
        <?php } ?>
        <?php if ($invoice->is_read_only == 1) { ?>
            <span class="label label-danger">
                <i class="fa fa-read-only"></i> <?php echo lang('read_only'); ?>
            </span>
        <?php } ?>
    </div>

</div>

<div id="content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <form novalidate name="invoice_form" id="invoice_form" class="form-horizontal" ng-controller="ProductsListCtrl">

        <div class="invoice">

            <div class="cf row">

                <div class="col-xs-12 col-md-5">
                    <div class="pull-left">
                        <?php $this->layout->load_view('documents/user-info', array('status_id_field' => 'invoice_status_id')); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-md-7">

                    <div class="details-box">

                        <div class="row">

                            <?php if ($invoice->invoice_sign == -1) { ?>
                                <div class="col-xs-12">
                                <span class="label label-warning">
                                    <i class="fa fa-credit-invoice"></i>&nbsp;
                                    <?php echo lang('credit_invoice_for_invoice') . ' ';
                                    echo anchor('/invoices/view/' . $invoice->creditinvoice_parent_id,
                                        $invoice->creditinvoice_parent_id) ?>
                                </span>
                                </div>
                            <?php } ?>

                            <div class="col-xs-12 col-sm-6">

                                <div class="invoice-properties">
                                    <label><?php echo lang('invoice'); ?> #</label>
                                    <input type="text" id="invoice_number" class="input-sm form-control" value="<?php echo $invoice->invoice_number; ?>"
                                        <?php if ($invoice->is_read_only == 1) {
                                            echo 'disabled="disabled"';
                                        } ?>>
                                </div>

                                <div class="invoice-properties has-feedback">
                                    <label><?php echo lang('date'); ?></label>
                                    <div class="input-group">
                                        <input name="invoice_date_created" id="invoice_date_created"
                                               class="form-control datepicker"
                                               value="<?php echo date_from_mysql($invoice->invoice_date_created); ?>"
                                            <?php if ($invoice->is_read_only == 1) {
                                                echo 'disabled="disabled"';
                                            } ?>>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="invoice-properties has-feedback">
                                    <label><?php echo lang('due_date'); ?></label>
                                    <div class="input-group">
                                        <input name="invoice_date_due" id="invoice_date_due"
                                               class="form-control datepicker"
                                               value="<?php echo date_from_mysql($invoice->invoice_date_due); ?>"
                                            <?php if ($invoice->is_read_only == 1) {
                                                echo 'disabled="disabled"';
                                            } ?>>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">

                                <div class="invoice-properties">
                                    <label><?php echo lang('status');
                                        if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) {
                                            echo ' <span class="small">(' . lang('can_be_changed') . ')</span>';
                                        }
                                        ?>
                                    </label>
                                    <select name="invoice_status_id" id="invoice_status_id"
                                            class="form-control"
                                        <?php if ($invoice->is_read_only == 1 && $invoice->invoice_status_id == 4) {
                                            echo 'disabled="disabled"';
                                        } ?>>
                                        <?php foreach ($invoice_statuses as $key => $status) { ?>
                                            <option value="<?php echo $key; ?>"
                                                    <?php if ($key == $invoice->invoice_status_id) { ?>selected="selected"<?php } ?>>
                                                <?php echo $status['label']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="invoice-properties">
                                    <label><?php echo lang('invoice_password'); ?></label>
                                    <input type="text" id="invoice_password" class="input-sm form-control" value="<?php echo $invoice->invoice_password; ?>" <?php if ($invoice->is_read_only == 1) { echo 'disabled="disabled"'; } ?>>
                                </div>

                                <div class="invoice-properties">
                                    <label><?php echo lang('payment_method'); ?></label>
                                    <select name="payment_method" id="payment_method" class="form-control"
                                        <?php if ($invoice->is_read_only == 1 && $invoice->invoice_status_id == 4) {
                                            echo 'disabled="disabled"';
                                        } ?>>
                                        <option value=""><?php echo lang('select_payment_method'); ?></option>
                                        <?php foreach ($payment_methods as $payment_method) { ?>
                                            <option <?php if ($invoice->payment_method == $payment_method->payment_method_id) echo "selected" ?>
                                                value="<?php echo $payment_method->payment_method_id; ?>">
                                                <?php echo $payment_method->payment_method_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->layout->load_view('invoices/partial_item_table'); ?>

            <hr/>

            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <label><?php echo lang('invoice_terms'); ?></label>
                    <textarea id="invoice_terms" name="invoice_terms" class="input-sm form-control" rows="3" <?php if ($invoice->is_read_only == 1) { echo 'disabled="disabled"'; } ?>>
                        <?php echo $invoice->invoice_terms; ?>
                    </textarea>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <label class="control-label"><?php echo lang('attachments'); ?></label>
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-default fileinput-button">
                        <i class="fa fa-plus"></i> <span><?php echo lang('add_files'); ?></span>
                    </span>
                    <?php $this->layout->load_view('documents/drop-html', array('col' => 12, 'hide_delete' => ($invoice->is_read_only == 1))); ?>
                </div>
            </div>

            <?php if ($invoice->invoice_status_id != 1) { ?>
                <p class="padded">
                    <?php echo lang('guest_url'); ?>:
                    <?php echo auto_link(site_url('guest/view/generate_invoice_pdf/' . $invoice->invoice_url_key)); ?>
                </p>
            <?php } ?>

        </div>

    </form>

</div>
<?php $this->layout->load_view('documents/drop-script', array('document' => 'invoice')); ?>
