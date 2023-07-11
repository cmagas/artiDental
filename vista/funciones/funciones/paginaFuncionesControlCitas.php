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
                obtenerListadoCitasMedicas();
        break;
        
        
    }

    function obtenerListadoCitasMedicas()
    {
        global $con;

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 3002_agendaEvento WHERE situacion='1' ORDER BY fechaCita,HoraCita";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombrePaciente=obtenerNombrePaciente($fila[2]);
            $fechaCita=cambiarFormatoFecha($fila[4]);

            $o='{"":"","id":"'.$fila[0].'","idPaciente":"'.$fila[2].'","nombrePaciente":"'.$nombrePaciente.'",
            "fechaCita":"'.$fechaCita.'","fechaCitaSistema":"'.$fila[4].'","horaCita":"'.$fila[5].'","comentarios":"'.$fila[3].'","situacion":"'.$fila[6].'"}';

            if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }
        echo '{"data":['.$arrRegistro.']}';
    }

?>    