<?php
include_once "common/connection.php";
$pageTitle = "HOME";
include_once "common/header.php";
?>

<div id="main">
	
<?php
if(isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID'])):
?>
<div style="width:300px; height:400px; margin:150px auto;">
<a class="button1" href="createQP.php">Create Question Paper</a><br />
<a class="button1" href="ViewQP.php">View Previous Question Papers</a><br />
<a class="button1" href="QuestionBank.php">View Question Bank</a><br />
</div>
<?php
else:
	header("Location: login.php");
	exit;
endif;
?>


