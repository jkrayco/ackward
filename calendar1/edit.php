<?php
	mysql_connect("localhost", "root", "root") or die (mysql_error());
	mysql_select_db("calendar") or die(mysql_error());

	$id = ''; 
	if( isset( $_GET['id'])) {
	    $id = $_GET['id']; 
	}
	$strSQL = "SELECT * FROM event WHERE id = '$id'"; 
	$result = mysql_query($strSQL) or die (mysql_error());
	$row = mysql_fetch_array($result);
	mysql_close();
?>

<p> Edit Event </p>
<br >
<form action="showedit.php" method="post">
<p> EVENT ID: <?php echo $row['id'] ?> </p>
Name of Event: <input type="text" name="name" value="<?php echo $row['name'] ?>"> <br >
Date and Time of Event: <input type="datetime" name="atime" value="<?php echo $row['atime'] ?>"><br >
<input name = "update" type = "submit" id = "update" value = "Edit Event">
</form>