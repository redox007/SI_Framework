<script type="text/javascript">
    jQuery(function ($) {
        $('body').on('aj_form_submitted', '#register_form_id_tonege .ajax-form', function (e, data) {
            logme('DATA', data);
            var l = $('#tonege-box table.list-table tbody tr').last().attr('class');
            var oe = (l == 'odd') ? 'even' : 'odd';
            $('#tonege-box table.list-table tbody').append('<tr id="list-tonege-' + data.object.id + '" class="' + oe + '"><td>' + data.object.id + '</td><td>' + data.object.name + '</td></tr>');
        });
        $('body').on('click', '#tonege-box table.list-table tbody tr a.delete', function (e) {
            e.preventDefault();
            var tr = $(this).parent().parent();
            var link = $(this).attr('href');
            $.get(link, {}, function (data) {
                if (data.success) {
                    tr.detach();
                }
                show_noty(data.msg, ((data.success) ? 'success' : 'error'));
            });
        });
    });
</script>
