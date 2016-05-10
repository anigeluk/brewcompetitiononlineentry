<?php 
/*
 * Module:      process_judging_bos.inc.php
 * Description: This module does all the heavy lifting for adding/editing info in the "judging_scores_bos" table
 */

if ((isset($_SESSION['loginUsername'])) && ($_SESSION['userLevel'] <= 1)) {
	
	if ($action == "enter") {
		foreach($_POST['score_id'] as $score_id)	{
			
			if ($_POST['scorePrevious'.$score_id] == "Y") {
				$updateSQL = sprintf("UPDATE $judging_scores_bos_db_table SET
				eid=%s,
				bid=%s,
				scoreEntry=%s,
				scorePlace=%s,
				scoreType=%s
				WHERE id=%s",
								   GetSQLValueString($_POST['eid'.$score_id], "text"),
								   GetSQLValueString($_POST['bid'.$score_id], "text"),
								   GetSQLValueString($_POST['scoreEntry'.$score_id], "text"),
								   GetSQLValueString($_POST['scorePlace'.$score_id], "text"),
								   GetSQLValueString($_POST['scoreType'.$score_id], "text"),
								   GetSQLValueString($_POST['id'.$score_id], "text")
								   );
			
				mysqli_real_escape_string($connection,$updateSQL);
				$result = mysqli_query($connection,$updateSQL) or die (mysqli_error($connection));
				
			}
			
			if (($_POST['scorePlace'.$score_id] != "") && ($_POST['scorePrevious'.$score_id] == "N")) {
				$insertSQL = sprintf("INSERT INTO $judging_scores_bos_db_table (
				eid, 
				bid, 
				scoreEntry,
				scorePlace,
				scoreType
				) VALUES (%s, %s, %s, %s, %s)",
								   GetSQLValueString($_POST['eid'.$score_id], "text"),
								   GetSQLValueString($_POST['bid'.$score_id], "text"),
								   GetSQLValueString($_POST['scoreEntry'.$score_id], "text"),
								   GetSQLValueString($_POST['scorePlace'.$score_id], "text"),
								   GetSQLValueString($_POST['scoreType'.$score_id], "text")
								   );
			
				mysqli_real_escape_string($connection,$insertSQL);
				$result = mysqli_query($connection,$insertSQL) or die (mysqli_error($connection));	
				
			}
			
		}
		$pattern = array('\'', '"');
		$updateGoTo = str_replace($pattern, "", $updateGoTo); 
		header(sprintf("Location: %s", stripslashes($updateGoTo)));
		
	} // end if ($action == "enter")
		
} else echo "<p>Not available.</p>";
?>