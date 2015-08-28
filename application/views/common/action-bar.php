<?php if (!isset($no_view)) { ?>
    <a class="btn btn-success action-btn view <?php __e((isset($view_class) ? $view_class : '')) ?>" 
       data-id="<?php __e($id); ?>" 
       data-cftext="<?php __e(isset($view_text) ? $view_text : "View"); ?>" 
       href="<?php __e((isset($view_url) ? $view_url : "view/" . $id)); ?>">
        <i class="halflings-icon white zoom-in"></i>  
    </a>
<?php } ?>
<?php if (!isset($no_edit)) { ?>
    <a class="btn btn-info action-btn edit <?php __e((isset($edit_class) ? $edit_class : '')) ?>" 
       data-id="<?php __e($id); ?>" 
       title="<?php __e(isset($edit_title) ? $edit_title : "Edit"); ?>" 
       data-cftext="<?php __e(isset($edit_text) ? $edit_text : ""); ?>" 
       href="<?php __e((isset($edit_url) ? $edit_url : "update/" . $id)); ?>">
        <i class="halflings-icon white edit"></i>  
    </a>
<?php } ?>
<?php if (!isset($no_delete)) { ?>
    <a class="btn btn-danger action-btn delete <?php __e((isset($delete_class) ? $delete_class : '')) ?>" 
       data-id="<?php __e($id); ?>" 
       title="<?php __e(isset($delete_title) ? $delete_title : "Delete"); ?>" 
       data-cftext="<?php __e(isset($delete_text) ? $delete_text : ""); ?>" 
       href="<?php __e((isset($delete_url) ? $delete_url : "delete/" . $id)); ?>">
        <i class="halflings-icon white trash"></i> 
    </a>
<?php } ?>
<?php if (isset($save_me)) { ?>
    <a class="btn btn-success action-btn save <?php __e((isset($save_class) ? $save_class : '')) ?>" 
       data-id="<?php __e($id); ?>" 
       title="<?php __e(isset($save_title) ? $save_title : "Save"); ?>" 
       data-cftext="<?php __e(isset($save_text) ? $save_text : ""); ?>" 
       href="<?php __e((isset($save_url) ? $save_url : "save/" . $id)); ?>">
        <i class="fa fa-check"></i>
    </a>
<?php } ?>
<?php if (isset($cancel_me)) { ?>
    <a class="btn btn-danger action-btn cancel <?php __e((isset($cancel_class) ? $cancel_class : '')) ?>" 
       data-id="<?php __e($id); ?>" 
       title="<?php __e(isset($cancel_title) ? $cancel_title : "Cancel"); ?>" 
       data-cftext="<?php __e(isset($cancel_text) ? $cancel_text : ""); ?>" 
       href="<?php __e((isset($cancel_url) ? $cancel_url : "cancel/" . $id)); ?>">
        <i class="fa fa-times"></i>
    </a>
<?php } ?>
<?php __e(isset($extra) ? $extra : ''); ?>