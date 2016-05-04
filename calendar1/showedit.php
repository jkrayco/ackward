name of event: <?php if(isset($_POST["name"]))
					echo $_POST["name"]; ?>
					<br >
date and time: <?php if(isset($_POST["atime"]))
					echo $_POST["atime"]; ?>
<br>

<?php
	if(isset($_POST['update']))
		{
			$conn = mysql_connect("localhost", "root", "");
			mysql_select_db("calendar") or die(mysql_error());
		

		if(! $conn)
		{
			die (mysql_error());
		}

		$id = ''; 
		if( isset( $_POST['id'])) {
	   	 	$id = $_POST['id']; 
		}

		if(! get_magic_quotes_gpc() ) {
	        $name = addslashes ($_POST['name']);
	        $atime = addslashes ($_POST['atime']);
	    } else {
	    	$name = $_POST['name'];
	        $atime = $_POST['atime'];
	    }

	    $strSQL = "UPDATE event SET name = '$name', atime = '$atime' WHERE id = '$id'";
	    $result = mysql_query($strSQL) or die (mysql_error());

	    echo "Edited data successfully!";

	    mysql_close($conn);
   	}
?>
<br>
<a href="add.php"> Create Event </a>
<br>
<a href="showall.php"> Show all Event </a>