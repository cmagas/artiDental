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
                obtenerListadoPacientes();
        break;
        case 2:
                llenarComboMunicipios();
        break;
        case 3:
                llenarComboMunicipioModificar();
        break;
        case 4:
                modificarDatosPacientes();
        break;
        
        
    }

    function obtenerListadoPacientes()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 3005_pacientes ORDER BY idPaciente";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombreCompleto=$fila[3]." ".$fila[4]." ".$fila[5];
            $fechaAlta=cambiarFormatoFecha($fila[2]);

            $o='{"":"","id":"'.$fila[0].'","fechaCreacion":"'.$fila[2].'","fechaAlta":"'.$fechaAlta.'","nombreCompleto":"'.$nombreCompleto.'","nombre":"'.$fila[3].'","apPaterno":"'.$fila[4].'",
                "apMaterno":"'.$fila[5].'","email":"'.$fila[6].'","rfc":"'.$fila[7].'","genero":"'.$fila[8].'","telefono":"'.$fila[9].'",
                "fechaNac":"'.$fila[10].'","estado":"'.$fila[11].'","municipio":"'.$fila[12].'","calle":"'.$fila[13].'",
                "numero":"'.$fila[14].'","colonia":"'.$fila[15].'","codPostal":"'.$fila[16].'","localidad":"'.$fila[17].'",
                "fotoPerfil":"'.$fila[18].'","peso":"'.$fila[19].'","estatura":"'.$fila[20].'","situacion":"'.$fila[21].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function llenarComboMunicipios()
    {
        global $con;

        $cveEstado=$_POST['cveEstado'];

        $consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveEstado='".$cveEstado."' ORDER BY municipio";
        $resultadoM=$con->obtenerFilas($consulta);
    
        $html="<option value='-1'>Seleccionar Municipio</option>";
    
        while($rowM=mysql_fetch_row($resultadoM))
        {
            $html.= "<option value='".$rowM[0]."'>".$rowM[1]."</option>";
        }
        
        echo $html;
    }

    function llenarComboMunicipioModificar()
    {
        global $con;

        $cveEstado=$_POST['cveEstado'];

        $consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveEstado='".$cveEstado."' ORDER BY municipio";
        $resultadoM=$con->obtenerFilas($consulta);
    
        $html="<option value='-1'>Seleccionar Municipio</option>";
    
        while($rowM=mysql_fetch_row($resultadoM))
        {
            $html.= "<option value='".$rowM[0]."'>".$rowM[1]."</option>";
        }
        
        echo $html;
    }

    function modificarDatosPacientes()
    {
        global $con;
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $idPaciente=$obj->idPaciente;
        $nombre=$obj->nombre;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $rfc=$obj->rfc;
        $genero=$obj->genero;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $fechaNac=$obj->fechaNac;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;
        $peso=$obj->peso;
        $estatura=$obj->estatura;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Paciente: ".$idPaciente." situacion: ".$situacion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3005_pacientes SET nombre='".$nombre."',apPaterno='".$apPaterno."',apMaterno='".$apMaterno."',email='".$email."',
            rfc='".$rfc."',genero='".$genero."',telefono='".$telefono."',fechaNacimiento='".$fechaNac."',estado='".$estado."',municipio='".$municipio."',
            calle='".$calle."',numero='".$numero."',colonia='".$colonia."',codPostal='".$codPostal."',localidad='".$localidad."',
            peso='".$peso."',estatura='".$estatura."',situacion='".$situacion."' WHERE idPaciente='".$idPaciente."'";
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