<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" />
    <meta name="author" content="coder.notepad@gmail.com" />
    <meta name="title" content="<?php echo isset($toolbar_title) ? $toolbar_title : settings_item('site.title'); ?>" />
    <meta name="description" content="<?php echo isset($metaDescription) ? $metaDescription : settings_item('meta.description'); ?>" />
    <meta name="keyword" content="<?php echo isset($metaKeyword) ? $metaKeyword : settings_item('meta.keyword'); ?>" />
    <meta name="ROBOTS" content="index, follow" />
    <title><?php echo isset($toolbar_title) ? ' - '.$toolbar_title  : ''; ?><?php echo settings_item('site.title'); ?></title>
    <?php echo Assets::css(array('css/styles.css')); ?>
    <?php Assets::add_js(array('js/jquery.js'),'external',TRUE); ?>

</head>
<body>