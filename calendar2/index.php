<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ACKWARD Calendar</title>
    
    <link rel='stylesheet' href='fullcalendar.css' />
    <script src='jquery.min.js'></script>
    <script src='moment.min.js'></script>
    <script src='fullcalendar.js'></script>

    <script>

        $(document).ready(function() {

          // page is now ready, initialize the calendar...

          $('#calendar').fullCalendar({
              // put your options and callbacks here
              events: 'returnevents3.php'

          })

      });
    </script>
  </head>
 
<body>


 <div id='calendar'></div>
 <div class="sidenav">
    <br>
    <a href="index.php?add"> Add New Event </a><br>
    <a href="index.php?show=all"> Show All Events </a>
    <br><br>
    <?php

      mysql_connect("localhost", "root", "") or die (mysql_error());
      mysql_select_db("ackward") or die(mysql_error());

      if (isset($_GET['show'])){

        if ($_GET['show'] == "all"){
          $strSQL = "SELECT id, title, time FROM event";
          $result = mysql_query($strSQL) or die (mysql_error());

          while($row = mysql_fetch_array($result)){
            echo $row['title'].'<tab>'.$row['time'];
            echo '<a href="index.php?edit='.$row['id'].'" class="button" type="submit"> Edit Event </a>';
            echo '<a href="index.php?del='.$row['id'].'" class="button" type="submit"> Delete Event </a>';
            echo '<br>';
          }
        }

      }

      if (isset($_GET['add'])){
        ?>
        <form action="show.php" method="post">
          Name of Event: <input type="text" name="title"> <br >
          Date and Time of Event: <input type="datetime" name="time" ><br >
          <input name = "add" type = "submit" id = "add" value = "Add Event">
        </form><?php
      }

      if (isset($_GET['edit'])){
        $strSQL = "SELECT * FROM event WHERE id = '$id'"; 
        $result = mysql_query($strSQL) or die (mysql_error());
        $row = mysql_fetch_array($result);
        ?>

        <p> Edit Event </p>
        
        <form action="showedit.php" method="post">
          <p> EVENT ID: <?php echo $row['id'] ?> </p>
          Name of Event: <input type="text" name="title" value="<?php echo $row['title'] ?>"> <br >
          Date and Time of Event: <input type="datetime" name="time" value="<?php echo $row['time'] ?>"><br >
          <input name = "update" type = "submit" id = "update" value = "Edit Event">
        </form>

        <?php
      }

      if (isset($_GET['del'])){
        ?>

        <p> confirm delete alert box </p>

        <?php
      }
    ?>


  </div>


</body>
</html>