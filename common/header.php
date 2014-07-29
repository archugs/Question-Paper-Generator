<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  

        <title> Question Paper Setter | <?php echo $pageTitle ?> </title>

        <link rel="stylesheet" href="style.css" type="text/css" />
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

	<link rel="icon" type="image/x-icon" href="favicon.ico" />
	<script src="js/jquery.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="font-awesome-4.1.0/css/font-awesome.min.css">
</head>

<body>
        <div id="page-wrap">
                <div id="header">
                        <h1><a href="index.php">Question Paper Setter</a></h1>
                        <div id="control">
                        <?php 
				if (isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID']) && $_SESSION['LoggedIn'] == 1):
			?>
                                <p><a href="settings.php" class="button">Settings</a> 
                                <a href="logout.php" class="button">Log out</a></p>
                        <?php else: ?>
                                <p><a href="signup.php" class="button">Sign Up</a>
                                &nbsp;
                                <a href="login.php" class="button">Log in</a></p>
			<?php endif; ?>
                        </div>
                </div>                                                      
