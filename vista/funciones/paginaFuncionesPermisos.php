<?php
    session_start();
    include_once("latis/conexionBD.php");
    include_once("latis/utiles.php");


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoPermisos();
        break;
        case 2:
                guardarNuevoRegistro();
        break;
        case 3:
                modificarPermiso();
        break;
        case 4:
                cambiarSituacionPermisos();
        break;

    }

    function obtenerListadoPermisos()
    {
        global $con;
        $arrRegistro="";

        $consulta="SELECT * FROM 1002_roles ORDER BY idRol";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $o='{"":"","id":"'.$fila[0].'","nombrePermiso":"'.$fila[3].'","descripcion":"'.$fila[4].'","situacion":"'.$fila[6].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function guardarNuevoRegistro()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nomPermiso=$obj->nomPermiso;
        $descripcion=$obj->descripcion;
        
 
         $tipoOperacion="Registrar nuevo Permiso: ".$nomPermiso;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 1002_roles(idResponsable,fechaCreacion,rol_nombre,descripcion,situacion)VALUES('".$idUsuarioSesion."',
        '".$fechaActual."','".$nomPermiso."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function modificarPermiso()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $txtIdPermiso=$obj->txtIdPermiso;
        $nomPermiso=$obj->nomPermiso;
        $descripcion=$obj->descripcion;
        $situacion=$obj->txt_Situacion;
 
         $tipoOperacion="Realiza cambios a Permisos: ".$txtIdPermiso;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1002_roles SET rol_nombre='".$nomPermiso."',descripcion='".$descripcion."',situacion='".$situacion."' WHERE idRol='".$txtIdPermiso."'";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }         
    }

    function cambiarSituacionPermisos()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idPermiso=$obj->idPermiso;
        $estado=$obj->estado;

        $tipoOperacion="Modifica situacion Permiso: ".$idPermiso." situacion: ".$estado;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1002_roles SET situacion='".$estado."' WHERE idRol='".$idPermiso."'";
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