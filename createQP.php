<?php
include_once "common/connection.php";
$pageTitle = "Create New Question Paper";
include_once "common/header.php";


$examErr = $subcodeErr = $subErr = $semErr = $deptErr = $marksErr = $dateErr = "";
$examname = $subcode = $subject = $semester = $dept = $marks = $date = "";

if(isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID'])):
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		//define error variables and initialize with empty values
		$validate = true;
		if(empty($_POST['examname'])) {
			$examErr = "Please enter the name of the Examination";
			$validate = false;
		}
		else {
			$examname = $_POST['examname'];
		}

		if(empty($_POST['subcode'])) {
			$subcodeErr = "Please enter a subject code";
			$validate = false;
		}
		else {
			$subcode = $_POST['subcode'];
		}

		if(empty($_POST['subject'])) {
			$subErr = "Please enter a subject title";
			$validate = false;
		}
		else {
			$subject = $_POST['subject'];
		}

		if(empty($_POST['semester'])) {
			$semErr = "Please select a semester";
			$validate = false;
		}
		else {
			$semester = $_POST['semester'];
		}

		if(empty($_POST['department'])) {
			$deptErr = "Please select a department";
			$validate = false;
		}
		else {
			$department = $_POST['department'];
		}

		if(empty($_POST['totalmarks'])) {
			$marksErr = "Please enter the total marks for the question paper";
			$validate = false;
		}
		else if($_POST['totalmarks'] <= 0 || $_POST['totalmarks'] > 100) {
			$marksErr = "Total marks should be between 1 and 100";
			$validate = false;
		}
		else {
			$marks = $_POST['totalmarks'];
		}

		if($validate === true) {
			include_once "inc/class.questPapers.inc.php";
			$questPapers = new QuestionPapers($db);
			if(($questPaperNo = ($questPapers->createQuestionPaper())) != FALSE) {
				$_SESSION['questPaperNo'] = $questPaperNo;
				$_SESSION['subcode'] = $_POST['subcode'];
				header("Location: partAQuestions.php");
				exit;
			}
			else {
				$validate = false;
				echo "<div class='message error'>There was an error creating your question Paper. Please try again.</div>";
			}

		}
	}
?>
	<script>
		$(function() {
			$("#datepicker").datepicker().datepicker("setDate", new Date());
		});
	</script>
	<h2> Create New Question Paper </h2>
	<br />
	<div id="main">
	<form method="POST" action="createQP.php" name="createQPform" id="createQPform">
	<div>
		<label for="examname">Examination Name</label>	
		<input type="text" name="examname" id="examname" value="<?php echo htmlspecialchars($examname);?>" />
		<span class="error"><?php echo $examErr;?></span><br /><br />
		<label for="subcode">Subject Code</label>
		<input type="text" name="subcode" id="subcode" value="<?php echo htmlspecialchars($subcode);?>" />
		<span class="error"><?php echo $subcodeErr;?></span><br /><br />
		<label for="subject">Subject</label>
		<input type="text" name="subject" id="subject" value="<?php echo htmlspecialchars($subject);?>" />
		<span class="error"><?php echo $subErr;?></span><br /><br />
		<label for="semester">Semester</label>
		<select name="semester" id="semester">
		<option value="" disabled="disabled" selected="selected">Please select a value</option>
		<option value="1">1st Semester</option>
		<option value="2">2nd Semester</option>
		<option value="3">3rd Semester</option>
		<option value="4">4th Semester</option>
		<option value="5">5th Semester</option>
		<option value="6">6th Semester</option>
		<option value="7">7th Semester</option>
		<option value="8">8th Semester</option>
		</select>
		<span class="error"><?php echo $semErr;?></span><br /><br />
		<label for="department">Department</label>
		<select name="department" id="department">
		<option value="" disabled="disabled" selected="selected">Please select a value</option>
		<option value="CSE">CSE</option>
		<option value="IT">IT</option>
		<option value="ECE">ECE</option>
		<option value="EEE">EEE</option>
		<option value="Civil">Civil</option>
		<option value="Mech">Mech</option>
		<option value="Aero">Aero</option>
		</select>
		<span class="error"><?php echo $deptErr;?></span>
		<br /><br />
		<label for="totalmarks">Total Marks</label>
		<input type="text" name="totalmarks" id="totalmarks" value="<?php echo htmlspecialchars($marks);?>" />
		<span class="error"><?php echo $marksErr;?></span><br /><br />
		<label for="datepicker">Date</label>
		<input type="text" name="datepicker" id="datepicker"><br /><br />
		<span class="error"><?php echo $dateErr;?></span><br />
		<input type="submit" class="button" name="submitQP" id="submitQP" value="Next" />
	</div>
	</form>

<?php

else:
	header("Location: login.php");
	exit;
endif;
?>

</div>

<?php include_once "common/footer.php"; ?>
