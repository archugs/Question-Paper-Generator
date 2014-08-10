<?php

/* Handles user interactions within the app */

class QuestionPapers
{
	/**
	 *  The database object 
	 * @var object
	 */
	private $_db;

	/** 
	 * Checks for a database object and creates one if none is found
	 * @param object $db
	 * @return void
         */
	public function __construct($db = NULL)
	{
		if (is_object($db))
		{
			$this->_db= $db;
		}

		else
		{
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
			$this->_db = new PDO($dsn, DB_USER, DB_PASS);
		}
	}
	
	/** Retrieves the total number of questions in PART-A or PART-B.
	 * @param string $category - PART-A or PART-B category
	 * @return - number of PART-A/PART-B questions in the question paper OR FALSE otherwise.		
  	*/
	public function getTotalQuestions($questPaperNo, $category)
	{
		if($category == "A")
		{
			$sql = "SELECT COUNT(*) AS Count
				FROM questions a
				INNER JOIN questPapers_questions b
				ON a.questionid = b.questionid
				WHERE a.marks = 2
				AND b.questPaperNo = :questPaperNo";
		}
		else
		{
			$sql = "SELECT COUNT(DISTINCT (SUBSTR(a.questionNo, 1, 1))) AS Count
				FROM questions a
				INNER JOIN questPapers_questions b
				ON a.questionid = b.questionid
				WHERE a.marks <> 2
				AND b.questPaperNo = :questPaperNo";
		}
		if($stmt = $this->_db->prepare($sql))
		{
			$stmt->bindParam(":questPaperNo", $questPaperNo, PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch();
			$stmt->closeCursor();
			return $row['Count'];
		}

		return FALSE;
	}

	/** 
	 * Adds a new question paper to the database.
	 * @return ID of the new question paper on success, FALSE on failure.
	 */
	public function createQuestionPaper()
	{
	
		$sql = "INSERT INTO questPapers(userid, examName, department, subjectcode, subject, semester, totalmarks, date) VALUES(:userid, :examname, :department, :subjectcode, :subject, :semester, :totalmarks, STR_TO_DATE(:date, '%m/%d/%Y'))";
		if($stmt = $this->_db->prepare($sql)) {
			$stmt->bindParam(":userid", $_SESSION['UserID'], PDO::PARAM_STR);
			$stmt->bindParam(":examname", $_POST['examname'], PDO::PARAM_STR);
			$stmt->bindParam(":department", $_POST['department'], PDO::PARAM_STR);
			$stmt->bindParam(":subjectcode", $_POST['subcode'], PDO::PARAM_STR);
			$stmt->bindParam(":subject", $_POST['subject'], PDO::PARAM_STR);
			$stmt->bindParam(":semester", $_POST['semester'], PDO::PARAM_INT);
			$stmt->bindParam(":totalmarks", $_POST['totalmarks'], PDO::PARAM_INT);
			$stmt->bindParam(":date", $_POST['datepicker'], PDO::PARAM_STR);
			$stmt->execute();
			$id = $this->_db->lastInsertId();
			$stmt->closeCursor();
			return $id;
		}	

		return FALSE;
	}

	/** 
	 * Adds a new question to the question paper.
	 * @return TRUE if question added successfully, else return FALSE.
	 */
	public function createQuestion()
	{
	
		$sql = "INSERT INTO questions(questionNo, subjectcode, questionText, unit, marks) VALUES(:questNo, :subcode, :text, :unit, :marks)";

		if($_POST['category'] == "A") {
			$marks = 2;

			for($count = 1; $count <= 10; $count ++)
			{
				if(empty($_POST['Q'.$count]))
					break;
				else
				{
					if($stmt = $this->_db->prepare($sql)) 
					{
						$stmt->bindParam(":questNo", $count, PDO::PARAM_STR);
						$stmt->bindParam(":subcode", $_POST['subcode'], PDO::PARAM_STR);
						$stmt->bindParam(":text", $_POST['Q'.$count], PDO::PARAM_STR);
						$stmt->bindParam(":unit", $_POST['unit'.$count], PDO::PARAM_STR);
						$stmt->bindParam(":marks", $marks, PDO::PARAM_STR);
						$stmt->execute();
						$questionid = $this->_db->lastInsertId();
						$stmt->closeCursor();
						$sql2 = "INSERT INTO questPapers_questions(questpaperno, questionid) VALUES(:questPaperId, :questionId)";
						if($stmt2 = $this->_db->prepare($sql2))
						{
							$stmt2->bindParam(":questPaperId", $_SESSION['questPaperNo'], PDO::PARAM_INT);
							$stmt2->bindParam(":questionId", $questionid, PDO::PARAM_INT);
							$stmt2->execute();
							$stmt2->closeCursor();
						}
						else 
						{
							return FALSE;
						}
					}
					else 
					{
						return FALSE;
					}
				}
			}
		}
		else {
			$numPartA = $this->getTotalQuestions("A");
			for($i = $numPartA + 1; $i <= ($numPartA + 5); $i ++)
			{
				if(empty($_POST['Q'.$i.'a']) && empty($_POST['Q'.$i.'a1']))
					break;
				else
				{
					$choice = 'a';
					for($j = 0; $j < 2; $j ++)
					{ 
						if(empty($_POST['Q'.$i.$choice]))
						{
							$count = 2;
							$subdiv = '1';
							$marks = 8;
						}
						else
						{
							$count = 1;
							$subdiv = '';
							$marks = 16;
						}
						for($k = 1; $k <= $count; $k ++)
						{
							if(empty($_POST['Q'.$i.$choice.$subdiv]))
								break;
							$questNo = $i.$choice.$subdiv;
							if($stmt = $this->_db->prepare($sql)) 
							{
								$stmt->bindParam(":questNo", $questNo, PDO::PARAM_STR);
								$stmt->bindParam(":subcode", $_POST['subcode'], PDO::PARAM_STR);
								$stmt->bindParam(":text", $_POST['Q'.$questNo], PDO::PARAM_STR);
								$stmt->bindParam(":unit", $_POST['unit'.$questNo], PDO::PARAM_STR);
								$stmt->bindParam(":marks", $marks, PDO::PARAM_INT);
								$stmt->execute();
								$questionid = $this->_db->lastInsertId();
								$stmt->closeCursor();
								$sql2 = "INSERT INTO questPapers_questions(questpaperno, questionid) VALUES(:questPaperId, :questionId)";
								if($stmt2 = $this->_db->prepare($sql2))
								{
									$stmt2->bindParam(":questPaperId", $_SESSION['questPaperNo'], PDO::PARAM_INT);
									$stmt2->bindParam(":questionId", $questionid, PDO::PARAM_INT);
									$stmt2->execute();
									$stmt2->closeCursor();
								}
								else 
								{
									return FALSE;
								}
							}
							else 
							{
								return FALSE;
							}
								
							$subdiv = '2';
						}
						
						$choice = 'b';
					}
				}
			}

		}
		return TRUE;
	}

	/** 
	 * Retrieves the data for viewing the question paper. 
	 * @return row array of values or FALSE otherwise.
	 */
	 public function viewQuestionPaper($questPaperNo)
	 {
		$sql = "SELECT examName, department, subjectcode, subject, semester, totalmarks, date
			FROM questPapers
			WHERE questPaperNo = :id";
		if($stmt = $this->_db->prepare($sql))
		{
			$stmt->bindParam(":id", $questPaperNo, PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch();
			$stmt->closeCursor();
			return $row;
		}
	
		return FALSE;
	}
				
	/**
	 * Retrieves the data for viewing the questions.
	 * @param string $category - PART-A or PART-B category
	 * @return an array of row values or FALSE otherwise.
	 */
	public function viewQuestions($questPaperNo, $category)
	{
		if($category == "A")
		{
			$sql = "SELECT a.questionNo, a.questionText
				FROM questions a
				INNER JOIN questPapers_questions b
				ON a.questionid = b.questionid
				WHERE a.marks = 2
				AND b.questPaperNo = :questPaperNo
				ORDER BY CAST(a.questionNo AS UNSIGNED)";
		}
		else 
		{
			$sql = "SELECT a.questionNo, a.questionText
				FROM questions a
				INNER JOIN questPapers_questions b
				ON a.questionid = b.questionid
				WHERE a.marks <> 2
				AND b.questPaperNo = :questPaperNo
				ORDER BY a.questionNo";
		}
		if($stmt = $this->_db->prepare($sql))
		{
			$stmt->bindParam(":questPaperNo", $questPaperNo, PDO::PARAM_INT);
			$stmt->execute();
			$rows = $stmt->fetchAll();
			$stmt->closeCursor();
			return $rows;
		}

		return FALSE;
	}

	/**
	 * Retrieves all the question papers for the user.
	 * @return an array of row values or FALSE otherwise.
	 */
	public function getQuestionPapers()
	{
		$sql = "SELECT questPaperNo, examName, department, subjectcode, 
				subject, semester, totalmarks, date
				FROM questPapers
				WHERE userid = :userid";

		if($stmt = $this->_db->prepare($sql))
		{
			$stmt->bindParam(":userid", $_SESSION['UserID'], PDO::PARAM_INT);
			$stmt->execute();
			$rows = $stmt->fetchAll();
			$stmt->closeCursor();
			return $rows;
		}

		return FALSE;
	}
	
}	
?>


