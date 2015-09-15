<script type="text/javascript">

    $(function () {

<?php $this->layout->load_view('documents/add_product_and_row.js'); ?>

<?php if (!$items) { ?>
        // pZ: brak Items - więc dodaje pusty wiersz
        add_row_function();
<?php } ?>

        $('#doc_change_client').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_change_client'); ?>", {
                quote_id: <?php echo $quote_id; ?>,
                client_name: "<?php echo $this->db->escape_str($quote->client_name); ?>"
            });
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
            $.post("<?php echo site_url('quotes/ajax/save'); ?>", {
                    quote_id: <?php echo $quote_id; ?>,
                    quote_number: $('#quote_number').val(),
                    quote_date_created: $('#quote_date_created').val(),
                    quote_date_expires: $('#quote_date_expires').val(),
                    quote_status_id: $('#quote_status_id').val(),
                    quote_password: $('#quote_password').val(),
                    items: JSON.stringify(items),
                    quote_discount_amount: $('#quote_discount_amount').val(),
                    quote_discount_percent: $('#quote_discount_percent').val(),
                    notes: $('#notes').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                    if (response.success == '1') {
                        window.location = "<?php echo site_url('quotes/view'); ?>/" + <?php echo $quote_id; ?>;
                    }
                    else {
                        $('.control-group').removeClass('error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().parent().addClass('error');
                        }
                    }
                });
        });

        $('#btn_generate_pdf').click(function () {
            window.open('<?php echo site_url('quotes/generate_pdf/' . $quote_id); ?>', '_blank');
        });

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

    });

</script>

<?php
    echo $modal_delete_doc;
?>

<div id="headerbar">
    <h1><?php echo lang('quote'); ?> <?php echo $quote->quote_number; ?></h1>

    <div class="pull-right btn-group">

        <div class="options btn-group pull-left">
            <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                <?php echo lang('options'); ?> <i class="fa fa-caret-down no-margin"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" id="btn_generate_pdf"
                       data-quote-id="<?php echo $quote_id; ?>">
                        <i class="fa fa-print fa-margin"></i>
                        <?php echo lang('download_pdf'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('mailer/quote/' . $quote->quote_id); ?>">
                        <i class="fa fa-send fa-margin"></i>
                        <?php echo lang('send_email'); ?>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#" id="btn_quote_to_invoice"
                       data-quote-id="<?php echo $quote_id; ?>">
                        <i class="fa fa-refresh fa-margin"></i>
                        <?php echo lang('quote_to_invoice'); ?>
                    </a>
                </li>
                <li>
                    <a href="#" id="btn_copy_quote"
                       data-quote-id="<?php echo $quote_id; ?>">
                        <i class="fa fa-copy fa-margin"></i>
                        <?php echo lang('copy_quote'); ?>
                    </a>
                </li>
                <li>
                    <a href="#delete-modal" data-toggle="modal">
                        <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                    </a>
                </li>
            </ul>
        </div>

        <a href="#" class="btn_add_row btn btn-sm btn-default">
            <i class="fa fa-plus"></i> <?php echo lang('add_new_row'); ?>
        </a>
        <a href="#" class="btn_add_product btn btn-sm btn-default">
            <i class="fa fa-database"></i> <?php echo lang('add_product'); ?>
        </a>

        <a href="#" class="btn btn-sm btn-success ajax-loader" id="btn_save_doc">
            <i class="fa fa-check"></i> <?php echo lang('save'); ?>
        </a>
    </div>

</div>

<div id="content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <form id="quote_form" class="form-horizontal">

        <div class="quote">

            <div class="cf row">

                <div class="col-xs-12 col-md-5">
                    <div class="pull-left">
                        <?php $this->layout->load_view('documents/user-info', array('status_id_field' => 'quote_status_id')); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-md-7">

                    <div class="details-box">

                        <div class="row">

                            <div class="col-xs-12 col-sm-6">

                                <div class="quote-properties">
                                    <label for="quote_number"><?php echo lang('quote'); ?> #</label>
                                    <div class="controls">
                                        <input type="text" id="quote_number" class="form-control input-sm" value="<?php echo $quote->quote_number; ?>">
                                    </div>
                                </div>

                                <div class="quote-properties has-feedback">
                                    <label for="quote_date_created"><?php echo lang('date'); ?></label>
                                    <div class="input-group">
                                        <input name="quote_date_created" id="quote_date_created"class="form-control input-sm datepicker" value="<?php echo date_from_mysql($quote->quote_date_created); ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="quote-properties has-feedback">
                                    <label for="quote_date_expires">
                                        <?php echo lang('expires'); ?>
                                    </label>
                                    <div class="input-group">
                                        <input name="quote_date_expires" id="quote_date_expires"
                                               class="form-control input-sm datepicker"
                                               value="<?php echo date_from_mysql($quote->quote_date_expires); ?>">
                                      <span class="input-group-addon">
                                          <i class="fa fa-calendar fa-fw"></i>
                                      </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">

                                <div class="quote-properties">
                                    <label for="quote_status_id">
                                        <?php echo lang('status'); ?>
                                    </label>
                                    <select name="quote_status_id" id="quote_status_id"
                                            class="form-control input-sm">
                                        <?php foreach ($quote_statuses as $key => $status) { ?>
                                            <option value="<?php echo $key; ?>"
                                                    <?php if ($key == $quote->quote_status_id) { ?>selected="selected"<?php } ?>>
                                                <?php echo $status['label']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="quote-properties">
                                    <label for="quote_password">
                                        <?php echo lang('quote_password'); ?>
                                    </label>

                                    <div class="controls">
                                        <input type="text" id="quote_password" class="form-control input-sm"
                                               value="<?php echo $quote->quote_password; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->layout->load_view('quotes/partial_item_table'); ?>

            <hr/>

            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <label class="control-label"><?php echo lang('notes'); ?></label>
                    <textarea id="notes" name="notes" class="input-sm form-control" rows="3">
                        <?php echo $quote->notes; ?>
                    </textarea>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <label class="control-label"><?php echo lang('attachments'); ?></label>
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-default fileinput-button">
                        <i class="fa fa-plus"></i> <span><?php echo lang('add_files'); ?></span>
                    </span>
                    <?php $this->layout->load_view('documents/drop-html', array('col' => 12)); ?>
                </div>
            </div>

            <?php if ($quote->quote_status_id != 1) { ?>
                <p class="padded">
                    <?php echo lang('guest_url'); ?>:
                    <?php echo auto_link(site_url('guest/view/generate_quote_pdf/' . $quote->quote_url_key)); ?>
                </p>
            <?php } ?>

        </div>

    </form>

</div>
<?php $this->layout->load_view('documents/drop-script', array('document' => 'quote')); ?>
