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
                obtenerListadoCitas();
        break;
        case 2:
                obtenerListadoPacientes();
        break;
        case 3:
                registrarNuevaCita();
        break;
        case 4:
                guardarCambiosCita();
        break;
        case 5:
                obtenerHorarioDisponible();
        break;
        case 6:
                obtenerHorarioAsignado();
        break;
        

        
    }

    function obtenerListadoCitas()
    {
        global $con;

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 3002_agendaEvento ORDER BY fechaCita,HoraCita";
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

    function obtenerListadoPacientes()
    {
        global $con;

        $x=1;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT CONCAT(idPaciente,'_',nombre,' ',apPaterno,' ',apMaterno) AS nombre FROM 3005_pacientes WHERE situacion='1'";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
        {
            $o='{"nombre":"'.$fila[0].'"}';

            if($arrRegistro=="")
                $arrRegistro=$o;
            else
                $arrRegistro.=",".$o;
            
        }

        //echo "1|[".$arrRegistro."]";
        echo "[".$arrRegistro."]";
    }

    function registrarNuevaCita()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $paciente=$obj->paciente;
        $fechaCita=$obj->fechaCita;
        $horaCita=$obj->horaCita;
        $comentarios=$obj->comentarios;

        $datos=explode("_",$paciente);
        $idPaciente=$datos[0];
        
        //echo "paciente ".$fechaCita." hora ".$horaCita;
         $tipoOperacion="Registrar nueva Cita paciente: ".$paciente;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 3002_agendaEvento(idResponsable,fechaCreacion,idPaciente,descripcion,fechaCita,HoraCita,situacion)VALUES('".$idUsuarioSesion."',
        '".$fechaActual."','".$idPaciente."','".$comentarios."','".$fechaCita."','".$horaCita."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;

        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
        
    }

    function guardarCambiosCita()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idRegistro=$obj->idRegistro;
        $fechaCita=$obj->fechaCita;
        $horaCita=$obj->horaCita;
        $comentarios=$obj->comentarios;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Cita: ".$idRegistro." situacion: ".$situacion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3002_agendaEvento SET descripcion='".$comentarios."',fechaCita='".$fechaCita."',HoraCita='".$horaCita."',
            situacion='".$situacion."' WHERE idAgendaEvento='".$idRegistro."'";
            
        $x++;

        $consulta[$x]="commit";
        $x++;

        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(3,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
        
    }

    function obtenerHorarioDisponible()
    {
        global $con;

        $fechaCita=$_POST['fechaCita'];

        $consulta="SELECT horaInicio,horaFinal FROM 4006_horarioServicio WHERE horaInicio NOT IN(SELECT HoraCita FROM 3002_agendaEvento 
        WHERE fechaCita='".$fechaCita."') AND situacion='1'";
        $resultadoM=$con->obtenerFilas($consulta);

        $html="<option value='-1'>Seleccionar Horario</option>";

        while($rowM=mysql_fetch_row($resultadoM))
        {
            $horaMuestra=$rowM[0]." - ".$rowM[1];
            $html.= "<option value='".$rowM[0]."'>".$horaMuestra."</option>";
        }
        
        echo $html;
    }

    function obtenerHorarioAsignado()
    {
        global $con;
        $horarioAsignado=$_POST['horario'];

        //echo "horarioAsignado ".$horarioAsignado;

        $consulta="SELECT horaInicio,horaFinal FROM 4006_horarioServicio WHERE horaInicio='".$horarioAsignado."'";
        $resultadoM=$con->obtenerPrimeraFila($consulta);

        $horaMuestra=$resultadoM[0]." - ".$resultadoM[1];
    
        $html="<option value='".$resultadoM[0]."'>".$horaMuestra."</option>";
    
        echo $html;
    }

    

?>    