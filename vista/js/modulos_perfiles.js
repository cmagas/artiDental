var tbl_perfiles_asignar, tbl_modulos, modulos_usuario, modulos_sistema;
function cargarDataTables() {
    tbl_perfiles_asignar = $("#tbl_perfiles_asignar").DataTable({
        ajax: {
          url: "funciones/paginaFunciones_modulosPerfiles.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "idPerfil" },
            { data: "nombrePerfil" },
            { data: "situacion", 
                render: function (data, type, row) {
                    if (data == "1") {
                    return "ACTIVO";
                    } else {
                    return "INACTIVO";
                    }
                },
            },
            { data: "fechaCreacion" },
         ],
        columnDefs:[
                {
                    targets:4,
                    orderable: false,
                    render: function(data,type, full, meta){
                        return "<center>" +
                            "<span class='btnSeleccionarPerfil text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Seleccionar perfil'> " +
                            "<i class='fas fa-check fs-5'></i> " +
                            "</span> " +
                            "</center>";
                    }
                }
        ],
        language: idioma_espanol,
        select: true,
        
    });

}

function iniciarArbolModulos()
{
    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_modulosPerfiles.php",
        method: 'POST',
        data: {
            funcion: 2
        },
        dataType: 'json',
        success: function(respuesta) {
            console.log("respuesta ", respuesta);
        }
    })
}

