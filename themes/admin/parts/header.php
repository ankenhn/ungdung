<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="author" content="coder.notepad@gmail.com" />
    <title><?php echo $this->settings_lib->item('site.title') ?><?php echo isset($toolbar_title) ? ' - '.$toolbar_title  : ''; ?></title>

    <?php echo Assets::css(array('css/styles.css')); ?>
    <!--[if IE]> <link href="<?php echo Template::theme_url('css/ie.css'); ?>" rel="stylesheet" type="text/css"> <![endif]-->
    <?php Assets::add_js(array('js/jquery.js','js/jquery-ui.js'),'external',TRUE); ?>
    <?php Assets::add_js(array('plugins/forms/jquery.mousewheel.js',
        'plugins/tables/jquery.dataTables.js',
        'plugins/tables/TableTools.js',
        'plugins/tables/jquery.sortable.js',
        'plugins/forms/autogrowtextarea.js',
        'plugins/forms/jquery.uniform.js',
        'plugins/forms/jquery.tagsinput.min.js',
        'plugins/forms/jquery.validationEngine-en.js',
        'plugins/forms/jquery.validationEngine.js',
        'plugins/ui/jquery.collapsible.min.js',
        'plugins/ui/jquery.jgrowl.js',
        'plugins/ui/jquery.easytabs.min.js',
        'plugins/ui/jquery.progress.js',
        'plugins/ui/jquery.fakecrop.js',
        'plugins/ui/jquery.mCustomScrollbar.js',
        'files/bootstrap.js',
        'files/functions.js',
        'plugins/plupload/plupload.full.min.js'
    )); ?>
    <script type="text/javascript">
        function cbo_Selected(id,value)
        {
            var obj=document.getElementById(id);
            if(obj) {
                for(i=0;i<obj.length;i++) {
                    if(obj[i].value==value)
                        obj.selectedIndex=i;
                }

            }
        }
    </script>
</head>
<body>