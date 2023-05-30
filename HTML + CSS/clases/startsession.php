<?php
	if(isset($_SESSION['User'])){
		if($_SESSION['HTTP_USER_AGENT']!=$_SESSION['Agent'] && $_SESSION['REMOTE_ADDR']!=$_SESSION['IP']){
			require_once('../logout.php');
		}else{
			session_start();
		}
	}else{
		session_start();
	}
?>