<?php
	$linkDB=@mysql_connect('localhost', 'root', 'root');
	
	$database=mysql_select_db('test');
	$result=mysql_query('SELECT title, UNIX_TIMESTAMP(time) as time0 FROM event ORDER BY time');
	$event=mysql_fetch_array($result);
	echo '*', $event[title], ',', $event[time0];
?>