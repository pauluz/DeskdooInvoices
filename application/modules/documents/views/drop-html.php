<?php if (empty($col)) { $col = 12; } ?>
<!-- dropzone -->
<div id="actions" class="row col-xs-12 col-sm-<?php echo $col; ?>">
    <div class="col-lg-7"></div>
    <div class="col-lg-5">
        <!-- The global file processing state -->
        <span class="fileupload-process">
            <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
            </div>
        </span>
    </div>

    <div class="table table-striped" class="files" id="previews">

        <div id="template" class="file-row">
            <!-- This is used as the file preview template -->
            <div>
                <span class="preview"><img data-dz-thumbnail/></span>
            </div>
            <div>
                <p class="name" data-dz-name></p>
                <strong class="error text-danger" data-dz-errormessage></strong>
            </div>
            <div>
                <p class="size" data-dz-size></p>

                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
            </div>
            <div>
                <?php if (empty($hide_delete)): ?>
                <button data-dz-remove class="btn btn-danger btn-sm delete">
                    <i class="fa fa-trash-o"></i> <span><?php echo lang('delete'); ?></span>
                </button>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<!-- stop dropzone -->
