<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListaTipoConsulta();
        break;
        case 2:
                registarNuevaConsulta();
        break;
        case 3:
                guardarCambiosTipoConsulta();
        break;
        
    }

    function obtenerListaTipoConsulta()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4005_catTipoConsulta ORDER BY idTipo";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           

            $o='{"":"","id":"'.$fila[0].'","nombreTipo":"'.$fila[3].'","descripcion":"'.$fila[4].'","situacion":"'.$fila[5].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registarNuevaConsulta()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombre=$obj->nombre;
        $descripcion=$obj->descripcion;
 
         $tipoOperacion="Registrar nueva tipo Consulta: ".$nombre;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4005_catTipoConsulta(idResponsable,fechaCreacion,nombre_tipo,descripcion,situacion)VALUES('".$idUsuarioSesion."',
        '".$fechaActual."','".$nombre."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarCambiosTipoConsulta()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idTipoConsulta=$obj->idTipoConsulta;
        $nombreTipo=$obj->nombreTipo;
        $descripcion=$obj->descripcion;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Tipo Consulta: ".$idTipoConsulta;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4005_catTipoConsulta SET nombre_tipo='".$nombreTipo."',descripcion='".$descripcion."',situacion='".$situacion."' WHERE idTipo='".$idTipoConsulta."'";
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