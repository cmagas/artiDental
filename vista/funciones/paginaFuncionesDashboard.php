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
                obtenerDatosIniciales();
        break;
        case 2:
                obtenerCitaspendientesMes();
        break;
        case 3:
                obtenerPacientesAtendidos();
        break;
        case 4:
                guardarCitaPaciente();
        break;
        case 5:
                obtenerListadoAgenda();
        break;
        case 6:
                cancelarCita();
        break;
        case 7:
                obtenerHorarioCita();
        break;
      

    }

    function obtenerDatosIniciales()
    {
        global $con;
        $hoy=date("Y-m-d");
        $citaMes=0;
        $citaDia=0;
        $totalVentaMes="$ 0.00";
        $totalVentaDia="$ 0.00";

        $mes=date("m");
        $anio=date("Y");
        $dia=date("d");

        //SELECT * FROM nombre_de_tabla WHERE YEAR(campo_fecha) = 'año_deseado' AND MONTH(campo_fecha) = 'mes_deseado';

        $consulta1="SELECT COUNT(idAgendaEvento) FROM 3002_agendaEvento WHERE YEAR(fechaCita)='".$anio."' AND MONTH(fechaCita)='".$mes."' AND situacion IN(1,2)";
        $res1=$con->obtenerValor($consulta1);

        if($res1)
        {
            $citaMes=$res1;
        }

        $consulta2="SELECT COUNT(idAgendaEvento) FROM 3002_agendaEvento WHERE fechaCita='".$hoy."' AND situacion IN(1,2)";
        $res2=$con->obtenerValor($consulta2);

        if($res2)
        {
            $citaDia=$res2;
        }

        $consulta3="SELECT SUM(total_venta) FROM venta_cabecera WHERE YEAR(fecha_venta)='".$anio."' AND MONTH(fecha_venta)='".$mes."' AND situacion='1'";
        $res3=$con->obtenerValor($consulta3);

        if($res3)
        {
            $totalVentaMes=cambiarFormatoMoneda($res3);
        }

        $consulta4="SELECT SUM(total_venta) FROM venta_cabecera WHERE fecha_venta='".$hoy."' AND situacion='1'";
        $res4=$con->obtenerValor($consulta4);

        if($res4)
        {
            $totalVentaDia=cambiarFormatoMoneda($res4);
        }


        $o='{"citaMes":"'.$citaMes.'","citaDia":"'.$citaDia.'","ventaMes":"'.$totalVentaMes.'","ventaDia":"'.$totalVentaDia.'"}';

        echo $o;
    }

    function obtenerCitaspendientesMes()
    {
        global $con;
        $hoy=date("Y-m-d");
        $mes=date("m");
        $anio=date("Y");
        $arrRegistro="";

        $consulta="SELECT * FROM 3002_agendaEvento WHERE YEAR(fechaCita)='".$anio."' AND MONTH(fechaCita)='".$mes."' AND situacion='1' ORDER BY fechaCita LIMIT 0,10 ";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombrePaciente=obtenerNombrePaciente($fila[3]);
            $fechaCita=cambiarFormatoFecha($fila[5]);

            $o='{"idPaciente":"'.$fila[3].'","nombrePaciente":"'.$nombrePaciente.'","fechaCita":"'.$fechaCita.'","horaCita":"'.$fila[6].'"}';

            if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

        echo "[".$arrRegistro."]";

    }

    function obtenerPacientesAtendidos()
    {
        global $con;
        $hoy=date("Y-m-d");
        $mes=date("m");
        $anio=date("Y");
        $arrRegistro="";

        $consulta="SELECT * FROM 3002_agendaEvento WHERE YEAR(fechaCita)='".$anio."' AND MONTH(fechaCita)='".$mes."' AND situacion='2' ORDER BY fechaCita DESC LIMIT 0,10";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombrePaciente=obtenerNombrePaciente($fila[3]);
            $fechaCita=cambiarFormatoFecha($fila[5]);

            $o='{"idPaciente":"'.$fila[3].'","nombrePaciente":"'.$nombrePaciente.'","fechaCita":"'.$fechaCita.'","horaCita":"'.$fila[6].'"}';

            if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

        echo "[".$arrRegistro."]";
    }
    
    function guardarCitaPaciente()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $valorPaciente=$obj->idPaciente;
        $fechaCita=$obj->fechaCita;
        $horaCita=$obj->horaCita;
        $comentarios=$obj->comentarios;

        $datos=explode("_",$valorPaciente);
        $idPaciente=$datos[0];

        //echo " fechaCita ".$fechaCita." hora Cita ".$horaCita;
        
 
         $tipoOperacion="Registrar nueva Cita: ".$idPaciente;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 3002_agendaEvento(idResponsable,fechaCreacion,idPaciente,descripcion,fechaCita,HoraCita,situacion)VALUES('".$idUsuarioSesion."',
        '".$fechaActual."','".$idPaciente."','".$comentarios."','".$fechaCita."','".$horaCita."','1')";
        //echo $consulta[$x];
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
        
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

    function cancelarCita()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idCita=$obj->idCita;
        

        $tipoOperacion="Modifica situacion Almacen: ".$idCita." situacion: Cancelada";

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

    function obtenerHorarioCita()
    {
        global $con;
        $fechaCita=$_POST['fechaCita'];
        $horaCita=$_POST['horaCita'];

        //echo "horarioAsignado ".$horarioAsignado;

        $consulta="SELECT horaInicio,horaFinal FROM 4006_horarioServicio WHERE horaInicio='".$horaCita."'";
        $resultadoM=$con->obtenerPrimeraFila($consulta);

        $horaMuestra=$resultadoM[0]." - ".$resultadoM[1];
    
        $html="<option value='".$resultadoM[0]."'>".$horaMuestra."</option>";
    
        echo $html;
    }

?>    