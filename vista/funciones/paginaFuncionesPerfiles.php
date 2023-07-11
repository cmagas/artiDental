<?php
    session_start();
    include_once("latis/conexionBD.php");
    include_once("latis/utiles.php");
    include_once("latis/cajaPos/funcionesProductos.php");



    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoPerfiles();
        break;
        case 2:
                registrarNuevoPerfil();
        break;
        case 3:
                guardarModificacionPerfiles();
        break;
        case 4:
                cambiarSituacionPerfil();
        break;
       
    }

    function obtenerListadoPerfiles()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 1004_perfiles ORDER BY idPerfil ";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{

            $o='{"":"","id":"'.$fila[0].'","perfil":"'.$fila[3].'","descripcion":"'.$fila[4].'","situacion":"'.$fila[5].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarNuevoPerfil()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombrePerfil=$obj->nombrePerfil;
        $descripcion=$obj->descripcion;
 
         $tipoOperacion="Registrar nuevo Perfil: ".$nombrePerfil;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 1004_perfiles(idResponsable,fechaCreacion,nombrePerfil,descripcion,situacion)VALUES('".$idUsuarioSesion."',
                '".$fechaActual."','".$nombrePerfil."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarModificacionPerfiles()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idPerfil=$obj->idPerfil;
        $nombrePerfil=$obj->nombrePerfil;
        $descripcion=$obj->descripcion;
        $situacion=$obj->situacion;
 
         $tipoOperacion="Realiza cambios a Perfiles: ".$idPerfil;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1004_perfiles SET nombrePerfil='".$nombrePerfil."',descripcion='".$descripcion."',situacion='".$situacion."' WHERE idPerfil='".$idPerfil."'";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }   
    }

    function cambiarSituacionPerfil()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idPerfil=$obj->idPerfil;
        $estado=$obj->estado;

        $tipoOperacion="Modifica situacion Modulos: ".$idPerfil." situacion: ".$estado;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1004_perfiles SET situacion='".$estado."' WHERE idPerfil='".$idPerfil."'";
        $x++;

        $consulta[$x]="commit";
        $x++;

        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(3,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }



?>