<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["iptImagen"]["type"]))
    {
        session_start();
        include_once("conexionBD.php");
        include_once("utiles.php");

        $idUsuarioSesion=$_SESSION['idUsr'];
        $fechaAct=date("Y-m-d");

        $subNombre=date("Ymdhis");
        $ruta="";

        //varDump($_POST);

        $titulo=$_POST['txt_titulo'];
        $descripcion=$_POST['txt_descripcion'];
        $fecha_aplica=$_POST['txt_fecha_inicio'];
        $fecha_fin=$_POST['txt_fecha_fin'];

        $tipoOperacion="Registrar nueva Promocion: ".$titulo;

        if($titulo!="" || $fecha_aplica!="" || $fecha_fin!=""){
            if(($_FILES["iptImagen"]["type"] == "image/jpg") || ($_FILES["iptImagen"]["type"] == "image/png") || ($_FILES["iptImagen"]["type"] == "image/gif") || ($_FILES["iptImagen"]["type"] == "image/jpeg"))
            {
                $nombreArchivo=$_FILES['iptImagen']['name'];

                $file_tmp_name=$_FILES['iptImagen']['tmp_name'];

                $dir='../promociones/';
            
                if(!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $nombreArchivoFin=$subNombre."_".$nombreArchivo;

                $new_name_file=$dir.$subNombre."_".$nombreArchivo;

                //echo "nombre archivo ".$new_name_file;
                if (copy($file_tmp_name, $new_name_file)) 
                {
                    $consulta="INSERT INTO 3008_promociones(fechaRegistro,idResponsable,titulo,descripcion,fechaPublicacion,fechaFin,url_doc,situacion)VALUES('".$fechaAct."',
                            '".$idUsuarioSesion."','".$titulo."','".$descripcion."','".$fecha_aplica."','".$fecha_fin."','".$nombreArchivoFin."','1')";
                    $resp=$con->ejecutarConsulta($consulta);

                    if($resp)
                    {
                        guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
                        echo "1";
                    }else{
                        echo "2";
                    }
                }else{
                    echo "2";
                }
            }else{
                echo "3";
            }
        }else{
            echo"0";
        }

    }

?>