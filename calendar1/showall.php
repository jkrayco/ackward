<a href="add.php"> Create Event </a>
<br><br>

<?php
	mysql_connect("localhost", "root", "") or die (mysql_error());
	mysql_select_db("calendar") or die(mysql_error());

	$strSQL = "SELECT id, name, atime FROM event";
	$result = mysql_query($strSQL) or die (mysql_error());

	while($row = mysql_fetch_array($result)){
		echo $row['name'].'<tab>'.$row['atime'];
		echo '<a href="edit.php?id='.$row['id'].'" class="button" type="submit"> Edit Event </a>';
		echo '<a href="delete.php?id='.$row['id'].'" class="button" type="submit"> Delete Event </a>';
		echo '<br>';
	}

	mysql_close();
?>