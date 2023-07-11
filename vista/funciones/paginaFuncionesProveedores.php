<?php
    session_start();
    include_once("latis/conexionBD.php");
    include_once("latis/utiles.php");


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoProveedores();
        break;
        case 2:
                llenarComboMunicipios();
        break;
        case 3:
                registrarNuevoProveedor();
        break;
        case 4:
                llenarComboMunicipios();
        break;
        case 5:
                obtenerMunicipio();
        break;
        case 6:
                guardarModificacionProveedor();
        break;
        case 7:
                cambiarSituacionProveedores();
        break;
       
    }

    function obtenerListadoProveedores()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 3003_proveedores ORDER BY idProveedor";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           $nombreProveedor=obtenerNombreClienteProveedor($fila[0],'2');
           $nombreEstado=obtenerNombreEstado($fila[9]);

            $o='{"":"","id":"'.$fila[0].'","tipoEmpresa":"'.$fila[3].'","nombreProv":"'.$nombreProveedor.'","nombre":"'.$fila[4].'","apPaterno":"'.$fila[5].'",
            "apMaterno":"'.$fila[6].'","direccion":"'.$fila[7].'","localidad":"'.$fila[8].'","estado":"'.$fila[9].'","nomEstado":"'.$nombreEstado.'",
            "municipio":"'.$fila[10].'","telefono":"'.$fila[11].'","email":"'.$fila[12].'","rfc":"'.$fila[14].'","situacion":"'.$fila[15].'"}';
			
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

    function registrarNuevoProveedor()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $tipoEmpresa=$obj->tipoEmpresa;
        $txt_rfc=$obj->txt_rfc;
        $razonSocial=$obj->razonSocial;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $direccion=$obj->direccion;
        $localidad=$obj->localidad;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $email=$obj->email;
        $telefono=$obj->telefono;
 
         $tipoOperacion="Registrar nuevo Proveedor: ".$razonSocial;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 3003_proveedores(idResponsable,fechaCreacion,tipoEmpresa,nombre,apPaterno,
        apMaterno,direccion,localidad,estado,municipio,telefono,email,rfc,situacion)VALUES('".$idUsuarioSesion."','".$fechaActual."','".$tipoEmpresa."',
        '".$razonSocial."','".$apPaterno."','".$apMaterno."','".$direccion."','".$localidad."','".$estado."','".$municipio."',
        '".$telefono."','".$email."','".$txt_rfc."','1')";
        
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
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

    function guardarModificacionProveedor()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $txtIdProveedor=$obj->idProveedor;
        $tipoEmpresa=$obj->tipoEmpresa;
        $rfc=$obj->txt_rfc;
        $nombre=$obj->razonSocial;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $direccion=$obj->direccion;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $localidad=$obj->localidad;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $situacion=$obj->situacion;
 
         $tipoOperacion="Realiza cambios a Proveedor: ".$txtIdProveedor;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3003_proveedores SET tipoEmpresa='".$tipoEmpresa."',nombre='".$nombre."',apPaterno='".$apPaterno."',
        apMaterno='".$apMaterno."',direccion='".$direccion."',estado='".$estado."',municipio='".$municipio."',localidad='".$localidad."',
        telefono='".$telefono."',email='".$email."',rfc='".$rfc."',situacion='".$situacion."' WHERE idProveedor='".$txtIdProveedor."'";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }         
    }

    function cambiarSituacionProveedores()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idProveedor=$obj->idProveedor;
        $estado=$obj->estado;

        $tipoOperacion="Modifica situacion Proveedores: ".$idProveedor." situacion: ".$estado;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3003_proveedores SET situacion='".$estado."' WHERE idProveedor='".$idProveedor."'";
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