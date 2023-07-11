var table;
function listarPefiles() {
    table = $("#tbl_perfiles").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Perfil',
                className: 'addNewRecord',
                action: function ( e, dt, node, config ){
                    abrirModuloRegistro();
                }
            },
            'excel','pdf','print','pageLength'
        ],
        ordering: false,
        bLengthChange: true,
        searching: { regex: true },
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        pageLength: 10,
        destroy: true,
        async: false,
        processing: true,
        ajax: {
          url: "funciones/paginaFuncionesPerfiles.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "perfil" },
            { data: "situacion", 
                render: function (data, type, row) {
                    if (data == "1") {
                    return "<span class='badge bg-success'>ACTIVO</span>";
                    } else {
                    return "<span class='badge bg-danger'>INACTIVO</span>";
                    }
                },
            },
            { data: "" }
        ],
        responsive: {
                detalls:{
                    type: 'column'
                }
        },
        columnDefs:[
                {
                    targets:0,
                    orderable: false,
                    className:'control'
                },
                {
                    targets:4,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                "<span class='btEditar text-primary px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-pencil-alt fs-5'></i>"+
                                "</span>"+
                                "</center>"
                    }
                }
        ],
    
        language: idioma_espanol,
        select: true,
        
    });

}

$("#tbl_perfiles").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_perfiles").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_perfiles").modal("show");
    
    $("#txtIdPerfil").val(data.id);
    $("#txt_nombre_modifi").val(data.perfil);
    $("#txt_descripcion_modifi").val(data.descripcion);
    $("#txt_Situacion").val(data.situacion);
    
});

$("#tbl_perfiles").on("click", ".btEliminar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }
  
    Swal.fire({
      title: "¿Esta seguro de Eliminar este Perfil?",
      text: "Una vez hecho esto el usuario no podrá visualizarlo",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
    }).then((result) => {
      if (result.value) {
        modificarEstatusPerfil(data.id, "0");
      }
    });
});

function abrirModuloRegistro()
{
    $("#modal_registro_perfiles").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_perfiles").modal("show");
}

function registrar_perfiles()
{
    var nombrePerfil=$("#txt_nombre").val();
    var descripcion=$("#txt_descripcion").val();

    if(nombrePerfil.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
    }

    var cadObj='{"nombrePerfil":"'+nombrePerfil+'","descripcion":"'+descripcion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_perfiles").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctamente Registrado","success") 
            listarPefiles();
            limpiarCamposModalRegistro();           
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesPerfiles.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}

function modificar_perfiles()
{
    var nombrePerfil=$("#txt_nombre_modifi").val();
    var descripcion=$("#txt_descripcion_modifi").val();
    var idPerfil=$("#txtIdPerfil").val();
    var situacion=$("#txt_Situacion").val();

    if(nombrePerfil.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
    }

    var cadObj='{"nombrePerfil":"'+nombrePerfil+'","descripcion":"'+descripcion+'","idPerfil":"'+idPerfil+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_perfiles").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctamente Modificados","success") 
            listarPefiles();

        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesPerfiles.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function modificarEstatusPerfil(id, estado)
{
    var mensaje = "";
    var idPerfil = id;

    if (estado == "0") {
        mensaje = "Inactivo";
    } else {
        mensaje = "Activo";
    }

    var cadObj = '{"idPerfil":"' + idPerfil + '","estado":"' + estado + '"}';

    function funcAjax() {
        var resp = peticion_http.responseText;
        arrResp = resp.split("|");
        if (arrResp[0] == "1") {
            listarPefiles();
        Swal.fire("Mensaje De Confirmacion","El Perfil se " + mensaje + " con exito","success");
        } else {
        Swal.fire("Mensaje De Error","Lo sentimos, no se pudo modificar el registro","error");
        }
    }
    obtenerDatosWeb("funciones/paginaFuncionesPerfiles.php",funcAjax,"POST","funcion=4&cadObj=" + cadObj,true);
}

function limpiarCamposModalRegistro()
{
    $("#txt_nombre").val('');
    $("#txt_descripcion").val('');
}