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
                obtenerListadoPromociones();
        break;
        case 2:
                guardarModificacionPromociones();
        break;
        
    }

    function obtenerListadoPromociones()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 3008_promociones ORDER BY idPromociones ";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           $fechaInicial=cambiarFormatoFecha($fila[5]);
           $fechaFin=cambiarFormatoFecha($fila[6]);

            $o='{"":"","id":"'.$fila[0].'","tituloPromocion":"'.$fila[3].'","descripcion":"'.$fila[4].'","fechaInicial":"'.$fechaInicial.'","fechaIni":"'.$fila[5].'","fechaFinal":"'.$fechaFin.'","fechaFin":"'.$fila[6].'","url_doc":"'.$fila[7].'","situacion":"'.$fila[8].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function guardarModificacionPromociones()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $idPromocion=$obj->idPromocion;
        $titulo=$obj->titulo;
        $descripcion=$obj->descripcion;
        $fechaInicio=$obj->fechaInicio;
        $fechaFin=$obj->fechaFin;
        $situacion=$obj->situacion;

        $tipoOperacion="Realiza cambios a Promocion: ".$idPromocion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3008_promociones SET titulo='".$titulo."',descripcion='".$descripcion."',fechaPublicacion='".$fechaInicio."',fechaFin='".$fechaFin."',situacion='".$situacion."' WHERE idPromociones='".$idPromocion."'";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }   
    }


?>    