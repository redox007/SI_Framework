<div class="row-fluid">
    <div class="span6">
        <?php if (isset($city_list)) load_view('list', 'common', $city_list); ?>   
    </div>
    <div class="span6">
        <?php if (isset($state_list)) load_view('list', 'common', $state_list); ?>   
    </div>
    <div class="span6">
        <?php if (isset($country_list)) load_view('list', 'common', $country_list); ?>  
    </div>
</div>
<?php load_view('pop-box', 'common', array('modal_header' => '', 'modal_content' => '')); ?>  
