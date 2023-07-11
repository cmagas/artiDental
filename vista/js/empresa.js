
/*==============================================
    FUNCION QUE PERMITE PREVISUALIZAR LA IMAGEN
 ===============================================*/
 function previewFile(input){
    var file = $("input[type=file]").get(0).files[0];

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            $("#previewImg").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}

function registrar_empresa()
{
    var frm = document.getElementById('form_subir');
    var data = new FormData(frm);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState==4){
            var msg = xhttp.responseText;
                switch(msg)
                {
                    case '0':
                        Swal.fire("Mensaje De Error","Los campos marcados con * sob obligatorios","error");
                    break;
                    case '1':
                            Swal.fire("Mensaje De Confirmacion","Datos correctos, Empresa Registrada","success") 
                    break;
                    case '2':
                            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
                    break;
                }
        }
    }
    xhttp.open("POST","funciones/paginaFuncionesAltaEmpresa.php", true);
    xhttp.send(data); 
}