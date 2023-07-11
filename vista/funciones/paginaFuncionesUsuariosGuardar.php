<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["iptImagen"]["type"]))
    {
        session_start();
        include_once("conexionBD.php");

        //varDump($_POST);

        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $fechaAct=date("Y-m-d");

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
        $nombreFoto=$_FILES['iptImagen']['name'];
        $estado=$_POST['cmb_estado'];
        $municipio=$_POST['txt_municipio'];
        $localidad=$_POST['txt_Localidad'];
        $usuario=$_POST['txt_usuario'];
        $passw=$_POST['txt_cont1'];
        $passw2=$_POST['txt_cont2'];
        $idPerfil=$_POST['cmb_Perfil'];

        $tipoOperacion="Registrar nuevo Usuario: ".$nombre;

        if($nombre!="" && $apPaterno!="" && $apMaterno!="" && $email!="" && $usuario!="" && $passw!="" && $passw2!="" && $idPerfil!=-1)
        {
            
            if($passw==$passw2)
            {
                $dir="fotos/usuarios/";

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
        
                $consulta[$x]="INSERT INTO 1000_usuarios(idResponsable,fechaRegistro,usu_nombre,usu_contrasena,usu_sexo,
                    nombre,apPaterno,apMaterno,idPerfilUsuario,situacion)VALUES('".$idUsuarioSesion."','".$fechaAct."','".$nombre."',
                    '".$passw."','".$genero."','".$nombre."','".$apPaterno."','".$apMaterno."','".$idPerfil."','1')";
                $x++;
        
                $consulta[$x]="set @idRegistro:=(select last_insert_id())";
                $x++; 
        
                $consulta[$x]="INSERT INTO 1001_identifica(idUsuario,fechaNacimiento,rfc,telMovil,email,estado,municipio,
                    localidad,fotoPerfil)VALUES(@idRegistro,'".$fechaNac."','".$rfc."','".$telefono."','".$email."',
                    '".$estado."','".$municipio."','".$localidad."','".$ruta."')";
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
                echo "3";
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