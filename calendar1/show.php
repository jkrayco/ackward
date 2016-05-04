name of event: <?php if(isset($_POST["name"]))
					echo $_POST["name"]; ?>
					<br >
date and time: <?php if(isset($_POST["atime"]))
					echo $_POST["atime"]; ?>

<?php
	if(isset($_POST['add']))
		{
			$conn = mysql_connect("localhost", "root", "");
		

		if(! $conn)
		{
			die (mysql_error());
		}

		if(! get_magic_quotes_gpc() ) {
	        $name = addslashes ($_POST['name']);
	        $atime = addslashes ($_POST['atime']);
	    } else {
	    	$name = $_POST['name'];
	        $atime = $_POST['atime'];
	    }

	    $strSQL = "INSERT INTO event (name, atime) VALUES ('$name', '$atime')";
	    mysql_select_db('calendar');
	    $result = mysql_query($strSQL) or die (mysql_error());

	    echo "Entered data successfully!";

	    mysql_close($conn);
   	}
?>