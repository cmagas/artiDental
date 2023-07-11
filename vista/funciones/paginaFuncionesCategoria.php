<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");


    $idUsuarioSesion=$_SESSION['idUsr'];
    $idEmpresaSesion=$_SESSION['idEmpresa'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoCategoria();
        break;
        case 2:
                registrarNuevaCategoria();
        break;
        case 3:
                guardarModificacionCategoria();
        break;
        
    }

    function obtenerListadoCategoria()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4001_categorias ORDER BY id_categoria";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           

            $o='{"":"","id":"'.$fila[0].'","nombreCategoria":"'.$fila[3].'","descripcion":"'.$fila[4].'","aplicaPeso":"'.$fila[5].'","situacion":"'.$fila[7].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarNuevaCategoria()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nomCategoria=$obj->nomCategoria;
        $descripcion=$obj->descripcion;
        $aplicaPeso=$obj->aplicaPeso;
 
         $tipoOperacion="Registrar nueva Categoria: ".$nomCategoria;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4001_categorias(idResponsable,fechaCreacion,nombre_categoria,descripcion,
        situacion)VALUES('".$idUsuarioSesion."','".$fechaActual."','".$nomCategoria."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarModificacionCategoria()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idCategoria=$obj->idCategoria;
        $nomCategoria=$obj->nomCategoria;
        $descripcion=$obj->descripcion;
        $aplicaPeso=$obj->aplicaPeso;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Categoria: ".$idCategoria;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4001_categorias SET nombre_categoria='".$nomCategoria."',descripcion='".$descripcion."',aplica_peso='".$aplicaPeso."',situacion='".$situacion."' WHERE id_categoria='".$idCategoria."'";
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