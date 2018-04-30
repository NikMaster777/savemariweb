<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo lib::getSetting('General_CompanyName'); ?> - Admin Control Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw=" crossorigin="anonymous"></script> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/admin/templates/default/stylesheets/stylesheet.css"/>
</head>

<body style="background:#333;">

<div class="container login-window">
	<div class="row">
    	<div class="col-lg-12">
        	<center><img src="<?php echo DOMAIN; ?>/admin/templates/default/images/logo.png" width="264" height="123" /></center>
        	<div class="panel panel-default">
            	<div class="panel-heading">Administrator Login</div>
                <div class="panel-body">
                	<?php if(@$message) { ?>
                    <div class="alert alert-danger">
                    	<span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $message; ?>
                    </div>
                    <?php } ?>
                	<form action="" method="post" class="form">
                    	<?php echo session::setBotTrap(); //@Bot Traps ?>
                    	<div class="form-group">
                        	<label>Username:</label>
                            <input type="text" value="<?php echo lib::post('user_username',false,true,true); ?>" placeholder="Username..." name="user_username" class="form-control"/>
                        </div>
                        <div class="form-group">
                        	<label>Password:</label>
                            <input type="password" value="<?php echo lib::post('user_password',false,true,true); ?>" placeholder="Password..." name="user_password" class="form-control"/>
                        </div>
                        <div class="form-group">
                        	<input type="submit" value="Login" name="_submit" class="btn btn-default"/>
                        </div>
                    </form>
                </div>
            </div>
            <center><p class="copyright">&copy; <a href="https://www.creativemiles.co.uk">Creative Miles</a>. All rights reserved.</p></center>
        </div>
    </div>
</div>

</body>
</html>