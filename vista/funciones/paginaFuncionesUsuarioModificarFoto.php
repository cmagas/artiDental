<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["id_file_editar"]["type"]))
    {
        session_start();
        include_once("latis/conexionBD.php");

        //varDump($_POST);

        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $fechaAct=date("Y-m-d");

        $subNombre=date("Ymdhis");
        $ruta="";
        $rutaFotoViejo="";

        $idUsuario=$_POST['txtIdUsuarioFoto'];
        $nombreFoto=$_FILES['id_file_editar']['name'];

        $tipoOperacion="Modificar foto Usuario: ".$idUsuario;

        $dir="fotos/usuarios/";

        $consul="SELECT fotoPerfil FROM 1001_identifica WHERE idUsuario='".$idUsuario."'";
        $res=$con->obtenerValor($consul);

        if($res)
        {
            $rutaFotoViejo=$res;
        }

        $x=0;
        $consulta[$x]="begin";
        $x++;

        if($nombreFoto!="")
        {
            $nombreArchivo=$_FILES['id_file_editar']['name'];
            $extension= obtenerExtensionFichero($_FILES['id_file_editar']['name']);

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            if(($_FILES["id_file_editar"]["type"] == "image/jpg") || ($_FILES["id_file_editar"]["type"] == "image/png") || ($_FILES["id_file_editar"]["type"] == "image/gif") || ($_FILES["id_file_editar"]["type"] == "image/jpeg"))
            {
                $nombreArchivo=$_FILES['id_file_editar']['name'];
                $file_tmp_name=$_FILES['id_file_editar']['tmp_name'];
                $nombreArchivoFin="img_".$subNombre.".".$extension;

                $ruta=$dir.$nombreArchivoFin;

                copy($file_tmp_name,"../".$ruta);
                unlink("../".$rutaFotoViejo);
            }else{
                echo "2";
            }
        }else{
            $ruta=$dir."default.png";
        }

        $consulta[$x]="UPDATE 1001_identifica SET fotoPerfil='".$ruta."' WHERE idUsuario='".$idUsuario."'";
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

    }


    function obtenerExtensionFichero($str)
    {
        return end(explode(".", $str));
    }


?>