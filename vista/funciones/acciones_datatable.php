<?php
  include_once("latis/conexionBD.php");

    if($_POST['action']=='edit')
    {
        $data= array(
            'codigo_producto' =>$_POST['codigo_producto'],
            'cantidad' =>$_POST['cantidad'],
            'id' =>$_POST['id']
        );

        $valor="codigo__producto ".$_POST['codigo_producto']." cantidad ".$_POST['cantidad']." id ".$_POST['id'];

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consul="SELECT v.idVenta,p.idImpuesto,v.precioVenta FROM venta_detalle v,3001_productos2 p WHERE v.idProducto=p.idProducto 
        AND idDetalleVenta='".$data['id']."'";
        $resp=$con->obtenerPrimeraFila($consul);

        $idVenta=$resp[0];
        $idImpuesto=$resp[1];
        $precioVenta=$resp[2];
        $valorIVA=0;

        if($idImpuesto==1)
        {
            $valorIVA=(($precioVenta*.16) * $data['cantidad']);
        }

        $consulta[$x]="UPDATE venta_detalle SET codigo_producto='".$data['codigo_producto']."',cantidad='".$data['cantidad']."',
            iva='".$valorIVA."',total_venta= ((cantidad * precioVenta)+ iva)
        WHERE idDetalleVenta='".$data['id']."'";
        $x++;

        $consul2="SELECT SUM(total_venta) FROM venta_detalle WHERE idVenta='".$idVenta."'";
        $vtotal=$con->ejecutarConsulta($consul2);

        $consulta[$x]="UPDATE venta_cabecera SET total_venta='' WHERE id_boleta=''";
        $x++;

        
        if($con->ejecutarConsulta($consulta))
        {
            echo '{"data":['.$_POST.']}';
        }

    }

    if($_POST['action']=='delete')
    {
        $data= array(
            'codigo_producto' =>$_POST['codigo_producto'],
            'cantidad' =>$_POST['cantidad'],
            'id' =>$_POST['id']
        );
    }



?>