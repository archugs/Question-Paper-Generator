<?php
	include_once "common/connection.php";
	$pageTitle = "Log In";
	include_once "common/header.php";

	if(isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID'])):
?>
	<p>You are currenly <strong>logged in.</strong></p>
	<p><a href="logout.php">Log out</a></p>
<?php
	elseif(isset($_POST['userid']) && isset($_POST['password'])):
		include_once 'inc/class.users.inc.php';
		$users = new Users($db);
		if($users->accountLogin() == TRUE):
			echo "<meta http-equiv='refresh' content='0;index.php' />";
			exit;
		else:
?>
	<h4 class="bad">Login failed&mdash;Try Again?</h4>
	<br />
	<form method="post" action="login.php" name="loginform" id="loginform">
		<div>
			<label for="userid">UserID</label>
			<input type="text" name="userid" id="userid" />
			<br /><br />
			<label for="password">Password</label>
			<input type="password" name="password" id="password" />
			<br /><br />
			<input type="submit" name="login" id="login" value="Login" class="button" />
		</div>
	</form>

<?php
		endif;
	else:
?>

	<h4>Please login to continue</h4>
	<br />
	<form method="post" action="login.php" name="loginform" id="loginform">
		<div>
			<label for="userid">UserID</label>
			<input type="text" name="userid" id="userid" />
			<br /><br />
			<label for="password">Password</label>
			<input type="password" name="password" id="password" />
			<br /><br />
			<input type="submit" name="login" id="login" value="Login" class="button" />
		</div>
	</form><br /><br />

<?php
	endif;
?>
		<div style="clear: both;"></div>
<?php
	include_once "common/footer.php";
?>
	
