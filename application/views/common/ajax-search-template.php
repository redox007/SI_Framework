<div class="form-control">
    <input type="text" 
           name="s" 
           id="search-input"
           class="search-box ajax-search" 
           data-result="<?php __e(isset($result_box) ? $result_box : ''); ?>" 
           data-search_type="<?php __e(isset($search_type) ? $search_type : 'basic'); ?>" 
           data-action="<?php __e(isset($ajax_action) ? $ajax_action : ''); ?>"
           value="<?php __e(( $search_type == request('search_type') ? request('s') : '')) ?>" />
    <button type="button" class="btn btn-primary search-button" name="submit_search">Search</button>  
</div>