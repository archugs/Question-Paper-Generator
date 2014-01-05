<?php
$filename = "QuestionPaper.doc";
header('Content-disposition: attachment;filename="QuestionPaper.doc"');
header("Content-type: application/msword");
header("Content-Transfer-Encoding: binary");
$htmlheader = "<HTML><HEAD><TITLE>QuestionPaper.doc</TITLE>
        <link rel='stylesheet' href='style.css' type='text/css' />
	</HEAD> <BODY>";
$htmlfooter = "</BODY>
	<style>
	@page { margin: 2cm 2cm 2cm 2cm; }
	</style>
	\n </HTML>";
$content = $htmlheader.$_POST['htmloutput'].$htmlfooter;
echo $content;
?>
