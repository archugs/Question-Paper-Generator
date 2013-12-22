<?php

/* Handles user interactions within the app */

class Users
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
	
	/** Checks credentials and logs in the user
	 * @return boolean - TRUE on success and FALSE on failure
	 */
	public function accountLogin()
	{
		$sql = "SELECT UserID
			FROM users
			WHERE UserID = :user
			AND Password = :pass
			LIMIT 1";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':user', $_POST['userid'], PDO::PARAM_STR);
			$stmt->bindParam(':pass', $_POST['password'], PDO::PARAM_STR);
			$stmt->execute();
			if($stmt->rowCount() == 1)
			{
				$_SESSION['UserID'] = htmlentities($_POST['userid'], ENT_QUOTES);
				$_SESSION['LoggedIn'] = 1;
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		catch(PDOException $e)
		{
			return FALSE;
		}
	}

	/** 
	 * Checks if userid already exists. If not, creates a new acount.
	 * @return TRUE if account created successfully, else return FALSE.
	 */
	public function createAccount()
	{
		$sql = "SELECT COUNT(userid) AS userCount
			FROM users
			WHERE userid = :userid";
		if($stmt = $this->_db->prepare($sql)) {
			$stmt->bindParam(":userid", $userid, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch();
			if($row['userCount'] != 0) {
				$stmt->closeCursor();
				return FALSE;
			}
		}
		$stmt->closeCursor();
		$sql = "INSERT INTO users(userid, username, password, collegename, collegeaddress) VALUES(:userid, :username, :password, :collegename, :collegeaddress)";
		if($stmt = $this->_db->prepare($sql)) {
			$stmt->bindParam(":userid", $_POST['userid'], PDO::PARAM_STR);
			$stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
			$stmt->bindParam(":password", $_POST['password'], PDO::PARAM_STR);
			$stmt->bindParam(":collegename", $_POST['collegename'], PDO::PARAM_STR);
			$stmt->bindParam(":collegeaddress", $_POST['collegeaddress'], PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
			return TRUE;
		}	

		return FALSE;
	}
}	
?>


