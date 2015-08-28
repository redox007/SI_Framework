<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- start: Meta -->
        <meta charset="utf-8">
        <title><?php __e($title); ?></title>
        <meta name="description" content="<?php __e($meta_description); ?>">
        <meta name="author" content="<?php __e($author); ?>">
        <meta name="keyword" content="<?php __e($meta_keyword); ?>">
        <!-- end: Meta -->

        <!-- start: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- end: Mobile Specific -->

        <!-- start: CSS -->
        <link id="bootstrap-style" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link id="base-style" href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link id="base-style-responsive" href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
        <!-- end: CSS -->


        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <link id="ie-style" href="<?php echo base_url(); ?>assets/css/ie.css" rel="stylesheet">
        <![endif]-->

        <!--[if IE 9]>
                <link id="ie9style" href="<?php echo base_url(); ?>assets/css/ie9.css" rel="stylesheet">
        <![endif]-->

        <!-- start: Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/favicon.ico">
        <!-- end: Favicon -->
        <script type="text/javascript">
            var ajax_url = "<?php echo base_url('ajax'); ?>";
        </script>
        
        <?php load_css('assets/custom/css/style.css'); ?>
        <?php load_css('assets/custom/css/bootstrap-datepicker.min.css'); ?>

        <script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.noty.js"></script>
        
        <?php load_js('assets/custom/js/form-submit.js'); ?>
        <script type="text/javascript">
            function logme(name, tetx) {
                name = name || '';
                tetx = tetx || '';
                console.log(name, tetx);
            }
            function show_noty(msg,type,layout) {
                layout = layout || 'topRight';
                type = type || 'success';
                var ndata = {
                    text: msg,
                    layout: layout,
                    type: type
                };
                logme(ndata.toString());
                $('body button#noty').attr('data-noty-options', JSON.stringify(ndata));
                $('body button#noty').click();
            }
        </script>

        <?php
        if (isset($_auto_load_scripts_head)) {
            foreach ($_auto_load_scripts_head as $script) {
                __e($script);
            }
        }
        ?>

    </head>

    <body class="<?php __e($body_class); ?>">