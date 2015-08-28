<script type="text/javascript">
    jQuery(function ($) {
        $('#timeframe-box a.action-btn.cancel').click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $(this).addClass('hideme');

            $(this).parent().parent().find('input.inputter').addClass('hideme');
            var html = $(this).parent().siblings().each(function (i, el) {
                var html = $(el).find('span.htvalue').html();
                $(el).find('input.inputter').val(html);
            });

            $(this).parent().parent().find('span.htvalue').removeClass('hideme');

            $(this).parent().find('a.save').addClass('hideme');
            $(this).parent().find('a.cancel').addClass('hideme');
            $(this).parent().find('a.edit').removeClass('hideme');
        });
        $('#timeframe-box a.action-btn.edit').click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $(this).addClass('hideme');

            $(this).parent().parent().find('input.inputter').removeClass('hideme');
            $(this).parent().parent().find('span.htvalue').addClass('hideme');

            $(this).parent().find('a.save').removeClass('hideme');
            $(this).parent().find('a.cancel').removeClass('hideme');
        });
        $('#timeframe-box a.action-btn.save').click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = $(this).attr('href');
            var thS = $(this);

            var params = {
                time_id: id
            };

            $(this).parent().siblings().each(function (i, el) {
                var html = $(el).find('span.htvalue').html();
                var name_attr = $(el).find('input.inputter').attr('name');
                var val = $(el).find('input.inputter').val();
                params[name_attr] = val;

            });

//            var spl_name = $('#timeframe-' + id + '-name').find('input[name="spl_name"]').val();

            $.post(url, params, function (data) {
                logme(data);

                for (var key in data.time) {
                    if (data.time.hasOwnProperty(key)) {
                        thS.parent().parent().find('td#timeframe-'+id+'-'+key+' input[name="time['+key+']"]').addClass('hideme');
                        thS.parent().parent().find('td#timeframe-'+id+'-'+key+' span.htvalue').html(data.time[key]);
                        thS.parent().parent().find('td#timeframe-'+id+'-'+key+' span.htvalue').removeClass('hideme');
                    }
                }

                thS.parent().find('a.save').addClass('hideme');
                thS.parent().find('a.cancel').addClass('hideme');
                thS.parent().find('a.edit').removeClass('hideme');

                show_noty(data.msg, ((data.success) ? 'success' : 'error'));
            });
        });
    });
</script>