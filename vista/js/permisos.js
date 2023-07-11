var table;
function listarPermisos() {
    table = $("#tbl_permisos").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Permisos',
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
          url: "funciones/paginaFuncionesPermisos.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombrePermiso" },
            { data: "situacion", 
                render: function (data, type, row) {
                    if (data == "1") {
                    return "<span class='badge bg-success'>ACTIVO</span>";
                    } else {
                    return "<span class='badge bg-danger'>INACTIVO</span>";
                    }
                },
            },
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
                                "<span class='btEliminar text-danger px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-trash fs-5'></i>"+
                                "</span>"+
                        "</center>"
                    }
                }
        ],
    
        language: idioma_espanol,
        select: true,
        
    });

}

$("#tbl_permisos").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_permisos").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_permisos").modal("show");
    
     $("#txtIdPermiso").val(data.id);
     $("#txt_nomPermiso_modifi").val(data.nombrePermiso);
     $("#txt_descripcion_modifi").val(data.descripcion);
     $("#txt_Situacion").val(data.situacion);
    
});

$("#tbl_permisos").on("click", ".btEliminar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }
  
    Swal.fire({
      title: "¿Esta seguro de querer Eliminar el Permiso?",
      text: "Una vez hecho esto el usuario no podrá visualizarlo",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
    }).then((result) => {
      if (result.value) {
        modificarEstatusPermiso(data.id, "0");
      }
    });
});

function abrirModuloRegistro()
{
    $("#modal_registro_permisos").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_permisos").modal("show");
}

function registrar_permisos()
{
    var nomPermiso=$("#txt_nomPermiso").val();
    var descripcion=$("#txt_descripcion").val();

    if(nomPermiso.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nomPermiso":"'+nomPermiso+'","descripcion":"'+descripcion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_permisos").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nuevo Permiso Registrado","success") 
            listarPermisos();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesPermisos.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 

}

function modificar_permisos()
{
    var nomPermiso=$("#txt_nomPermiso_modifi").val();
    var descripcion=$("#txt_descripcion_modifi").val();
    var txtIdPermiso=$("#txtIdPermiso").val();
    var txt_Situacion=$("#txt_Situacion").val();

    if(nomPermiso.length==0 || txt_Situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nomPermiso":"'+nomPermiso+'","descripcion":"'+descripcion+'","txtIdPermiso":"'+txtIdPermiso+'","txt_Situacion":"'+txt_Situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_permisos").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Permiso Modificado","success") 
            listarPermisos();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesPermisos.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function modificarEstatusPermiso(id, estado)
{
    var mensaje = "";
    var idPermiso = id;
  
    if (estado == "0") {
      mensaje = "Inactivo";
    } else {
      mensaje = "Activo";
    }
  
    var cadObj = '{"idPermiso":"' + idPermiso + '","estado":"' + estado + '"}';
  
    function funcAjax() {
      var resp = peticion_http.responseText;
      arrResp = resp.split("|");
      if (arrResp[0] == "1") {
          listarProductos();
        Swal.fire("Mensaje De Confirmacion","El Permiso se " + mensaje + " con exito","success");
      } else {
        Swal.fire("Mensaje De Error","Lo sentimos, no se pudo modificar el registro","error");
      }
    }
    obtenerDatosWeb("funciones/paginaFuncionesPermisos.php",funcAjax,"POST","funcion=4&cadObj=" + cadObj,true);
}

function limpiarCamposModalRegistro()
{
    $("#txt_nomPermiso").val('');
    $("#txt_descripcion").val('');
}


