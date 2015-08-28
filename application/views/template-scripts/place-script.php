<script type="text/javascript">
    jQuery(function ($) {
        $('body').on('aj_form_submitted', '#country-state-city .ajax-form', function () {
            $.get(ajax_url, {action: 'get_state_country'}, function (data) {
                if (data.success) {
                    var country_html = data.country_html;
                    $('select[name="state[country]"]').html($(country_html).html());
                    $('select[name="city[country]"]').html($(country_html).html());
                    var state_html = data.states_html;
                    $('select[name="city[state]"]').html($(state_html).html());
                }
            });
        });

        $('body').on('click', '.ajax-edit', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.get(url, {}, function (data) {
                $('#popModel .modal-header h3').html("Edit");
                $('#popModel .modal-body').html($(data).html());
                $('#popModel').modal();
            });
        });
        $('body').on('aj_form_submitted', '#popModel .ajax-form', function (e, data) {
            $('#popModel button.close').trigger('click');
            if (data) {
                var type = data.type;
                var id = data.id;
                var up_data = data.updated_data;
                for (var key in up_data) {
                    if (up_data.hasOwnProperty(key)) {
                        $('td#' + type + '-' + id + '-' + key).html(up_data[key]);
                        logme('td#' + type + '-' + id + '-' + key + " -> " + up_data[key]);
                    }
                }
            }

        });
        $('body').on('click', '.ajax-delete', function (e) {
            var tda = $(this);
            var a = confirm('Do you want to delete it?');
            if (a) {
                var url = $(this).attr('href');
                $.get(url, {}, function (data) {
                    var type = (data.success) ? 'success' : 'error';
                    show_noty(data.msg, type);
                    tda.parent('td').parent('tr').detach();
                });
            }
            e.preventDefault();

        });
    });
</script>
