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
                obtenerDatosIniciales();
        break;
        case 2:
                obtenerDatosGrafica();
        break;
        case 3:
                obtenerMasVendidos();
        break;
        case 4:
            //obtenerProductosStock();
        break;
        case 5:
                obtenerListadoProductos();
        break;
        case 6:
                guardarNuevoRegistro();
        break;
        case 7:
                actualizarProductos();
        break;
        case 8:
                cambiarSituacionProducto();
        break;

    }

    function obtenerDatosIniciales()
    {
        global $con;

        $hoy=date("Y-m-d");

        $consultaTV="SELECT SUM(total_venta) FROM venta_cabecera";
        $resTV=$con->obtenerValor($consultaTV);

        $consultaVentaDia="SELECT SUM(total_venta) FROM venta_cabecera WHERE fecha_Venta='".$hoy."'";
        $ventaDia=$con->obtenerValor($consultaVentaDia);

        $consultaNumoperacion="SELECT COUNT(id_boleta) FROM venta_cabecera WHERE fecha_venta='".$hoy."'";
        $nuOperacion=$con->obtenerValor($consultaNumoperacion);

        if($resTV)
        {
            $totalVenta=cambiarFormatoMoneda($resTV);
        }
        else{
            $totalVenta=0;
        }

        if($ventaDia)
        {
            $tVentaDia=cambiarFormatoMoneda($ventaDia);
        }
        else{
            $tVentaDia=0;
        }

        if($nuOperacion)
        {
            $numOperaciones=$nuOperacion;
        }
        else{
            $numOperaciones=0;
        }

        $totalCompras="$ 0.00";

        $o='{"totalVenta":"'.$totalVenta.'","tVentaDia":"'.$tVentaDia.'","numOperaciones":"'.$numOperaciones.'","totalCompras":"'.$totalCompras.'"}';

       echo "1|".$o;
    }

    function obtenerDatosGrafica()
    {
        global $con;
        $x=1;
        $arrRegistro1="";

        $hoy=date("Y-m-d");
        $anioActual=date("Y");
        $mesActual=date("m");
        $totalDiaMes=date("t");

        while($x<=$totalDiaMes)
        {
            $dia=$x;
            if($x<10)
                $dia="0".$x;

            $fechaConsulta=$anioActual."-".$mesActual."-".$dia;

            $consulta="SELECT SUM(total_venta) FROM venta_cabecera WHERE fecha_venta='".$fechaConsulta."'";
            $res=$con->obtenerValor($consulta);

            if($res>0)
            {
                $o='{"fechaVenta":"'.$fechaConsulta.'","importeDia":"'.$res.'"}';

                if($arrRegistro1=="")
				    $arrRegistro1=$o;
			    else
				    $arrRegistro1.=",".$o;
            }

            $x++;
        }

        echo "1|[".$arrRegistro1."]";

    }

    function obtenerMasVendidos()
    {
        global $con;
        $arrRegistro="";

        $consulta="SELECT p.codigo_producto,p.descripcion_producto,SUM(v.cantidad) AS cantidad,SUM(ROUND(v.total_venta,2)) AS total_venta 
        FROM 3001_productos p, venta_detalle v WHERE p.codigo_producto=v.codigo_producto GROUP BY p.codigo_producto,p.descripcion_producto
        ORDER BY SUM(ROUND(v.total_venta,2)) DESC LIMIT 10 ";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $o='{"codigo":"'.$fila[0].'","descripcion":"'.$fila[1].'","cantidad":"'.$fila[2].'","totalVenta":"'.$fila[3].'"}';

            if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

        echo "1|[".$arrRegistro."]";

    }

    function obtenerListadoProductos()
    {
        global $con;
        $arrRegistro="";

        $consulta="SELECT * FROM 3001_productos2 ORDER BY idProducto";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           $nomCategoria=obtenerNombreCategoria($fila[4]);
           $precioCompra=round($fila[7],2);
           $precioVenta=round($fila[8],2);

            $o='{"":"","id":"'.$fila[0].'","codigo":"'.$fila[3].'","idCategoria":"'.$fila[4].'","categoria":"'.$nomCategoria.'",
            "producto":"'.$fila[6].'","precioCompra":"'.$precioCompra.'","precioVenta":"'.$precioVenta.'","utilidad":"'.$fila[9].'",
            "stockMax":"'.$fila[10].'","stockMin":"'.$fila[11].'","ventas":"'.$fila[12].'","stock_producto":"'.$fila[13].'",
            "fechaCreacion":"'.$fila[2].'","fechaAct":"'.$fila[14].'","idImpuesto":"'.$fila[5].'","situacion":"'.$fila[17].'"}';
			
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
    
        $codBar=$obj->codBar;
        $idCategoria=$obj->idCategoria;
        $idImpuesto=$obj->idImpuesto;
        $producto=$obj->producto;
        $precioCompra=$obj->precioCompra;
        $precioVenta=$obj->precioVenta;
        $utilidad=$obj->utilidad;
        $stockMaximo=$obj->stockMaximo;
        $stockMinimo=$obj->stockMinimo;
 
         $tipoOperacion="Registrar nuevo Producto: ".$codBar;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 3001_productos2(idResponsable,fechaCreacion,codigo_producto,idCategoria,
                    idImpuesto,descripcion_producto,precioCompra,precioVenta,utilidad,stockMaximo,stockMinimo,
                    stock_producto,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$codBar."','".$idCategoria."','".$idImpuesto."','".$producto."','".$precioCompra."',
                    '".$precioVenta."','".$utilidad."','".$stockMaximo."','".$stockMinimo."','0','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function actualizarProductos()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idProducto=$obj->idProducto;
        $codBar=$obj->codBar;
        $idCategoria=$obj->idCategoria;
        $idImpuesto=$obj->idImpuesto;
        $producto=$obj->producto;
        $precioCompra=$obj->precioCompra;
        $precioVenta=$obj->precioVenta;
        $utilidad=$obj->utilidad;
        $stockMaximo=$obj->precioVenta;
        $stockMinimo=$obj->utilidad;
        $situacion=$obj->situacion;
 
         $tipoOperacion="Realiza cambios a Producto: ".$idProducto;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3001_productos2 SET codigo_producto='".$codBar."',idCategoria='".$idCategoria."',idImpuesto='".$idImpuesto."',
        descripcion_producto='".$producto."',precioCompra='".$precioCompra."',precioVenta='".$precioVenta."',utilidad='".$utilidad."',
        stockMaximo='".$stockMaximo."',stockMinimo='".$stockMinimo."',situacion='".$situacion."' WHERE idProducto='".$idProducto."'";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }         
    }

    function cambiarSituacionProducto()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idProducto=$obj->idProducto;
        $estado=$obj->estado;

        $tipoOperacion="Modifica situacion Producto: ".$idProducto." situacion: ".$estado;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3001_productos2 SET situacion='".$estado."' WHERE idProducto='".$idProducto."'";
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