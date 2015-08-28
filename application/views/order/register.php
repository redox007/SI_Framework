<div class="row-fluid">
    <div class="box span6">
        <div class="box-header" data-original-title="">
            <h2><i class="halflings-icon edit"></i><span class="break"></span><?php __e($panel_heading); ?></h2>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="<?php __e($booking_action); ?>" method="post" enctype="multipart/form-data">
                <fieldset> 
                    <div class="control-group">
                        <label class="control-label" for="passenger_name">Passenger</label>
                        <div class="controls">
                            <input type="text" name="passenger_name" class="input-xlarge"  id="passenger_name" value="<?php __e(__rd('passenger_name', $data_object) ? __rd('passenger_name', $data_object) : request('passenger_name')); ?>">
                            <input type="hidden" name="booking[passenger_id]" id="passenger_id" value="<?php __efd('passenger_id', $data_object); ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="pickup-addr">Pickup </label>
                        <div class="controls">
                            <input type="text" name="booking[pickup_address]" class="input-xlarge"  id="pickup-addr" value="<?php __efd('pickup_address', $data_object); ?>">
                            <input type="hidden" name="booking[pickup_lat]" class="lat" value="<?php __efd('pickup_lat', $data_object); ?>"/>
                            <input type="hidden" name="booking[pickup_long]" class="long" value="<?php __efd('pickup_long', $data_object); ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="bdrop-addr">Drop </label>
                        <div class="controls">
                            <input type="text" name="booking[drop_address]" class="input-xlarge"  id="drop-addr" value="<?php __efd('drop_address', $data_object); ?>">
                            <input type="hidden" name="booking[drop_lat]" class="lat" value="<?php __efd('drop_lat', $data_object); ?>" />
                            <input type="hidden" name="booking[drop_long]" class="long" value="<?php __efd('drop_long', $data_object); ?>" />
                        </div>
                    </div>
                    <!--                    <div class="control-group">
                                            <label class="control-label" for="drop-addr">Booking Type </label>
                                            <div class="controls">
                                                <div class="radio-box">
                    <?php __e(form_radio('booking[booking_type]', 1, (__rd('booking_type', $data_object) == 1), 'class="booking_type" id="booking_type1"')); ?> 
                                                    <label for="booking_type1">Fixed </label>
                                                </div>
                                                <div class="radio-box">
                    <?php __e(form_radio('booking[booking_type]', 2, (__rd('booking_type', $data_object) == 2), 'class="booking_type" id="booking_type2"')); ?> 
                                                    <label for="booking_type2">Recurring</label>
                                                </div>
                                            </div>
                                        </div>-->
                    <div class="control-group">
                        <label class="control-label" for="dates">Dates </label>
                        <div class="controls">
                            <?php
                            $dates = __rd('booking_date', $data_object);
                            if ($dates && is_array($dates)) {
                                $i = 1;
                                foreach ($dates as $key => $date) {
                                    ?>
                                    <div class="input-append <?php __echeck($i > 1, 'added-dates', ''); ?>">
                                        <input type="text" name="booking[booking_date][<?php __e($key); ?>]" class="input-xlarge book_dates datepicker" value="<?php __e($date); ?>">
                                        <button class="btn <?php __echeck(count($dates) > 1, '', 'hideme') ?>  <?php __echeck($i > 1, 'minus-date', '') ?>" 
                                                id="add_date" 
                                                data-order_id='<?php __echeck(isset($action) AND $action == 'update', $key, ''); ?>'
                                                type="button">  <?php __echeck($i == 1, '+', '-') ?> </button>
                                    </div>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <div class="input-append">
                                    <input type="text" name="booking[booking_date][]" class="input-xlarge book_dates datepicker" value="">
                                    <button class="btn" id="add_date" type="button"> + </button>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="dates">Pickup Time </label>
                        <div class="controls">
                            <input id="timepicker" class="form-control <?php __echeck(__rd('pickup_type', $data_object) == 2, 'hideme', ''); ?>"  value="<?php __efd('booking_time', $data_object); ?>" name="booking[booking_time]" data-provide="timepicker" data-template="modal" data-minute-step="1" data-modal-backdrop="true" type="text"/>
                            <?php __e(form_checkbox('booking[pickup_type]', 2, (__rd('pickup_type', $data_object) == 2), 'id="is_flexi"')); ?>Flexible
                            <div class="<?php __echeck(__rd('pickup_type', $data_object) == 1 OR __rd('pickup_type', $data_object) === FALSE, 'hideme', ''); ?>" id="timeframe">
                                <?php
                                foreach ($timeframes as $timeframe) {
                                    $tf = date('h a', strtotime($timeframe['start'])) . ' - ' . date('h a', strtotime($timeframe['end']));
                                    __e(form_radio('booking[flexible_timeslot]', $timeframe['id'], ( __rd('flexible_timeslot', $data_object) == $timeframe['id']), "id='Timeframe" . $timeframe['id'] . "'"));
                                    ?>
                                    <label for="<?php __e("Timeframe{$timeframe['id']}") ?>"><?php __e($tf . "( {$timeframe['discount']}% OFF )"); ?></label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php if($action == 'update'){?>
                    <div class="control-group">
                        <label class="control-label" for="special_type">Booking Status </label>
                        <div class="controls">
                            <?php __e(form_dropdown('booking[booking_status]', $booking_statuses,  __rd('booking_status', $data_object))); ?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="control-group">
                        <label class="control-label" for="special_type">Special Type </label>
                        <div class="controls">
                            <?php __e(form_dropdown('booking[special_type]', $special_types, __rd('special_type', $data_object), 'id="special_type" ')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="capacity_type">Capacity Type </label>
                        <div class="controls">
                            <?php __e(form_dropdown('booking[capacity_type]', $capacity_types, __rd('capacity_type', $data_object), 'id="capacity_type" ')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city">City </label>
                        <div class="controls">
                            <?php __e(form_dropdown('booking[city]', $cities, __rd('city', $data_object), 'id="city" ')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="state">State </label>
                        <div class="controls">
                            <?php __e(form_dropdown('booking[state]', $states, __rd('state', $data_object), 'id="state" ')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="no_of_helpers">No of Helpers </label>
                        <div class="controls">
                            <input type="number" name="booking[no_of_helpers]" class="input-xlarge"  id="no_of_helpers" value="<?php __efd('no_of_helpers', $data_object); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="pin">Pin Code </label>
                        <div class="controls">
                            <input type="text" name="booking[pin]" class="input-xlarge" id="pin"  value="<?php __efd('pin', $data_object); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="estimated_cost">Estimated Cost </label>
                        <div class="controls">
                            <input type="text" name="booking[estimated_cost]" class="input-xlarge" id="no_of_helpers" value="<?php __efd('estimated_cost', $data_object); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="estimated_distance">Estimated distance </label>
                        <div class="controls">
                            <input type="text" name="booking[estimated_distance]" class="input-xlarge" id="no_of_helpers" value="<?php __efd('estimated_distance', $data_object); ?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="delete_orders" value="" />
                        <input type="hidden" name="action" value="<?php __e($action, 'insert'); ?>" />
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <!--<button type="reset" class="btn">Cancel</button>-->
                    </div>
                </fieldset>
            </form>   
        </div>
    </div><!--/span-->
    <div class="box span6">
        <div class="box-header" data-original-title="">
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Map</h2>
        </div>
        <div class="box-content">  
            <div id="map-canvas" class="map-view">

            </div>
            <div id="direction-panel">

            </div>
        </div>
    </div><!--/span-->
</div>
<script type="text/javascript">

    $(function () {
        $('#passenger_name').autocomplete({
            serviceUrl: '<?php echo base_url('ajax/get_passengers'); ?>',
            onSelect: function (suggestion) {
                $('#passenger_id').val(suggestion.data);
//                alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
            },
            paramName: 's'
        });
        $('body').on('aj_form_submitted', '.ajax-form', function (e, response, form) {
            alert('form_submitted');
            logme(response);
        });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#add_date').click(function (e) {
            e.preventDefault();
            var inp = $(this).parent().first().clone();

            inp.addClass('added-dates').find('.book_dates').val('');
            inp.find('button').html('-').attr('id', '').attr('data-order_id','').addClass('minus-date');

            $(this).parent().parent().append(inp);
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
//        $('.booking_type').change(function () {
//            if ($(this).val() == 2) {
//                $('#add_date').removeClass('hideme');
//                $('.added-dates').removeClass('hideme');
//                $('.added-dates').each(function(){
//                    $(this).find('input[name="booking[booking_date][]"]').removeAttr('disabled');
//                });
//            } else {
//                $('#add_date').addClass('hideme');
//                $('.added-dates').each(function(){
//                    $(this).addClass('hideme');
//                    $(this).find('input[name="booking[booking_date][]"]').attr('disabled','disabled');
//                });
//            }
//        });
        $('body').on('click','.minus-date',function (e) {
            e.preventDefault();
            var a = $('input[name="delete_orders"]').val();
            var ar = (a) ? a.split(',') : [];
            var ard = $(this).data('order_id');
            if (ard) {
                ar.push(ard);
                $('input[name="delete_orders"]').val(ar.join(','));
            }
            $(this).parent().detach();
        });
    });
</script>

