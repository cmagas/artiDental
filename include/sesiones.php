<?php session_start();
	header("Content-Type:text/html;charset=utf-8");
	if(isset($_SESSION["idUsr"]))
	{
		if($_SESSION["idUsr"]=="-1")
		{
			header('Location:../Login/index.php');
		}
	}
	else
		header('Location:../Login/index.php');			
	
?>