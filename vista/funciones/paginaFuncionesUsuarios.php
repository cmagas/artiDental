<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    include_once("cajaPos/funcionesProductos.php");


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];

       // varDump($_POST);

    switch($funcion)
    {
        case 1:
                obtenerListadoUsuarios();
        break;
        case 2:
                llenarComboMunicipios();
        break;
        case 3:
                guardarRegistroUsuario();
        break;
        case 4:
                obtenerMunicipio();
        break;
        case 5:
                guardarCambiosUsuario();
        break;
        case 6:
                guardarCambiosFotoUsuario();
        break;
        
    }

    function obtenerListadoUsuarios()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT u.idUsuario,u.usu_nombre,u.usu_contrasena,u.usu_sexo,u.nombre,u.apPaterno,u.apMaterno,u.idPerfilUsuario,u.situacion,
        e.fechaNacimiento,e.rfc,e.telMovil,e.email,e.estado,e.municipio,e.localidad,e.fotoPerfil FROM 1000_usuarios u,1001_identifica e 
        WHERE u.idUsuario=e.idUsuario  AND u.situacion!='3' ORDER BY u.idUsuario";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombreCompleto=$fila[4]." ".$fila[5]." ".$fila[6];
            $nombrePerfil=obtenerNombrePerfil($fila[7]);

            $o='{"":"","id":"'.$fila[0].'","nombreCompleto":"'.$nombreCompleto.'","genero":"'.$fila[3].'","nombre":"'.$fila[4].'",
                "apPaterno":"'.$fila[5].'","apMaterno":"'.$fila[6].'","fechaNac":"'.$fila[9].'","rfc":"'.$fila[10].'",
                "telmovil":"'.$fila[11].'","email":"'.$fila[12].'","estado":"'.$fila[13].'","municipio":"'.$fila[14].'",
                "localidad":"'.$fila[15].'","fotoPerfil":"'.$fila[16].'","usuario":"'.$fila[1].'","passw":"'.$fila[2].'",
                "situacion":"'.$fila[8].'","idPerfil":"'.$fila[7].'","nombrePerfil":"'.$nombrePerfil.'"}';
			
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

    function guardarRegistroUsuario()
    {
        global $con;
        $ruta="";
        $nombreFotoFinal="";

        $idUsuarioSesion=$_SESSION['idUsr'];
 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombre=$obj->nombre;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $rfc=$obj->rfc;
        $genero=$obj->genero;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $localidad=$obj->localidad;
        $usuario=$obj->usuario;
        $pass1=$obj->pass1;
        $idPerfil=$obj->perfil;
        $fechaNac=$obj->fechaNac;
        $nombreFoto=$obj->nombreFoto;
        $foto=$obj->fotoObj;

        //varDump($_POST);
        

        

         $tipoOperacion="Registrar nuevo Usuario: ".$nombre;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 1000_usuarios(idResponsable,fechaRegistro,usu_nombre,usu_contrasena,usu_sexo,nombre,apPaterno,apMaterno,idPerfilUsuario,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$usuario."','".$pass1."','".$genero."','".$nombre."','".$apPaterno."','".$apMaterno."','".$idPerfil."','1')";
        $x++;

        $consulta[$x]="set @idRegistro:=(select last_insert_id())";
        $x++;

        $consulta[$x]="INSERT INTO 1001_identifica(idUsuario,fechaNacimiento,rfc,telMovil,email,estado,municipio,localidad,fotoPerfil)VALUES(@idRegistro,
        '".$fechaNac."','".$rfc."','".$telefono."','".$email."','".$estado."','".$municipio."','".$localidad."','".$ruta."')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            if(!empty($nombreFoto)){
                if(move_uploaded_file($_FILES['.$foto.']['tmp_name'],"foto/".$nombreFoto))
                {
                    echo "1|";
                }
            }
            echo "1|";
        }else{
            echo "0|";
        }
        
    }

    function obtenerMunicipio()
    {
        global $con;
        $cveMunicipio=$_POST['mpio'];

        $consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveMunicipio='".$cveMunicipio."'";
        $resultadoM=$con->obtenerPrimeraFila($consulta);
    
        $html="<option value='".$resultadoM[0]."'>".$resultadoM[1]."</option>";
    
        echo $html;
    }

    function guardarCambiosUsuario()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombre=$obj->nombre;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $rfc=$obj->rfc;
        $genero=$obj->genero;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $localidad=$obj->localidad;
        $usuario=$obj->usuario;
        $pass1=$obj->pass1;
        $idUsuario=$obj->idUsuario;
        $idPerfil=$obj->idPerfil;
        $situacion=$obj->situacion;
        $fechaNac=$obj->fechaNac;
 
         $tipoOperacion="Modifica datos de Usuario: ".$idUsuario;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1000_usuarios SET usu_nombre='".$usuario."',usu_contrasena='".$pass1."',usu_sexo='".$genero."',nombre='".$nombre."',
            apPaterno='".$apPaterno."',apMaterno='".$apMaterno."',idPerfilUsuario='".$idPerfil."',situacion='".$situacion."' WHERE idUsuario='".$idUsuario."'";
        $x++;

        $consulta[$x]="UPDATE 1001_identifica SET fechaNacimiento='".$fechaNac."', rfc='".$rfc."',telMovil='".$telefono."',email='".$email."',
                estado='".$estado."',municipio='".$municipio."',localidad='".$localidad."' WHERE idUsuario='".$idUsuario."'";
        $x++;

        $consulta[$x]="commit";
        $x++;


        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }  

    }

    function obtenerNombrePerfil($id)
    {
        global $con;
        $perfil="";

        $consulta="SELECT nombrePerfil FROM 1004_perfiles WHERE idPerfil='".$id."'";
        $res=$con->obtenerValor($consulta);

        if($res)
        {
            $perfil=strtoupper($res);
        }

        return $perfil;
    }

    function guardarCambiosFotoUsuario()
    {
        varDump($_POST);
    }

?>    