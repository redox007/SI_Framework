<script type="text/javascript">
    jQuery(function ($) {
        $('#special-type-box a.action-btn.cancel').click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $(this).addClass('hideme');


            $('#special-type-' + id + '-name').find('input[name="spl_name"]').addClass('hideme');
            var html = $('#special-type-' + id + '-name').find('span.spl-name').html();
            $('#special-type-' + id + '-name').find('input[name="spl_name"]').val(html);
            $('#special-type-' + id + '-name').find('span.spl-name').removeClass('hideme');


            $(this).parent().find('a.save').addClass('hideme');
            $(this).parent().find('a.cancel').addClass('hideme');
            $(this).parent().find('a.edit').removeClass('hideme');
        });
        $('#special-type-box a.action-btn.edit').click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $(this).addClass('hideme');

            $('#special-type-' + id + '-name').find('input[name="spl_name"]').removeClass('hideme');
            $('#special-type-' + id + '-name').find('span.spl-name').addClass('hideme');
            $(this).parent().find('a.save').removeClass('hideme');
            $(this).parent().find('a.cancel').removeClass('hideme');
        });

        $('#special-type-box a.action-btn.save').click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = $(this).attr('href');
            var thS = $(this);
            var spl_name = $('#special-type-' + id + '-name').find('input[name="spl_name"]').val();

            $.post(url, {name: spl_name, spl_id: id}, function (data) {
                logme(data);
                $('#special-type-' + id + '-name').find('span.spl-name').removeClass('hideme');
                $('#special-type-' + id + '-name').find('span.spl-name').html(data.name);
                $('#special-type-' + id + '-name').find('input[name="spl_name"]').addClass('hideme');
                $('#special-type-' + id + '-name').find('input[name="spl_name"]').val(data.name);
                thS.parent().find('a.save').addClass('hideme');
                thS.parent().find('a.cancel').addClass('hideme');
                thS.parent().find('a.edit').removeClass('hideme');
                
                show_noty(data.msg, ((data.success) ? 'success' : 'error'));
            });
        });
    });
</script>