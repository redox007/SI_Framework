<div class="search-bar">
    <form method="get" class="form-inline" id="search-form">
        <div class="form-control">
            <input type="text" name="s" value="<?php __echeck( isset($search_type) AND $search_type == request('search_type') , request('s') , '' ); ?>" />
            <input type="hidden" name="search_type" value="<?php __e(isset($search_type) ? $search_type : '', 'basic'); ?>" />
            <?php __e(isset($extra_params) ? $extra_params : ''); ?>
            <button type="submit" class="btn btn-primary" name="submit_search">Search</button>  
        </div>
    </form>
</div>
