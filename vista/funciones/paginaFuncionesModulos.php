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
                obtenerListadoModulos();
        break;
        case 2:
                registrarNuevoModulo();
        break;
        case 3:
                guardarModificacionModulos();
        break;
        case 4:
                cambiarSituacionProveedores();
        break;
       
    }

    function obtenerListadoModulos()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 1006_modulos ORDER BY idModulo";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombreModulo=obtenerNombreModulo($fila[4]);

            $o='{"":"","id":"'.$fila[0].'","modulo":"'.$fila[3].'","nomModuloPadre":"'.$nombreModulo.'","moduloPadre":"'.$fila[4].'","vista":"'.$fila[5].'","iconoMenu":"'.$fila[6].'","orden":"'.$fila[7].'","situacion":"'.$fila[8].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarNuevoModulo()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombreModulo=$obj->nombreModulo;
        $moduloPadre=$obj->moduloPadre;
        $nomIcono=$obj->nomIcono;
        $nomFormulario=$obj->nomFormulario;
 
         $tipoOperacion="Registrar nuevo Módulo: ".$nombreModulo;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 1006_modulos(idResponsable,fechaCreacion,nombreModulo,idPadre,vista,icon_menu,situacion)VALUES('".$idUsuarioSesion."',
            '".$fechaActual."','".$nombreModulo."','".$moduloPadre."','".$nomFormulario."','".$nomIcono."','1')";
        
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarModificacionModulos()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idModulo=$obj->idModulo;
        $nombreModulo=$obj->nombreModulo;
        $moduloPadre=$obj->moduloPadre;
        $nomIcono=$obj->nomIcono;
        $nomFormulario=$obj->nomFormulario;
        $situacion=$obj->situacion;
 
         $tipoOperacion="Realiza cambios a Modulos: ".$idModulo;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1006_modulos SET nombreModulo='".$nombreModulo."',idPadre='".$moduloPadre."',vista='".$nomFormulario."',icon_menu='".$nomIcono."',situacion='".$situacion."' WHERE idModulo='".$idModulo."'";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }   
    }

    function cambiarSituacionProveedores()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idModulo=$obj->idModulo;
        $estado=$obj->estado;

        $tipoOperacion="Modifica situacion Modulos: ".$idModulo." situacion: ".$estado;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1006_modulos SET situacion='".$estado."' WHERE idModulo='".$idModulo."'";
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