<?php
	include_once "common/connection.php";
	$pageTitle = "View Question Paper";
	include_once "common/header.php";
	
	if(isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID'])):
		include_once "inc/class.questPapers.inc.php";
		$questPaper = new QuestionPapers($db);
		if(($resultQP = ($questPaper->viewQuestionPaper())) != FALSE):
			if((($resultPartA = ($questPaper->viewQuestions("A"))) != FALSE) && (($resultPartB = ($questPaper->viewQuestions("B"))) != FALSE)):
				$totalPartB = $questPaper->getTotalQuestions("B");
				ob_start();
?>
	<style>
	@page { margin: 2cm 2cm 2cm 2cm; } 
	</style>
	<div align="center">
	<h2>B.E / B.Tech DEGREE EXAMINATIONS</h2>
	<h2><?php echo $resultQP['semester'] ?>th SEMESTER - <?php echo $resultQP['department'] ?></h2>
	<h2><?php echo $resultQP['subjectcode'] ?> - <?php echo $resultQP['subject'] ?></h2>
	<h2><?php echo $resultQP['examName'] ?></h2>
	<h2>(2013 - 2014)</h2>
	</div>
	<br /><br />
	<div>
	<table width="100%">
	<tr style="height: 30px;">
	<td width="30%"><h3>Time: 1:30 hrs</h3></td>
	<td width="40%"></td>
	<td width="30%"><h3>Total Marks: <?php echo $resultQP['totalmarks'] ?></h3></td>
	</tr>
	<tr style="height: 30px;">
	<td width="30%"></td>
	<td width="40%"><h3>PART - A</h3></td>
	<td width="30%"><h3>Marks: (2 X <?php echo count($resultPartA) ?> = <?php echo (2 * count($resultPartA)) ?>)</h3></td>
	</tr>
	</table>	
<?php
	foreach($resultPartA as $row)
	{
		echo $row['questionNo'].".	".$row['questionText'];
		echo "<br/>";
	}
?>
	<br /><br />
	<table width="100%">
	<tr style="height: 30px;">
	<td width="30%"></td>
	<td width="40%"><h3>PART - B</h3></td>
	<td width="30%"><h3>Marks: (16 X <?php echo $totalPartB ?> = <?php echo (16 * $totalPartB) ?>)</h3>
	</td>
	</tr>
	</table>	
<?php
	foreach($resultPartB as $row) 
	{
		echo $row['questionNo'].".	".$row['questionText'];
		echo "<br/>";
	}
			$output = ob_get_clean();
			echo $output;
?>
	<br/><br/>
	</div>
	<script>
		function submitForm(action)
		{
			document.getElementById('generateForm').action = action;
			document.getElementById('generateForm').submit();
		}
	</script>
	<form name="generateForm" id="generateForm" method="post">
	<input type="hidden" name="htmloutput" id="htmloutput" value="<?php echo htmlentities($output, ENT_QUOTES); ?>" />
	<input type="button" class="button" style="width: 120px;" value="Generate DOC" onclick="submitForm('generateDoc.php')" />
	<input type="button" class="button" style="width: 120px;" value="Generate PDF" onclick="submitForm('generatePDF.php')" />
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
	
		
