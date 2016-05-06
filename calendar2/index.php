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
  </head>
 
<body style = "position: fixed; overflow: hidden;">

<div id="header">
      <h1>Ackward Calendar</h1>
</div>

<div class="container-fluid">
  

      <div style = " width:55%; float:left; margin-left: 5px; margin-top: 5px; overflow: scroll" class="col-sm-9">
           <div id='calendar'></div>
      </div>

      <div class="col-sm-3" style = "background-color:#e0f8ff; width:30%; height:535px; float: left; padding: 1% 1% 1% 1%; margin-left: 10px">
      
        <div class="top">
          <ul class="nav nav-pills nav-justified">
            <li><a href="index.php?add">Add New Event</a></li>
            <li><a href="index.php?show=all">Show All Events</a></li>
          </ul>
          <br>
        </div>
            <?php

              mysql_connect("localhost", "root", "root") or die (mysql_error());
              mysql_select_db("ackward") or die(mysql_error());

              if (isset($_GET['show'])){

                if ($_GET['show'] == "all"){
                  $strSQL = "SELECT ID, title, start FROM event";
                  $result = mysql_query($strSQL) or die (mysql_error());
                  ?><div class="content" style= "overflow: scroll; height: 460px;"><?php
                  while($row = mysql_fetch_array($result)){
                    ?>
                    <div class="inline">
                      <div class="l">
                        <?php
                        echo $row['title'].'<br>'.$row['start'];
                        ?>
                      </div>
                      <div class="buttons" style="float: right">
                        <div class="btn-group" role="group" aria-label="...">
                          <a href='index.php?edit=<?php echo $row['ID'];?>' class="btn btn-info" role="button" style="font-size:12px">Edit</a>
                          <a href='index.php?del=<?php echo $row['ID'];?>' class="btn btn-info" role="button" style="font-size:12px">Delete</a>
                        </div>
                      </div>
                    </div>
                    <br><?php
                    echo '<br>';
                  }
                }

              }

              if (isset($_GET['add'])){
                ?>
                <form action="index.php?show=all" method="post">
                  Name of Event: <input type="text" name="title"> <br><br>
                  Date of Event: <input type="date" name="date"><br><br>
                  Time of Event: 
                  <input type="time" name="usr_time"><br><br>
                  <input name = "add" type = "submit" id = "add" value = "Add Event">
                  <input name = "cancel" type = "submit" id = "cancel" value = "Cancel">
                </form><?php
              }

              if (isset($_GET['edit'])){
                $id = $_GET['edit'];
                $strSQL = "SELECT * FROM event WHERE ID = '$id'"; 
                $result = mysql_query($strSQL) or die (mysql_error());
                $row = mysql_fetch_array($result);
                ?>

                <p> Edit Event </p>
                
                <form action="index.php?show=all" method="post">
                  <p> EVENT ID: <?php echo $row['id'] ?> </p>
                  Name of Event: <input type="text" name="title" value="<?php echo $row['title'] ?>"> <br >
                  Date of Event: <input type="date" name="date"><br><br>
                  Time of Event: <input type="time" name="usr_time"><br><br>
                  <input name = "update" type = "submit" id = "update" value = "Edit Event">
                  <input name = "cancel" type = "submit" id = "cancel" value = "Cancel">
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
        </div>
      </div>
  

</div>

   
    
</body>
</html>