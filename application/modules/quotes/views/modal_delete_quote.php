<script type="text/javascript">
    $(function () {
        $('#modal_delete_confirm').click(function () {
            document_id = $(this).data('document-id');
            window.location = '<?php echo site_url('quotes/delete'); ?>/' + document_id;
        });
    });
</script>

<div id="delete-modal" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog" aria-labelledby="delete-modal" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>

            <h3><?php echo lang('delete_quote'); ?></h3>
        </div>
        <div class="modal-body">
            <p class="alert alert-danger"><?php echo lang('delete_quote_warning'); ?></p>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <a href="#" id="modal_delete_confirm" class="btn btn-danger" data-document-id="<?php echo $quote->quote_id; ?>">
                    <i class="fa fa-trash-o"></i> <?php echo lang('confirm_deletion'); ?>
                </a>

                <a href="#" class="btn btn-success" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo lang('no'); ?>
                </a>
            </div>
        </div>
    </div>
</div>