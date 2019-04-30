<!-- SJSU CMPE 180B Spring 2019 TEAM4 -->
<?php
	session_start();
	session_destroy();
	header("Refresh:1;url=index.html");
?>