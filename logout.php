<?php
	session_start();
	//unset($_SESSION['admin']);
	session_destroy();
	header("Refresh:1;url=index.html");
?>