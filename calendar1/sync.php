<?php
	$linkDB=@mysql_connect('localhost', 'root', 'root');	
	$database=mysql_select_db('ackward');
	$result=mysql_query('SELECT title, UNIX_TIMESTAMP(time) as time0 FROM event WHERE time >= NOW() ORDER BY time');
	$event=mysql_fetch_array($result);
	if ($event[title])
		echo '*', $event[title], ',', $event[time0];
	else
		echo "*NO EVENT";
?>