<?php
	include_once "common/connection.php";
	$pageTitle = "View Question Paper";
	include_once "common/header.php";
	
	if(isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID'])):
		include_once "inc/class.questPapers.inc.php";
		$questPaper = new QuestionPapers($db);
		if(($resultQP = ($questPaper->viewQuestionPaper())) != FALSE):
			if(($resultPartA = ($questPaper->viewQuestions("A"))) != FALSE):
				ob_start();
?>
	<div align="center">
	<h2>B.E / B.Tech DEGREE EXAMINATIONS</h2>
	<h2><?php echo $resultQP['semester'] ?>th SEMESTER - <?php echo $resultQP['department'] ?></h2>
	<h2><?php echo $resultQP['subjectcode'] ?> - <?php echo $resultQP['subject'] ?></h2>
	<h2><?php echo $resultQP['examName'] ?></h2>
	<h2>(2013 - 2014)</h2>
	</div>
	<br /><br />
	<h3 style="float: left;">Time: 1:30 hrs</h3>
	<h3 style="float: right;">Total Marks: <?php echo $resultQP['totalmarks'] ?></h3>
	<br /><br />
	<br /><br />
	<h3 style="float: right;">Marks: (2 X <?php echo count($resultPartA) ?> = <?php echo (2 * count($resultPartA)) ?>)</h3>
	<h3 style="text-align: center;">PART - A</h3>	
	<br/><br/>
<?php
	foreach($resultPartA as $row)
	{
		echo $row['questionNo'].".	".$row['questionText'];
		echo "<br/>";
	}
?>
<?php
			$output = ob_get_clean();
			echo $output;
?>
	<br/><br/>
	<form name="generateForm" id="generateForm" method="post" action="GenerateDoc.php">
	<input type="hidden" name="htmloutput" id="htmloutput" value="<?php echo htmlentities($output, ENT_QUOTES); ?>" />
	<input type="submit" class="button" style="width: 120px;" value="Generate DOC" />
	<input type="submit" class="button" style="width: 120px;" value="Generate PDF" />
	</form>

<?php
			else:
				echo "<div class='error'>Error. Please try again.</div>";
			endif;
		else:
			echo "<div class='error'>Error. Please try again.</div>";
		endif;

	else:
		header("Location: login.php");
		exit;
	endif;

	include_once "common/footer.php";
?>
	
		
