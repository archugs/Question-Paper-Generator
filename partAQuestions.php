<?php:
	include_once "common/connection.php";
	$pageTitle = "Part-A Questions";
	include_once "common/header.php";


	if(isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID'])):
		if($_SERVER['REQUEST_METHOD'] == 'POST'):
			include_once "inc/class.questPapers.inc.php";
			$questPaper = new QuestionPapers($db);
			if($questPaper->createQuestion() == TRUE) {
				header("Location: partBQuestions.php");
			//	echo "<div class='message good'>Question Paper successfully created.</div>";
				exit;
			}
			else {
				echo "<div class='error'>Unable to create new question. Please try again.</div>";
			}
		endif;
?>
	<style>
	.tt-hint,.inputBox  {
        	border: 2px solid #CCCCCC;
	    border-radius: 8px 8px 8px 8px;
	    font-size: 17px; 
	    height: 12px; 
	    line-height: 30px; 
	    outline: medium none; 
	    padding: 8px 12px; 
	    width: 600px;
	    margin-left: 30px;
	}  

	.tt-dropdown-menu {
	  width: 400px;
	  margin-top: 5px;
	  padding: 8px 12px; 
	  background-color: #fff;
	  border: 1px solid #ccc;
	  border: 1px solid rgba(0, 0, 0, 0.2);
	  border-radius: 8px 8px 8px 8px;
	  font-size: 17px;
	  color: #111;
	  background-color: #F1F1F1;
	}

	</style>

	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/typeahead.js"></script>
	<script type="text/javascript" src="http://jquery.bassistance.de/validate/jquery.validate.js"></script>
	<script type="text/javascript" src="http://jquery.bassistance.de/validate/additional-methods.js"></script>
	<script>
		$(document).ready(function() {
			for (var i = 1; i <= 10; i ++) {
				var label = $('<label>', {
				 for:'Q' + i
				}).text('Q.'+i).css('fontSize', '18px');
				var inputBox = $('<input>', {
				 type:'text',
				 placeholder: "Please enter a question",
				 name:'Q' + i,
				 id:'Q' + i,
				 class:'inputBox'
				}); 
				var options = [
				 {val : "", text : 'Select the unit/chapter', selected:'selected', disabled:'disabled'},
				 {val : 1, text : 'Unit I'},
				 {val : 2, text : 'Unit II'},
				 {val : 3, text : 'Unit III'},
				 {val : 4, text : 'Unit IV'},
				 {val : 5, text : 'Unit V'}
				]; 
				var selectBox = $('<select>', {
				 name:'unit'+i,
				 id:'unit'+i
				}).css('width', '180px');
				$(options).each(function() {
					selectBox.append('<option value="'+ this.val + '">' + this.text + '</option>');
				});
				$(".txtBoxesDiv").append(label).append(inputBox).append("<br/><br/>").append(selectBox).append("<br/><br/>");
 
			$('#Q'+i).typeahead({
				name: 'Q'+i,
				remote: {
				url: "questionsFinder.php?query=%QUERY",
				beforeSend: function(jqXhr, settings) {
					settings.url = settings.url + "&subcode=<?php echo $_SESSION['subcode'] ?>";
				}}
			}); 
		 	}	
			$("#partAform").validate();
			for(var i = 1; i <= 10; i ++) {
				$('[name="unit'+i+'"]').rules('add', {
					required : "#Q"+i+":filled",
					messages : {
						required: "Please select the chapter/unit for the question"
					}
		
				});
			} 
		
		});
	</script>
	<div>
	<h2>Part-A Questions</h2>
	<form method="post" name="partAform" id="partAform">
		<input type="hidden" name="category" value="A" />
		<input type="hidden" name="subcode" value=<?php echo $_SESSION['subcode']; ?> />
		<input type="hidden" name="questPaperNo" value=<?php echo $_SESSION['questPaperNo'] ?> />
		<div class="txtBoxesDiv"></div>
		<input type="submit" class="button" name="submitPartA" id="submitPartA" value="Next" />
	</form>
	</div>

<?php
	else:
		header("Location: login.php");
		exit;
	endif;
	
	include_once "common/footer.php";
?>
