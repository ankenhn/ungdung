<html>
<head>
    <title><?php echo $heading; ?></title>
    <style type="text/css">
        html, body {
            margin:0px;
            padding:0px;
        }
        body {
            background:url('<?php echo site_url('assets/images/background.png'); ?>');
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 22px;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <?php echo $message; ?>
</body>
</html>