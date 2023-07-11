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
                obtenerFoliosBoleta();
        break;
        case 2:
                guardarVentaCaja();
        break;
        case 6:
                obtenerListadoProductos();
        break;
        case 7:
                obtenerProductoCodigo();
        break;
        case 8:
                verificaStockProducto();
        break;
        case 9:
                obtenerVentaPeriodo();
        break;
        case 10:
                eliminarVenta();
        break;
        case 11:
                obtenerDetalleVenta();
        break;        
        
    }

    function obtenerFoliosBoleta()
    {
        global $con;

        $idEmpresa=$_SESSION['idEmpresa'];

        $consulta="SELECT * FROM 4003_folio WHERE idEmpresa='".$idEmpresa."'";
        $res=$con->obtenerPrimeraFila($consulta);

        $resFolio=$res[3]+1;
        switch(strlen($resFolio))
        {
            case 1:
                    $folio='0000000'.$resFolio;
            break;
            case '2':
                    $folio='000000'.$resFolio;
            break;
            case '3':
                    $folio='00000'.$resFolio;
            break;
            case '4':
                $folio='0000'.$resFolio;
            break;
            case '5':
                $folio='000'.$resFolio;
            break;  
            case '6':
                $folio='00'.$resFolio;
            break;  
            case '7':
                $folio='0'.$resFolio;
            break;
            case '8':
                $folio=$resFolio;
            break;            
        }

        $o='{"serie_boleta":"'.$res[2].'","nro_venta":"'.$folio.'"}';

        echo $o;

    }

    function guardarVentaCaja()
    {
        global $con;
        $idUsuario=$_SESSION['idUsr'];
        $fechaActual=date("Y-m-d");
        $ivaProducto=0;

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $nro_boleta=$obj->nro_boleta;
        $total_venta=$obj->total_venta;
        $subTotal = $obj->subtotal;
        $ivaTotal = $obj->ivaTotal;
        $descripcion="Venta realizada con Nro Boleta: ".$nro_boleta;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO venta_cabecera(idResponsable,fecha_venta,nro_boleta,descripcion,subtotal,iva,total_venta,formaPago,
                totalFfectivo,totalTarjeta,numTarjeta)VALUES('".$idUsuario."','".$fechaActual."','".$nro_boleta."','".$descripcion."',
                '".$subTotal."','".$ivaTotal."','".$total_venta."','1','0','0','0')";
        $x++;

        $consulta[$x]="set @idRegistro:=(select last_insert_id())";
	    $x++;

        $consulta[$x]="UPDATE 4003_folio SET nro_correlativo_venta='".$nro_boleta."' WHERE idFolio='1'";
        $x++;


        
        foreach($obj->arrProductos as $p)
	    {
            $codigo_producto=$p->codigo_producto;
            $cantidad=$p->cantidad;
            $total=$p->total;
            $ivaP=$p->valorImpuesto;
            $precioVenta=$p->precio_venta_producto;
            $idProducto=$p->idProducto;

            if($ivaP>0)
            {
                $ivaProducto=$cantidad*$ivaP;
            }

            $consulta[$x]="INSERT INTO venta_detalle(idVenta,nro_boleta,codigo_producto,cantidad,precioVenta,iva,total_venta,idProducto)VALUES(@idRegistro,
            '".$nro_boleta."','".$codigo_producto."','".$cantidad."','".$precioVenta."','".$ivaProducto."','".$total."','".$idProducto."')";
            $x++;

            $consulta[$x]="UPDATE 3001_productos2 SET stock_producto= stock_producto - '".$cantidad."' WHERE idProducto='".$idProducto."'";
            $x++;

        }

        $consulta[$x]="commit";
        $x++;
        if($con->ejecutarBloque($consulta))
        {
            echo "1|";
        }
        
    }

    function obtenerListadoProductos()
    {
        global $con;

        $x=1;
        $arrRegistro1="";

        $hoy=date("Y-m-d");

        $consulta="SELECT CONCAT(codigo_producto,' - ',c.nombre_categoria,' - ',p.descripcion_producto,' - $',p.precioVenta ) AS descripcion_producto 
                FROM 3001_productos2 p,4001_categorias c WHERE p.idCategoria=c.id_categoria and p.situacion='1' AND p.stock_producto>0";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
        {
            $o='{"descripcion_producto":"'.$fila[0].'"}';

            if($arrRegistro1=="")
                $arrRegistro1=$o;
            else
                $arrRegistro1.=",".$o;
            
        }

        echo "1|[".$arrRegistro1."]";

    }

    function obtenerProductoCodigo()
    {
        global $con;
        $codigoProducto="";
        $valorImpuesto=0;

        if(isset($_POST["codigo_producto"]))
            $codigoProducto=$_POST["codigo_producto"];

        $consulta="SELECT * FROM 3001_productos2 WHERE codigo_producto='".$codigoProducto."' AND stock_producto>0";
        $resp=$con->obtenerPrimeraFila($consulta);

        $idCategoria=$resp[4];

        $consulCate="SELECT * FROM 4001_categorias WHERE id_categoria='".$idCategoria."'";
        $resCat=$con->obtenerPrimeraFila($consulCate);

        $precioVenta=cambiarFormatoMoneda($resp[8],2);
        $aplicaPeso=$resCat[5];
        $tipoImpuesto=$resp[5];
        if($tipoImpuesto==2)
        {
            $valorImpuesto=cambiarFormatoMoneda($resp[8]-($resp[8]/1.16),2);
        }

        $o='{"id":"'.$resp[0].'","codigo_producto":"'.$resp[3].'","id_categoria":"'.$resp[4].'","nombre_categoria":"'.$resCat[3].'",
        "descripcion_producto":"'.$resp[6].'","cantidad":"1","precio_venta_producto":"'.$precioVenta.'","total":"'.$precioVenta.'",
        "acciones":"","aplica_peso":"'.$aplicaPeso.'","precio_mayor_producto":"'.$resp[15].'","precio_oferta_producto":"'.$resp[16].'",
        "idImpuesto":"'.$tipoImpuesto.'","valorImpuesto":"'.$valorImpuesto.'"}';

        echo $o;
    }

    function verificaStockProducto()
    {
        global $con;

        $codigoProducto=-1;
        $cantidad=0;

        if(isset($_POST["codigo_producto"]))
            $codigoProducto=$_POST["codigo_producto"];

        if(isset($_POST["cantidad_a_comprar"]))
            $cantidad=$_POST["cantidad_a_comprar"];

        $consulta="SELECT COUNT(*) AS existe FROM 3001_productos2 p WHERE p.codigo_producto='".$codigoProducto."' 
                    AND p.stock_producto>'".$cantidad."'";
        $res=$con->obtenerValor($consulta);

        $o='{"existe":"'.$res.'"}';

        echo $o;
               

    }

    function obtenerVentaPeriodo()
    {
        global $con;
        $ventas="";


        $fechaDesde=date("Y-m-d");
        $fechaHasta=date("Y-m-d");

        if(isset($_POST["fechaDesde"]))
            $fechaDesde=$_POST["fechaDesde"];

        if(isset($_POST["fechaHasta"]))
            $fechaHasta=$_POST["fechaHasta"];

        $consulta="SELECT id_boleta,nro_boleta,fecha_venta,total_venta FROM venta_cabecera 
            WHERE fecha_venta BETWEEN '".$fechaDesde."' AND '".$fechaHasta."' AND situacion='1'";
        $resp=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($resp))
	    {
            $text="Boleta Nro: ".$fila[1]." - Total venta: $".$fila[3];

            $consulDetalle="SELECT vd.idDetalleVenta,vd.idProducto,vd.codigo_producto,vd.cantidad,vd.total_venta,p.idCategoria,
                    c.nombre_categoria,c.aplica_peso,p.descripcion_producto FROM venta_detalle vd,3001_productos2 p, 4001_categorias c 
                WHERE vd.idProducto=p.idProducto AND p.idCategoria=c.id_categoria AND vd.idVenta='".$fila[0]."'";
            $resDetalle=$con->obtenerFilas($consulDetalle);

            while($row=mysql_fetch_row($resDetalle))
	        {
                if($row[7]==1)
                {
                    $cantidad=$row[3]." Kg(s)";
                }
                else{
                    $cantidad=$row[3]." Und(s)";
                }

                $totalVenta="$ ".$row[4];

                $o='{"id":"","nro_boleta":"'.$text.'","codigo_producto":"'.$row[2].'","nombre_categoria":"'.$row[6].'","descripcion_producto":"'.$row[8].'","cantidad":"'.$cantidad.'","total_venta":"'.$totalVenta.'","fecha_venta":"'.$fila[2].'"}';

                if($ventas=="")
                    $ventas=$o;
                else
                    $ventas.=",".$o;

            }
        }

        echo '{"data":['.$ventas.']}';

    }

    function eliminarVenta()
    {
        global $con;
        $folioBoleta=-1;

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        
        $folioBoleta=$obj->nroBoleta;

        $tipoOperacion="Elimina Venta Boleta ".$folioBoleta;

        $consulDato="SELECT * FROM venta_detalle WHERE nro_boleta='".$folioBoleta."'";
        $res=$con->obtenerFilas($consulDato);

        $x=0;
        $consulta[$x]="begin";
        $x++;

        while($fila=mysql_fetch_row($res))
		{
            $idProducto=$fila[8];
            $cantidad=$fila[4];

            $consulta[$x]="UPDATE 3001_productos2 SET stock_producto=(stock_producto + '".$cantidad."') WHERE idProducto='".$idProducto."'";
            $x++;

        }

        $consulta[$x]="UPDATE venta_cabecera SET situacion='0' WHERE nro_boleta='".$folioBoleta."'";
        $x++;
        
        $consulta[$x]="commit";
        $x++;
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(3,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }         
        
    }

    function obtenerDetalleVenta()
    {
        global $con;
        $nro_boleta='-1';
        $result="";
        $x=0;

        if(isset($_POST["nro_boleta"]))
            $nro_boleta=$_POST["nro_boleta"];

        $consulta="SELECT v.idDetalleVenta AS id,v.nro_boleta,v.codigo_producto,c.nombre_categoria,p.descripcion_producto,v.cantidad,ROUND(v.total_venta,2) AS total_venta 
        FROM venta_detalle v, 3001_productos2 p, 4001_categorias c WHERE v.idProducto=p.idProducto AND p.idCategoria=c.id_categoria 
        AND v.nro_boleta='".$nro_boleta."' ORDER BY v.codigo_producto";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $x++;
            $o='{"id":"'.$fila[0].'","nro_boleta":"'.$fila[1].'","codigo_producto":"'.$fila[2].'",
            "nombre_categoria":"'.$fila[3].'","descripcion_producto":"'.$fila[4].'","cantidad":"'.$fila[5].'",
            "total_venta":"'.$fila[6].'"}';

            if($result=="")
				$result=$o;
			else
				$result.=",".$o;
        }

        $numero_filas_filtradas=$x;

        $output=array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $numero_filas_filtradas,
            'recordsFiltered' => $numero_filas_filtradas,
            'data' => $result
        );

        //echo '{"data":['.$result.']}';

       echo '{"recordsTotal":"'.$numero_filas_filtradas.'","recordsFiltered":"'.$numero_filas_filtradas.'","data":['.$result.']}';

    }

?>