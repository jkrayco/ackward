<?php
	$linkDB=@mysql_connect('localhost', 'root', 'root');	
	$database=mysql_select_db('ackward');
	$result=mysql_query('SELECT title, UNIX_TIMESTAMP(start) as time0 FROM event WHERE start >= NOW() ORDER BY start');
	$event=mysql_fetch_array($result);
	if ($event[title])
		echo '*', $event[title], ',', $event[time0];
	else
		echo "*NO EVENT";
?>