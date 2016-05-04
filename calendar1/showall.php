<?php
	mysql_connect("localhost", "root", "") or die (mysql_error());
	mysql_select_db("calendar") or die(mysql_error());

	$strSQL = "SELECT name, atime FROM event";
	$result = mysql_query($strSQL) or die (mysql_error());

	while($row = mysql_fetch_array($result)){
		echo $row['name'].'<tab>'.$row['atime'];
		echo '<a href="edit.php"> Edit Event </a>';
	}

	mysql_close();
?>