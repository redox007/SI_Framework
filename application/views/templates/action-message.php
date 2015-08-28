<?php if (isset($msg)) { ?>
    <div class="message" id="message">
        <div class="alert alert-<?php echo $class; ?>">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <?php echo $msg; ?>
        </div>
    </div>
<?php } ?>
