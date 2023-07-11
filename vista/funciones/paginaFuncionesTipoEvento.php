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
                obtenerListadoTipoEvento();
        break;
        case 2:
                guardarTipoEvento();
        break;
        case 3:
                modificarTipoEvento();
        break;
        
    }

    function obtenerListadoTipoEvento()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4004_catalogoTipoEventos ORDER BY idTipoEvento";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           

            $o='{"":"","id":"'.$fila[0].'","nombreTipoEvento":"'.$fila[3].'","claseColor":"'.$fila[4].'","descripcion":"'.$fila[5].'","situacion":"'.$fila[6].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }
    
    function guardarTipoEvento()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombreTipo=$obj->nombre;
        $descripcion=$obj->descripcion;
        $color=$obj->color;
        
 
         $tipoOperacion="Registrar nuevo Tipo Evento: ".$nombreTipo;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4004_catalogoTipoEventos(idResponsable,fechaCreacion,tipoEvento,colorTipo,descripcion,situacion)VALUES('".$idUsuarioSesion."',
        '".$fechaActual."','".$nombreTipo."','".$color."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function modificarTipoEvento()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idRegistro=$obj->idRegistro;
        $nombreTipo=$obj->nombreTipo;
        $descripcion=$obj->descripcion;
        $color=$obj->color;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Tipo Evento: ".$idRegistro." situacion: ".$situacion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4004_catalogoTipoEventos SET tipoEvento='".$nombreTipo."',
            colorTipo='".$color."',descripcion='".$descripcion."',situacion='".$situacion."' WHERE idTipoEvento='".$idRegistro."'";
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