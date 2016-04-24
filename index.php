<html>
<head>   
<link href="calendar.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
include 'calendar.php';
 
$calendar = new Calendar();
 
echo $calendar->show();
?>
</body>
</html>       
<!-- Reference: http://www.startutorial.com/articles/view/how-to-build-a-web-calendar-in-php#sthash.TMYR4cok.dpuf -->