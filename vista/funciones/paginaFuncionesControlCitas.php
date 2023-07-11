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
                obtenerCitasActivas();
        break;
        case 2:
                cancelarCita();
        break;
        case 3:
                guardarDatosConsulta();
        break;
       
    }

    function obtenerCitasActivas()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 3002_agendaEvento where situacion='1' ORDER BY fechaCita,HoraCita";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombrePaciente=obtenerNombrePaciente($fila[3]);
            $fechaCita=cambiarFormatoFecha($fila[5]);

            $o='{"":"","id":"'.$fila[0].'","idPaciente":"'.$fila[3].'","nombrePaciente":"'.$nombrePaciente.'",
            "fechaCita":"'.$fechaCita.'","fechaCitaSistema":"'.$fila[5].'","horaCita":"'.$fila[6].'","comentarios":"'.$fila[4].'","situacion":"'.$fila[7].'"}';

            if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }
        echo '{"data":['.$arrRegistro.']}';
    }

    function cancelarCita()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idCita=$obj->idCita;
        $estado=$obj->estado;

        $tipoOperacion="Modifica situacion Cita: ".$idCita." situacion: ".$estado;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3002_agendaEvento SET situacion='0' WHERE idAgendaEvento='".$idCita."'";
        $x++;

        $consulta[$x]="commit";
        $x++;

        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(3,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarDatosConsulta()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $idTipoConsulta=$obj->idTipoConsulta;
        $data=$obj->data;
        $idCita=$obj->idCita;
        $idPaciente=$obj->idPaciente;

        $tipoOperacion="Registrar Historial Cita: ".$idCita;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 3010_registroClinico(idResponsable,fechaCreacion,idPaciente,idCita,idTipoConsulta,informe,situacion)VALUES('".$idUsuarioSesion."',
        '".$fechaActual."','".$idPaciente."','".$idCita."','".$idTipoConsulta."','".$data."','1')";
        $x++;

        $consulta[$x]="UPDATE 3002_agendaEvento SET situacion='2' WHERE idAgendaEvento='".$idCita."'";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 

    }
?>    