<?php
	include_once "common/connection.php";
	include_once "inc/constants.inc.php";

	if (! is_object($db)) {
		$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
		$db = new PDO($dsn, DB_USER, DB_PASS);
	}

	if(isset($_REQUEST['query'])) {
		$query = $_REQUEST['query'];
		$sql = $db->prepare('SELECT * FROM questions WHERE questionText LIKE ? AND subjectcode = ?');
		$sql->execute(array("%$query%", $_GET['subcode']));
		$array = array();
		while($row = $sql->fetch()) {
			$array[] = $row['questionText'];
		}
/*		$array = array();
		while($row = mysql_fetch_assoc($sql)) {
			$array[] = $row['questionText'];
		} */
		echo json_encode($array);
	}
?>
