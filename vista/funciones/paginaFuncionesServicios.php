<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];

    // varDump($_POST);

    switch($funcion)
    {
        case 1:
                obtenerListadoServicios();
        break;
        case 2:
                guardarDatosServicio();
        break;
        case 3:
                guardarModificacionesServicios();
        break;
    }

    function obtenerListadoServicios()
    {
        global $con;

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 3004_servicios ORDER BY idServicio";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $ivaCompuesto=obtenerDatosIVA($fila[4]);
            $precio=cambiarFormatoMoneda($fila[5]);

            $o='{"":"","id":"'.$fila[0].'","nombreServicio":"'.$fila[3].'","valorIVA":"'.$fila[4].'","textIVA":"'.$ivaCompuesto.'","costoServicioRender":"'.$precio.'","descripcion":"'.$fila[6].'","costoServicio":"'.$fila[5].'","situacion":"'.$fila[7].'"}';


            if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

        echo '{"data":['.$arrRegistro.']}';
    }

    function guardarDatosServicio()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $nombreServicio=$obj->nombreServicio;
        $impuesto=$obj->impuesto;
        $precio=$obj->precio;
        $descripcion=$obj->descripcion;

        $tipoOperacion="Registrar nuevo Servicio: ".$nombreServicio;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 3004_servicios(idResponsable,fechaCreacion,nombreServicio,iva,costo,descripcion,
            situacion)VALUES('".$idUsuarioSesion."','".$fechaActual."','".$nombreServicio."','".$impuesto."',
            '".$precio."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarModificacionesServicios()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        //cadObj='{"nombreServicio":"'+nombreServicio+'","impuesto":"'+impuesto+'",
        //    "precio":"'+precio+'","descripcion":"'+descripcion+'","situacion":"'+situacion+'",
        //    "idServicio":"'+idServicio+'"}';
    
        $idServicio=$obj->idServicio;
        $nombreServicio=$obj->nombreServicio;
        $impuesto=$obj->impuesto;
        $precio=$obj->precio;
        $descripcion=$obj->descripcion;
        $situacion=$obj->situacion;

        $tipoOperacion="Realiza cambios al Servicio: ".$idServicio;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3004_servicios SET nombreServicio='".$nombreServicio."',iva='".$impuesto."',
            costo='".$precio."',descripcion='".$descripcion."',situacion='".$situacion."' WHERE idServicio='".$idServicio."'";
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