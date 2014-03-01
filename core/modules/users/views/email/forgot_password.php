Dear <?php echo $user->username; ?>,


<br /><br />
Here is your request reset password at <?php echo date('H:i d/m/Y'); ?><br />
Please click <a href="<?php echo $link; ?>" target="_blank">here</a> to confirm<br />
Or follow link: <?php echo $link; ?>
<br /><br />
Do remember to check through your profile to make sure your details are correct.
<br /><br />
<br />
Thanks,
<br />
<?php echo settings_item('site.title'); ?>
