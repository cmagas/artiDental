<?php
	include_once("latis/cConexion.php");
	include_once("latis/funcionesComunes.php");
	include_once("latis/funcionesSistema.php");
	include_once("latis/funcionesSistemaAux.php");
	//echo gethostbyname('clubgalileo.com.mx');
	$conGalileo=new cConexion("censida.grupolatis.net","grupo_c3nsida","grupolatis17","grupolat_censida",true);//tus datso

	$logInicioSesion=false;
	$logFinSesion=false;
	$logSistemaAccesoPaginas=false;
	//phpinfo();
	//$conGalileo=new cConexion("localhost","root","123456","moodleGalileo",true);//tus datso
	
	
?>
