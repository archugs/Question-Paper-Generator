<?php

	include_once "common/connection.php";
	$pageTitle = "Sign Up";
	include_once "common/header.php";

	//define error variables and initialize with empty values
	$useridErr = $nameErr = $passwordErr = $retypepassErr = $collegenameErr = $collegeaddressErr = "";
	$userid = $username = $password = $retypepassword = $collegename = $collegeaddress = "";
	$validate = false;

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$validate = true;
		if(empty($_POST['userid'])) {
			$useridErr = "Please enter a userID";
			$validate = false;
		}
		else {
			$userid = $_POST['userid'];
		}
	
		if(empty($_POST['username'])) {
			$nameErr = "Please enter the username";
			$validate = false;
		}
		else {
			$username = $_POST['username'];
		}

		if(empty($_POST['password'])) {
			$passwordErr = "Please enter a password";
			$validate = false;
		}
		else {
			$password = $_POST['password'];
		}
		
		if(empty($_POST['retypepassword'])) {
			$retypepassErr = "Please re-type password";
			$validate = false;
		}
		elseif($_POST['retypepassword'] != $_POST['password']) {
			$retypepassErr = "Passwords don't match";
		}

		if(empty($_POST['collegename'])) {
			$collegenameErr = "Please enter the college name";
			$validate = false;
		}
		else {
			$collegename = $_POST['collegename'];
		}

		if(empty($_POST['collegeaddress'])) {
			$collegeaddressErr = "Please enter the college address";
			$validate = false;
		}
		else {
			$collegeaddress = $_POST['collegeaddress'];
		}
	}
	
	if($validate === true) {
		include_once "inc/class.users.inc.php";
		$users = new Users($db);
		if($users->createAccount() == TRUE)
			echo "<div class='message good'>User has been successfully created</div>";
		else {
			$validate = false;
			$useridErr = "UserID already exists. Please choose another.";
		}
	}
		
	if($validate === false):
?>

		<h2>Sign Up</h2> <br />
		<form method="post" action="signup.php" id="signupform">
			<div>
				<label for="userid">UserID</label>
				<input type="text" name="userid" id="userid" value="<?php echo htmlspecialchars($userid);?>" /> 
				<span class="error"><?php echo $useridErr;?></span><br /><br />
				<label for="username">Username</label>
				<input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username);?>" /> 
				<span class="error"><?php echo $nameErr;?></span><br /><br />
				<label for="password">Password</label>
				<input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password);?>" />
				<span class="error"><?php echo $passwordErr;?></span> <br /><br />
				<label for="retypepassword">Re-type Password</label>
				<input type="password" name="retypepassword" id="retypepassword" value="<?php echo htmlspecialchars($retypepassword);?>" /> 
				<span class="error"><?php echo $retypepassErr;?></span> <br/><br/>
				<label for="collegename">College Name</label>
				<input type="text" name="collegename" id="collegename" value="<?php echo htmlspecialchars($collegename);?>" />
				<span class="error"><?php echo $collegenameErr;?></span> <br /><br />
				<label for="collegeaddress">College Address</label>
				<input type="textbox" name="collegeaddress" id="collegeaddress" value="<?php echo htmlspecialchars($collegeaddress);?>" /> 
				<span class="error"><?php echo $collegeaddressErr;?></span> <br /><br />
				<input type="submit" name="signup" id="signup" value="Sign Up" />
			</div>
		</form>
<?php 
	endif;
	
	include_once "common/footer.php";
?>
