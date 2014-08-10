<?php:
	include_once "common/connection.php";
	$pageTitle = "Part-B Questions";
	include_once "common/header.php";


	if(isset($_SESSION['LoggedIn']) && isset($_SESSION['UserID'])):
		include_once "inc/class.questPapers.inc.php";
		$questPaper = new QuestionPapers($db);
		if($_SERVER['REQUEST_METHOD'] == 'POST'):
			if($questPaper->createQuestion() == TRUE) {
				header("Location: viewPaper.php?qp_no=".$_SESSION['questPaperNo']);
				//echo "<div class='message good'>Question Paper successfully created.</div>";
				exit;
			}
			else {
				echo "<div class='error'>Unable to create new question. Please try again.</div>";
			}
		endif;
		if(($numPartA = $questPaper->getTotalQuestions("A")) == FALSE):
			echo "<div class='error'>An error occurred. Please try again.</div>";
		else:
			$startPartB = (int)$numPartA + 1;
			$total = (int)$numPartA + 5;
		
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

	.sub-hint {
	    margin-left: 40px;
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
			function getInputBox(boxId) {
				var inputBox = $('<input>', {
				 type:'text',
				 placeholder: "Please enter a question",
				 name: boxId,
				 id: boxId,
				 class:'inputBox'
				}).css('margin-right', '20px');
				return inputBox;
			}
			function getSelectBox(boxId) {
				var selectBox = $('<select>', {
				 name: boxId,
				 id: boxId
				}).css('width', '180px');
				var options = [
				 {val : "", text : 'Select the unit/chapter', selected:'selected', disabled:'disabled'},
				 {val : 1, text : 'Unit I'},
				 {val : 2, text : 'Unit II'},
				 {val : 3, text : 'Unit III'},
				 {val : 4, text : 'Unit IV'},
				 {val : 5, text : 'Unit V'}
				]; 
				$(options).each(function() {
					selectBox.append('<option value="'+ this.val + '">' + this.text + '</option>');
				}); 
				return selectBox;
			}
			function getLabel(labelFor, labelText, fontSize) {	
				var label = $('<label>', {
				 for: labelFor
				}).text(labelText).css('fontSize', fontSize);
				return label;
			}
			function getAddDivButton(btnHref, btnClass) {
				var addDivButton = $('<button>', {
				 href : btnHref,
				 class: btnClass,
				 text : 'Add subDivision'
				});
				return addDivButton;
			}
			function getSubDiv(divId) {
				var subdiv = $('<div>', {
				 id: divId
				}).css({"display": "none", "margin-left": "40px"});
				return subdiv;
			}
			for (var i = <?php echo $startPartB ?>; i <= <?php echo $total ?>; i ++) {
				var subDivA = getSubDiv('collapse' + i + 'a');
				var subDivB = getSubDiv('collapse' + i + 'b');	
				$(subDivA).append(getLabel('Q'+i+'a1', 'Q.'+i+'.a(i)', '16px')).append(getInputBox('Q'+i+'a1').css('margin-left', '40px')).append("<br/><br/>").append(getSelectBox('unit'+i+'a1')).append("<br/><br/>").append(getLabel('Q'+i+'a2', 'Q.'+i+'.a(ii)', '16px')).append(getInputBox('Q'+i+'a2').css('margin-left', '40px')).append("<br/><br/>").append(getSelectBox('unit'+i+'a2')).append("<br/><br/>");
				$(subDivB).append(getLabel('Q'+i+'b1', 'Q.'+i+'.b(i)', '16px')).append(getInputBox('Q'+i+'b1').css('margin-left', '40px')).append("<br/><br/>").append(getSelectBox('unit'+i+'b1')).append("<br/><br/>").append(getLabel('Q'+i+'b2', 'Q.'+i+'.b(ii)', '16px')).append(getInputBox('Q'+i+'b2').css('margin-left', '40px')).append("<br/><br/>").append(getSelectBox('unit'+i+'b2')).append("<br/><br/>");
				var addDivAButton = getAddDivButton('#collapse' + i + 'a', 'collapse' + i + 'a');
				var addDivBButton = getAddDivButton('#collapse' + i + 'b', 'collapse' + i + 'b');
				$(".txtBoxesDiv").append(getLabel('Q'+i+'a', 'Q.'+i+'.a', '18px')).append(getInputBox('Q'+i+'a')).append(addDivAButton).append("<br/><br/>").append(getSelectBox('unit'+i+'a')).append("<br/><br/>").append(subDivA);
				$(".txtBoxesDiv").append(getLabel('Q'+i+'b', 'Q.'+i+'.b', '18px')).append(getInputBox('Q'+i+'b')).append(addDivBButton).append("<br/><br/>").append(getSelectBox('unit'+i+'b')).append("<br/><br/>").append(subDivB);
			
			function autocompleteTxtBox(boxName) {
				$('#'+boxName).typeahead({
					name: boxName,
					remote: {
					url: "questionsFinder.php?query=%QUERY",
					beforeSend: function(jqXhr, settings) {
						settings.url = settings.url + "&subcode=<?php echo $_SESSION['subcode'] ?>";
					}}
				}); 
			}
 			autocompleteTxtBox('Q'+i+'a');
			autocompleteTxtBox('Q'+i+'a1');
			autocompleteTxtBox('Q'+i+'a2');
			autocompleteTxtBox('Q'+i+'b');
			autocompleteTxtBox('Q'+i+'b1');
			autocompleteTxtBox('Q'+i+'b2');
			//alert($('#collapse3a').children().children('.tt-hint').attr("disabled")); 
			$('#collapse' + i + 'a').children().children('.tt-hint').addClass('sub-hint'); 
			$('#collapse' + i + 'b').children().children('.tt-hint').addClass('sub-hint'); 
			}	
			$("[class^=collapse]").on('click', {counter: i}, function(e) {
				var collapse_content = $(this).attr('href');
				$(collapse_content).toggle('slow');
				if($(this).prev().attr("disabled")) {
					var txtName = $(this).prev().attr("name");
					$(this).prev().removeAttr("disabled");
					autocompleteTxtBox(txtName);
					$(this).next().next().next().removeAttr("disabled");
				} 
				else { 
					$(this).prev().children().next().typeahead("destroy");
					$(this).prev().attr("disabled", true);
					$(this).next().next().next().attr("disabled", true);
				}
				return false;	
			});
			$("#partBform").validate();
			for (var i = <?php echo $startPartB ?>; i <= <?php echo $total ?>; i ++) {
				$('[name="unit'+i+'"]').rules('add', {
					required : "#Q"+i+":filled",
					messages : {
						required: "Please select the chapter/unit for the question"
					}
		
				});
				$('[name="unit'+i+'a1"]').rules('add', {
					required : "#Q"+i+"a1:filled",
					messages : {
						required: "Please select the chapter/unit for the question"
					}
		
				});
				$('[name="unit'+i+'a2"]').rules('add', {
					required : "#Q"+i+"a2:filled",
					messages : {
						required: "Please select the chapter/unit for the question"
					}
		
				});
			} 
		
		});
	</script>
	<div>
	<h2>Part-B Questions</h2>
	<form method="post" name="partBform" id="partBform">
		<input type="hidden" name="category" value="B" />
		<input type="hidden" name="subcode" value=<?php echo $_SESSION['subcode']; ?> />
		<input type="hidden" name="questPaperNo" value=<?php echo $_SESSION['questPaperNo'] ?> />
		<div class="txtBoxesDiv"></div>
		<input type="submit" class="button" name="submitPartB" id="submitPartB" value="Next" />
	</form>
	</div>

<?php
	endif;
	else:
		header("Location: login.php");
		exit;
	endif;
	
	include_once "common/footer.php";
?>
