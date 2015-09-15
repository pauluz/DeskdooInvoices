<div class="<?php echo $class; ?>">
    <?php echo pager(site_url($mdl_document . '/status/' . $this->uri->segment(3)), 'mdl_' . $mdl_document); ?>
</div>

<div class="<?php echo $class; ?>">
    <ul class="nav nav-pills index-options">
        <?php foreach (array_merge(array(0 => array('label' => lang('all'), 'class' => 'all', 'href' => $mdl_document . '/status/all')), $document_statuses) as $status): ?>
            <li <?php if ($status['class'] == $document_status) { ?>class="active"<?php } ?>>
                <a href="<?php echo site_url($status['href']); ?>"><?php echo $status['label']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
