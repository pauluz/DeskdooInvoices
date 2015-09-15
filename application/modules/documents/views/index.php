<div id="headerbar">
    <h1><?php echo lang($mdl_document); ?></h1>

    <div class="pull-right">
        <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg" data-toggle="collapse" data-target="#ip-submenu-collapse">
            <i class="fa fa-bars"></i> <?php echo lang('submenu'); ?>
        </button>
        <?php // pZ: szybki workaround
            $cll = 'create-' . substr($mdl_document, 0, -1);
        ?>
        <a class="<?php echo $cll ?> btn btn-sm btn-primary" href="#"><i class="fa fa-plus"></i> <?php echo lang('new'); ?></a>
    </div>

    <?php $this->layout->load_view('documents/submenu', array('class' => 'pull-right visible-lg')); ?>
</div>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">
        <?php $this->layout->load_view('documents/submenu', array('class' => 'submenu-row')); ?>
    </div>
</div>

<div id="content" class="table-content">
    <div id="filter_results">
        <?php if ($mdl_document == 'quotes'): ?>
            <?php $this->layout->load_view('quotes/partial_quote_table', array('quotes' => $documents)); ?>
        <?php else: ?>
            <?php $this->layout->load_view('documents/partial_document_table', array('documents' => $documents, 'mdl_document' => $mdl_document)); ?>
        <?php endif; ?>
    </div>
</div>
