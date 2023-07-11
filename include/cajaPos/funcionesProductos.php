<?php
    
    function obtenerNombreCategoria($id)
    {
        global $con;

        $consulta="SELECT nombre_categoria FROM 4001_categorias WHERE id_categoria='".$id."'";
        $res=$con->obtenerValor($consulta);

        return strtoupper($res);
    }

    function obtenerNombreModulo($id)
    {
        global $con;

        $consulta="SELECT nombreModulo FROM 1006_modulos WHERE idModulo='".$id."'";
        $res=$con->obtenerValor($consulta);
        
        return strtoupper($res);
    }



?>
