<?php
	include_once "common/connection.php";
	$pageTitle = "View Question Paper";
	include_once "common/header.php";
	
	if(isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID'])):
		include_once "inc/class.questPapers.inc.php";
		$questPaper = new QuestionPapers($db);
		if(($resultQP = ($questPaper->viewQuestionPaper($_GET['qp_no']))) != FALSE):
			if((($resultPartA = ($questPaper->viewQuestions($_GET['qp_no'], "A"))) != FALSE) && (($resultPartB = ($questPaper->viewQuestions($_GET['qp_no'], "B"))) != FALSE)):
				$totalPartB = $questPaper->getTotalQuestions($_GET['qp_no'], "B");
				ob_start();
?>
	<style>
	@page { margin: 2cm 2cm 2cm 2cm; } 
	</style>
	<div id="qp-content">
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
		echo "<p>".$row['questionNo'].".	".$row['questionText']."</p>";
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
		if(preg_match('/b$/', $row['questionNo']) || preg_match('/b1$/', $row['questionNo']))
		{
			echo "<p>";
			for($i = 0; $i <= 50; $i ++)
			{
				echo "&nbsp;";
			}
			echo "(OR)</p><br/>";
		}
		if(preg_match('/2$/', $row['questionNo']))
		{
			echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;(ii).'." ".$row['questionText'].'</p>';
		}
		else if(preg_match('/1$/', $row['questionNo']))
		{
			preg_match('/a|b/', $row['questionNo'], $matches, PREG_OFFSET_CAPTURE);
			echo "<p>".substr($row['questionNo'], 0, $matches[0][1]).".(".substr($row['questionNo'], $matches[0][1], 1).")"."<br/>"."&nbsp;&nbsp;&nbsp;&nbsp;(i)".$row['questionText']."</p>";
		}
		else
		{
			preg_match('/a|b/', $row['questionNo'], $matches, PREG_OFFSET_CAPTURE);
			echo "<p>".substr($row['questionNo'], 0, $matches[0][1]).".(".substr($row['questionNo'], $matches[0][1], 1).")"." ".$row['questionText']."</p>";
		}
		echo "<br/>";
		if(preg_match('/b$/', $row['questionNo']) || preg_match('/b2$/', $row['questionNo']))
		{
			echo "<br/>";
		}

	}
			$output = ob_get_clean();
			echo $output;
?>
	<br/><br/>
	</div>
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
	<input type="button" class="button" value="Generate DOC" onclick="submitForm('generateDoc.php')" />
	<input type="button" class="button" value="Generate PDF" onclick="submitForm('generatePDF.php')" />
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
	
		
