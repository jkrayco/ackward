<?php
$today = getdate();
if(isset($_GET['mon'])){
   if(isset($_GET['year'])){
      $start = mktime(0,0,0,$_GET['mon'],1,$_GET['year']);
   }
   else{
      $start = mktime(0,0,0,$_GET['mon'],1,$today['year']);
   }
}
else{
   $start = mktime(0,0,0,$today['mon'],1,$today['year']);
}
$first = getdate($start);
$end = mktime(0,0,0,$first['mon']+1,0,$first['year']);
$last = getdate($end);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ACKWARD Calendar</title>
    <link href="calendar.css" rel="stylesheet" type="text/css" />
  </head>
 
<body>
<div class="test">
  <div class="calendar">
    <div class="monheader"><?php echo $first['month'] . ' - ' . $first['year']; ?></div>
    <div class="dayheader">Sun</div>
    <div class="dayheader">Mon</div>
    <div class="dayheader">Tue</div>
    <div class="dayheader">Wed</div>
    <div class="dayheader">Thu</div>
    <div class="dayheader">Fri</div>
    <div class="dayheader">Sat</div>

    <?php
    for($i = 0; $i < $first['wday']; $i++){
       echo '  <div class="inactive"></div>' . "\n";
    }
    for($i = 1; $i <= $last['mday']; $i++){
       if($i == $today['mday'] && $first['mon'] == $today['mon'] && $first['year'] == $today['year']){
          $style = 'today';
       }
       else{
          $style = 'day';
       }
       echo '  <div class="' . $style . '"><a href="index.php?id='.$i.'">' . $i . '</a></div>' . "\n";
    }
    if($last['wday'] < 6){
       for($i = $last['wday']; $i < 6; $i++){
          echo '  <div class="inactive"></div>' . "\n";
       }
    }
    ?>
  </div>

  <div class="sidenav">
    <br>
    <a href="index.php?add"> Add New Event </a><br>
    <a href="index.php?show=all"> Show All Events </a>
    <br><br>
    <?php

      mysql_connect("localhost", "root", "root") or die (mysql_error());
      mysql_select_db("calendar") or die(mysql_error());

      if (isset($_GET['show'])){

        if ($_GET['show'] == "all"){
          $strSQL = "SELECT id, name, atime FROM event";
          $result = mysql_query($strSQL) or die (mysql_error());

          while($row = mysql_fetch_array($result)){
            echo $row['name'].'<tab>'.$row['atime'];
            echo '<a href="index.php?edit='.$row['id'].'" class="button" type="submit"> Edit Event </a>';
            echo '<a href="index.php?del='.$row['id'].'" class="button" type="submit"> Delete Event </a>';
            echo '<br>';
          }
        }

      }

      if (isset($_GET['add'])){
        ?>
        <form action="show.php" method="post">
          Name of Event: <input type="text" name="name"> <br >
          Date and Time of Event: <input type="datetime" name="atime" ><br >
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
          Name of Event: <input type="text" name="name" value="<?php echo $row['name'] ?>"> <br >
          Date and Time of Event: <input type="datetime" name="atime" value="<?php echo $row['atime'] ?>"><br >
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

</div>
</body>
</html>