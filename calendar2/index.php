<?php

	$conn = @mysql_connect("localhost", "root", "root");
    mysql_select_db('ackward');

	if(isset($_POST['add'])){
		
		if(! get_magic_quotes_gpc() ) {
	        $name = addslashes ($_POST['title']);
	        $adate = addslashes ($_POST['date']);
	        $atime = addslashes ($_POST['time']);
	    } else {
	    	$name = $_POST['title'];
	        $adate = $_POST['date'];
	        $atime = $_POST['time'];
	    }
		$adatetime = date('Y-m-d H:i:s', strtotime("$adate $atime"));
		
	    $strSQL = "INSERT INTO event (title, start) VALUES ('$name', '$adatetime')";
	    $result = mysql_query($strSQL) or die (mysql_error());
   	}

   	if(isset($_POST['edit'])){
		
		if(! get_magic_quotes_gpc() ) {
	        $name = addslashes ($_POST['title']);
	        $adate = addslashes ($_POST['date']);
	        $atime = addslashes ($_POST['time']);
	    } else {
	    	$name = $_POST['title'];
	        $adate = $_POST['date'];
	        $atime = $_POST['time'];
	    }
		$adatetime = date('Y-m-d H:i:s', strtotime("$adate $atime"));
		$id = $_GET['edit'];
		
	    $strSQL = "UPDATE event SET title='$name', start='$adatetime' WHERE ID='$id'";
	    $result = mysql_query($strSQL) or die (mysql_error());

	    header("location: index.php?show=all");
   	}

   	if(isset($_POST['cancel'])){
   		header("location: index.php?show=all");
   	}

    if (isset($_GET['del'])){
    	$id = $_GET['del'];
    	$strSQL = "DELETE FROM event WHERE ID='$id'";
    	$result = mysql_query($strSQL) or die (mysql_error());

    	header("location: index.php?show=all");
    }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ACKWARD Calendar</title>
    

    <link rel='stylesheet' href='fullcalendar.css' />
    <script src='jquery.min.js'></script>
    <script src='moment.min.js'></script>
    <script src='fullcalendar.js'></script>

    <link type="text/css" rel="stylesheet" href="css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Lobster" />


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>

        $(document).ready(function() {

          // page is now ready, initialize the calendar...

          $('#calendar').fullCalendar({
              // put your options and callbacks here
              events: 'returnevents3.php'
              

          })

      });
    </script>
	<style>
			body{
				background-image:url('bg.jpg');
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position:center;
				background-size:cover;
			}
	</style>
  </head>
 
<body style = "position: fixed; overflow: hidden;">

<div id="header">
      <h1>Ackward Calendar</h1>
</div>

<div class="container-fluid" style= "margin-left: 7%">
  

      <div style = " width:59%; float:left; margin-left: 3px; margin-top:3px; overflow: scroll" class="col-sm-9">
           <div id='calendar'></div>
      </div>

      <div class="col-sm-3" style = "background-color:#e0f8ff; width:30%; height:535px; float: left; padding: 0.5% 0.5% 0.5% 0.5%; margin-left: 10px">
      
        <div class="top">
          <ul class="nav nav-pills nav-justified">
            <li class="active"><a href="index.php?add" style="margin-right:1px;">Add New Event</a></li>
            <li class="active"><a href="index.php?show=all">Show All Events</a></li>
          </ul>
          <br>
        </div>
            <?php

              mysql_connect("localhost", "root", "root") or die (mysql_error());
              mysql_select_db("ackward") or die(mysql_error());

              if (isset($_GET['show'])){

                if ($_GET['show'] == "all"){
                  $strSQL = "SELECT ID, title, start FROM event ORDER BY start";
                  $result = mysql_query($strSQL) or die (mysql_error());
                  ?><div class="content" style= "overflow: scroll; height: 460px;"><?php
                  while($row = mysql_fetch_array($result)){
                    ?>
                    <div class="inline">

                    	<div class="buttons" style="float: right">
                        <div class="btn-group" role="group" aria-label="...">
                          <a href='index.php?edit=<?php echo $row['ID'];?>' class="btn btn-info" role="button" style="font-size:12px">Edit</a>
                          <a href='index.php?del=<?php echo $row['ID'];?>' class="btn btn-info" role="button" style="font-size:12px">Delete</a>
                        </div>
                      </div>

                      <div class="l"><div class="eventtitle"><strong>
                        <?php
                        echo $row['title'];
                        ?>
                        </strong>
                      </div>
                      
                      <div class="eventtime">
                        <?php
                        $monthNum  = date('m',strtotime($row['start']));
						$dateObj   = DateTime::createFromFormat('!m', $monthNum);
						$monthName = $dateObj->format('F');
						$hr = date('H',strtotime($row['start']));
                        echo $monthName;
                        echo " ";
                        echo date('d',strtotime($row['start']));
                        echo ", ";
                        echo date('Y',strtotime($row['start']));
                        ?><br><?php
                        if ($hr%12==0){
                        	echo "12";
                        }
                        else{
                        	echo $hr%12;
                        }
                        echo date(':i ',strtotime($row['start']));
                        if ($hr<12){
                        	echo "AM";
                        }
                        else{
                        	echo "PM";
                        }

                        ?>
                      </div>

                      </div>
                      
                    </div>
                    <br><?php
                    echo '<br>';
                  }
                }

              }

              if (isset($_GET['add'])){
                ?><center><br>
                <form action="" method="post">
                  Name of Event: <input class="textbox" type="text" name="title"> <br><br>
                  Date of Event: <input class="textbox" type="date" name="date"><br><br>
                  Time of Event: 
                  <input class="textbox" type="time" name="time"><br><br>
                  <div class="buttons"><center>
                        <div class="btn-group" role="group" aria-label="...">
                  <input name = "add" type = "submit" id = "add" value = "Add Event" class="btn btn-info" role="button" style="font-size:12px">
                  <input name = "cancel" type = "submit" id = "cancel" value = "Cancel" class="btn btn-info" role="button" style="font-size:12px">
                  </div></center>
                  </div>
                </form></center><?php
              }

              if (isset($_GET['edit'])){
                $id = $_GET['edit'];
                $strSQL = "SELECT * FROM event WHERE ID = '$id'"; 
                $result = mysql_query($strSQL) or die (mysql_error());
                $row = mysql_fetch_array($result);
                ?>

                <center>
                <!-- <h4 style="font-family: georgia"><i><strong> Edit Event </i></strong></h4><br>                         -->
                <br>
                <form action="" method="post">
                  <!-- <p> EVENT ID: <?php echo $row['id'] ?> </p> -->
                  Name of Event: <input class="textbox" type="text" name="title" value="<?php echo $row['title'] ?>"> <br><br>
                  Date of Event: <input class="textbox" type="date" name="date" value="<?php echo date('Y-m-d', (strtotime($row['start'])))?>"><br><br>
				  Time of Event: <input class="textbox" type="time" name="time" value="<?php echo date('H:i', (strtotime($row['start'])))?>"><br><br>
				  <div class="buttons">
				  <div class="btn-group" role="group" aria-label="...">
				  <center>
                  <input name = "edit" type = "submit" value = "Edit Event" class="btn btn-info" role="button" style="font-size:12px">
                  <input name = "cancel" type = "submit" value = "Cancel" class="btn btn-info" role="button" style="font-size:12px"></center>
                  </div></div>
                </form></center>

                <?php
              }
            ?>
          </div>
        </div>
      </div>
</div>
</body>
</html>

<script>
	function confirmDelete(){
		var ask=confirm("Are you sure?");
		if(ask){
			
		}
	}
</script>