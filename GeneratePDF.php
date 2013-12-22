<?php

require_once "dompdf/dompdf_config.inc.php";

$dompdf = new DOMPDF();

$dompdf->load_html($_POST['htmloutput']);
$dompdf->render();
$dompdf->stream("QuestionPaper.pdf");
//$output = $dompdf->output();
//file_put_contents("~/sample.pdf", $output);

?>
