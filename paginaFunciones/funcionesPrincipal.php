<?php
   // session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
   

    //$idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
            obtenerListadoAgenda();
        break;
    }

    function obtenerListadoAgenda()
    {
        global $con;
        
        $arrRegistro="";
        $o='';

        $fechaCita='2023-01-01';
        $horaCita='12:00';

        if(isset($_POST["fechaMysl"]))
            $fechaCita=$_POST["fechaMysl"];

        if(isset($_POST["horaCita"]))
            $horaCita=$_POST["horaCita"];            



    
        //$fechaCita=$obj->fechaMysl;
        //$horaCita=$obj->horaCita;

        $consulta="SELECT idAgendaEvento,idPaciente FROM 3002_agendaEvento WHERE fechaCita='".$fechaCita."' AND HoraCita='".$horaCita."' AND situacion='1'";
        //echo $consulta."<br>";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
        {
            $idPaciente=$fila[1];
            $nombrePaciente=obtenerNombrePaciente($idPaciente);
            $o='{"nombre":"'.$nombrePaciente.'","indice":"'.$fila[0].'"}';
        }

        echo $o;
      //varDump("aqui 2",$o);
    }

    

?>