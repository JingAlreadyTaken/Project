<html>
<head>
<title>My Form</title>
</head>
<body>

<?php echo validation_errors(); ?>

<?php echo form_open('form'); ?>



<h5>Old Password</h5>
<input type="text" name="oldpassword" value="" size="50" />

<h5>New Password</h5>
<input type="text" name="newpassword" value="" size="50" />

<h5>Confirm Password</h5>
<input type="text" name="confpassword" value="" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>