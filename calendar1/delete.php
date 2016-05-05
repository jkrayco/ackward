<?php
	mysql_connect("localhost", "root", "root") or die (mysql_error());
  	mysql_select_db("calendar") or die(mysql_error());

  	$id = ''; 
	if( isset( $_GET['id'])) {
	    $id = $_GET['id']; 
	}

  	$strSQL = "DELETE FROM event WHERE id = '$id'";
	$result = mysql_query($strSQL) or die (mysql_error());

	header("Location: showall.php");
?>