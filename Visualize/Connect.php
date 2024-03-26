<?php
	//connect to db 
	$connect = mysqli_connect('localhost', 'root', '', 'register');
	if (!$connect) {
		die(mysqli_connect_error());
	}
?>