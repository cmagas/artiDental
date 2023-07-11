<?php

    session_start();
	include_once("conexionBD.php"); 
	
	
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
		}
	}	

    switch($funcion)
	{
        case 1:
            	autenticarUsuario();
        break;
		case 2:
				cerrarSesion();
		break;
    }

    function autenticarUsuario()
	{
		global $con;
		
		$l=$_POST["l"];
		$p=$_POST["p"];
		
		//$consulta="SELECT * FROM 1000_usuarios WHERE usu_nombre='".cv($l)."' AND usu_contrasena='".cv($p)."' AND situacion in(1,3)";
		//$fila=$con->obtenerPrimeraFila($consulta);

		$consulta="SELECT * FROM 1000_usuarios u,1004_perfiles p,1005_perfilModulo pm, 1006_modulos m 
						WHERE u.idPerfilUsuario=p.idPerfil AND pm.idPerfil=u.idPerfilUsuario AND m.idModulo=pm.idModulo 
						AND pm.vista_inicio='1' AND u.usu_nombre='".cv($l)."' AND u.usu_contrasena='".cv($p)."'";
		$fila=$con->obtenerPrimeraFila($consulta);

		if($fila)
		{
			$_SESSION["idUsr"]=$fila[0];
			$_SESSION["idEmpresa"]=$fila[9];
			$_SESSION["idPerfilUsuario"]=$fila[10];
			$_SESSION["idPerfilModulo"]=$fila[18];
			$_SESSION["idModulo"]=$fila[20];
			$_SESSION["vista"]=$fila[28];
			$_SESSION["usuarioNombre"]=$fila[6];
			$_SESSION["usuarioApellido"]=$fila[7]." ".$fila[8];

			echo "1|1";
			
		}
		else{
			$_SESSION["idUsr"]="-1";
			$_SESSION["idEmpresa"]="-1";
			$_SESSION["idPerfilUsuario"]="-1";
			$_SESSION["idPerfilModulo"]="-1";
			$_SESSION["idModulo"]="-1";

			echo "1|0";
		}



		
		// if($fila)
		// {
		// 	$conRol="SELECT idRol FROM 1001_usuariosVSRoles WHERE idUsuario=".$fila[0]." AND idRol=1";
		// 	$idRol=$con->obtenerValor($conRol);

		// 	$conVistaPrincipal="SELECT * FROM 1000_usuarios u,1004_perfiles p,1005_perfilModulo pm, 1006_modulos m 
		// 				WHERE u.idPerfilUsuario=p.idPerfil AND pm.idPerfil=u.idPerfilUsuario AND m.idModulo=pm.idModulo 
		// 				AND pm.vista_inicio='1' AND u.idUsuario='".$fila[0]."'";
		// 	$vPrin=$con->obtenerPrimeraFila($conVistaPrincipal);
			
		// 	$_SESSION["idUsr"]=$fila[0];
		// 	$_SESSION["idEmpresa"]=$fila[9];
		// 	$_SESSION["genero"]=$fila[5];
		// 	$_SESSION["vistaTab"]=$vPrin;

		// 	$consultaRol="SELECT idRol from 1001_usuariosVSRoles where idUsuario=".$fila[0];
		// 	$resRoles=$con->obtenerFilas($consultaRol);
				
		// 	$listaGrupo="";
		// 	while($fRoles=mysql_fetch_row($resRoles))
		// 	{
		// 		if($listaGrupo=="")
		// 			$listaGrupo=$fRoles[0];
		// 		else
		// 			$listaGrupo.=",".$fRoles[0];
		// 	}

		// 	if($listaGrupo=="")
		// 		$listaGrupo='-1';
		// 	$_SESSION["idRol"]=$listaGrupo;
			
		// 	//guardarBitacoraInicioSesion();
		// 	echo "1|1";
		// }
		// else
		// {
		// 	$_SESSION["idUsr"]="-1";
		// 	$_SESSION["login"]="";
		// 	$_SESSION["idRol"]="-1000";
		// 	$_SESSION["status"]="-1";
		// 	$_SESSION["genero"]=-1;
		// 	$_SESSION["vistaTab"]=-1;
		// 	//guardarBitacoraInicioSesionFallida(cv($p));
		// 	echo "1|0";
		// }
	}

	function cerrarSesion()
	{
		session_destroy(); 
	}
?>