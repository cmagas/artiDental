<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    include_once("cajaPos/funcionesProductos.php");


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerDatosIniciales();
        break;
        case 2:
                registrarAlmacen();
        break;
        case 3:
                modificarAlmacen();
        break;
        case 4:
                modificarEstatusAlmacen();
        break;
        
    }

    function obtenerDatosIniciales()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 3002_almacen ORDER BY idAlmacen";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           

            $o='{"":"","id":"'.$fila[0].'","nombreAlmacen":"'.$fila[3].'","descripcion":"'.$fila[4].'","situacion":"'.$fila[5].'","":""}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarAlmacen()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nomAlmacen=$obj->nomAlmacen;
        $descripcion=$obj->descripcion;
        
 
         $tipoOperacion="Registrar nuevo Almacen: ".$nomAlmacen;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 3002_almacen(idResponsable,fechaCreacion,nombreAlmacen,descripcion,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$nomAlmacen."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function modificarAlmacen()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idAlmacen=$obj->txtIdAlmacen;
        $nomAlmacen=$obj->nomAlmacen;
        $descripcion=$obj->descripcion;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica almacen: ".$idAlmacen." situacion: ".$situacion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3002_almacen SET nombreAlmacen='".$nomAlmacen."',descripcion='".$descripcion."',situacion='".$situacion."' WHERE idAlmacen='".$idAlmacen."'";
        $x++;

        $consulta[$x]="commit";
        $x++;

        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(3,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function modificarEstatusAlmacen()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idAlmacen=$obj->idAlmacen;
        $estado=$obj->estado;

        $tipoOperacion="Modifica situacion Almacen: ".$idAlmacen." situacion: ".$estado;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3002_almacen SET situacion='".$estado."' WHERE idAlmacen='".$idAlmacen."'";
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