<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["iptImagen"]["type"]))
    {
        session_start();
        include_once("conexionBD.php");

        //varDump($_POST);

        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $fechaAct=date("Y-m-d");

        $expe="0000";

        $subNombre=date("Ymdhis");
        $ruta="";

        $nombre=$_POST['txt_nombre'];
        $apPaterno=$_POST['txt_apPaterno'];
        $apMaterno=$_POST['txt_apMaterno'];
        $rfc=$_POST['txt_rfc'];
        $genero=$_POST['txt_genero'];
        $telefono=$_POST['txt_telefono'];
        $email=$_POST['txt_email'];
        $fechaNac=$_POST['txt_fechaNac'];
        $estado=$_POST['cmb_estado'];
        $municipio=$_POST['txt_municipio'];
        $calle=$_POST['txt_calle'];
        $numero=$_POST['txt_numero'];
        $colonia=$_POST['txt_colonia'];
        $codPostal=$_POST['txt_codPostal'];
        $localidad=$_POST['txt_Localidad'];
        $nombreFoto=$_FILES['iptImagen']['name'];
        $peso=$_POST['txt_peso'];
        $estatura=$_POST['txt_estatura'];

        $tipoOperacion="Registrar nuevo Paciente: ".$nombre;

        if($nombre!="" && $apPaterno!="" && $apMaterno!="" && $email!="" && $telefono!="")
        {

                $dir="fotos/pacientes/";

                $x=0;
                $consulta[$x]="begin";
                $x++;
        
                if($nombreFoto!="")
                {
                    $nombreArchivo=$_FILES['iptImagen']['name'];
                    $extension= obtenerExtensionFichero($_FILES['iptImagen']['name']);
        
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
        
                    if(($_FILES["iptImagen"]["type"] == "image/jpg") || ($_FILES["iptImagen"]["type"] == "image/png") || ($_FILES["iptImagen"]["type"] == "image/gif") || ($_FILES["iptImagen"]["type"] == "image/jpeg"))
                    {
                        $nombreArchivo=$_FILES['iptImagen']['name'];
                        $file_tmp_name=$_FILES['iptImagen']['tmp_name'];
                        $nombreArchivoFin="img_".$subNombre.".".$extension;
    
                        $ruta=$dir.$nombreArchivoFin;

                        //echo "$file_tmp_name ".$file_tmp_name." ruta ".$ruta;
    
                        copy($file_tmp_name, "../".$ruta);
                    }else{
                        echo "2";
                    }
                }else{
                    $ruta="fotos/default.png";
                }
        
                $consulta[$x]="INSERT INTO 3005_pacientes(idResponsable,fechaCreacion,nombre,apPaterno,apMaterno,email,rfc,genero,telefono,
                fechaNacimiento,estado,municipio,calle,numero,colonia,codPostal,localidad,fotoPerfil,peso,estatura,situacion)VALUES('".$idUsuarioSesion."',
                '".$fechaAct."','".$nombre."','".$apPaterno."','".$apMaterno."','".$email."','".$rfc."','".$genero."','".$telefono."',
                '".$fechaNac."','".$estado."','".$municipio."','".$calle."','".$numero."','".$colonia."','".$codPostal."','".$localidad."',
                '".$ruta."','".$peso."','".$estatura."','1')";
                $x++;

                $consulta[$x]="commit";
                $x++;
            
                if($con->ejecutarBloque($consulta))
                {
                    guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
                    echo "1";
                    
                }else{
                    if($nombreFoto!="")
                    {  
                        unlink($ruta);
                    }
                    echo "2";
                } 
            
        }else{
            echo "0";
        }
    }


    function obtenerExtensionFichero($str)
    {
        return end(explode(".", $str));
    }
?>