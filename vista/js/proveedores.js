var table;
function listarProveedores() {
    table = $("#tbl_proveedor").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Proveedor',
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
          url: "funciones/paginaFuncionesProveedores.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreProv" },
            { data: "localidad" },
            { data: "nomEstado" },   
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
                    targets:6,
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

$("#tbl_proveedor").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_Proveedor").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_Proveedor").modal("show");
    
    $("#txtIdProveedor").val(data.id);
     $("#cmb_tipo_modifi").val(data.tipoEmpresa);
     $("#txt_rfc_modifi").val(data.rfc);
     $("#txt_razonSocial_modifi").val(data.nombre);
     $("#txt_apPaterno_modifi").val(data.apPaterno);
     $("#txt_apMaterno_modifi").val(data.apMaterno);
     $("#txt_direccion_modifi").val(data.direccion);
     $("#cmb_estado_modifi").val(data.estado);
     $("#txt_municipio_modifi").val(data.municipio);
     $("#txt_Localidad_modifi").val(data.localidad);
     $("#txt_email_modifi").val(data.email);
     $("#txt_telefono_modifi").val(data.telefono);
     $("#txt_Situacion").val(data.situacion);

     obtenerMunicipio(data.municipio);
    
});

$("#tbl_proveedor").on("click", ".btEliminar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }
  
    Swal.fire({
      title: "¿Esta seguro de Eliminar este Proveedor?",
      text: "Una vez hecho esto el usuario no podrá visualizarlo",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
    }).then((result) => {
      if (result.value) {
        modificarEstatusProveedores(data.id, "0");
      }
    });
});

function abrirModuloRegistro()
{
    $("#modal_registro_Proveedor").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_Proveedor").modal("show");
}

function tipoProveedor(value)
{
  switch(value)
  {
    case '-1':
             
            $("#txt_apPaterno").prop('disabled', true);
            $("#txt_apMaterno").prop('disabled', true);
    break
    case '1':
            $("#txt_apPaterno").prop('disabled', false);
            $("#txt_apMaterno").prop('disabled', false);

    break
    case '2':
            $("#txt_apPaterno").prop('disabled', true);
            $("#txt_apMaterno").prop('disabled', true);
    break
  }
}

function obtenerMunicipiosPorEstado(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:2};

    $.post("funciones/paginaFuncionesProveedores.php", params, function(data){
      $("#txt_municipio").html(data);
    });            
}

function registrar_proveedor()
{
    var tipoEmpresa=$("#cmb_tipo").val();
    var txt_rfc=$("#txt_rfc").val();
    var razonSocial=$("#txt_razonSocial").val();
    var apPaterno=$("#txt_apPaterno").val();
    var apMaterno=$("#txt_apMaterno").val();
    var direccion=$("#txt_direccion").val();
    var estado=$("#cmb_estado").val();
    var municipio=$("#txt_municipio").val();
    var localidad=$("#txt_Localidad").val();
    var email=$("#txt_email").val();
    var telefono=$("#txt_telefono").val();
    

    if(tipoEmpresa==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Debe seleccionar el tipo de Proveedor","warning");
    }
    else{
        if(tipoEmpresa==1)
        {
        if(razonSocial.length==0 || apPaterno.length==0 || apMaterno.length==0)
        {
            return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
        }
        }
        else{
        if(razonSocial.length==0)
        {
            return Swal.fire("Mensaje De Advertencia","El campo Razon social es obligatorio","warning");
        }
        }
    }
    
    var cadObj='{"tipoEmpresa":"'+tipoEmpresa+'","txt_rfc":"'+txt_rfc+'","razonSocial":"'+razonSocial+'","apPaterno":"'+apPaterno
    +'","apMaterno":"'+apMaterno+'","direccion":"'+direccion+'","localidad":"'+localidad+'","estado":"'+estado+'","municipio":"'+municipio
    +'","email":"'+email+'","telefono":"'+telefono+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_Proveedor").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctamente Registrado","success") 
            listarProveedores();           
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesProveedores.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function limpiarCamposModalRegistro()
{
    $("#cmb_tipo").val('-1');
    $("#txt_rfc").val('');
    $("#txt_razonSocial").val('');
    $("#txt_apPaterno").val('');
    $("#txt_apMaterno").val('');
    $("#txt_direccion").val('');
    $("#cmb_estado").val('-1');
    $("#txt_municipio").val('-1');
    $("#txt_Localidad").val('');
    $("#txt_email").val('');
    $("#txt_telefono").val('');
}

function obtenerMunicipiosPorEstado(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:4};

    $.post("funciones/paginaFuncionesProveedores.php", params, function(data){
      $("#txt_municipio").html(data);
    });            
}

function obtenerMunicipiosPorEstado2(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:4};

    $.post("funciones/paginaFuncionesProveedores.php", params, function(data){
       $("#txt_municipio_modifi").html(data);
    });            
}

function obtenerMunicipio(mpio)
{
  mpio = mpio;
  var params={mpio:mpio,funcion:5};
  $.post("funciones/paginaFuncionesProveedores.php", params, function(data){
    $("#txt_municipio_modifi").html(data);
  });    
}

function modificar_proveedor()
{
    var idProveedor=$("#txtIdProveedor").val();
    var tipoEmpresa=$("#cmb_tipo_modifi").val();
    var txt_rfc=$("#txt_rfc_modifi").val();
    var razonSocial=$("#txt_razonSocial_modifi").val();
    var apPaterno=$("#txt_apPaterno_modifi").val();
    var apMaterno=$("#txt_apMaterno_modifi").val();
    var direccion=$("#txt_direccion_modifi").val();
    var estado=$("#cmb_estado_modifi").val();
    var municipio=$("#txt_municipio_modifi").val();
    var localidad=$("#txt_Localidad_modifi").val();
    var email=$("#txt_email_modifi").val();
    var telefono=$("#txt_telefono_modifi").val();
    var situacion=$("#txt_Situacion").val();

    if(tipoEmpresa==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Debe seleccionar el tipo de Proveedor","warning");
    }
    else{
        if(tipoEmpresa==1)
        {
            if(razonSocial.length==0 || apPaterno.length==0 || apMaterno.length==0)
            {
                return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
            }
        }
        else{
            if(razonSocial.length==0)
            {
                return Swal.fire("Mensaje De Advertencia","El campo Razon social es obligatorio","warning");
            }
        }
    }

    if(situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Debe indicar la situación del Proveedor","warning");
    }

    var cadObj='{"idProveedor":"'+idProveedor+'","tipoEmpresa":"'+tipoEmpresa+'","txt_rfc":"'+txt_rfc+'","razonSocial":"'+razonSocial+'","apPaterno":"'+apPaterno+'","apMaterno":"'+apMaterno+'","direccion":"'+direccion+'","localidad":"'+localidad+'","estado":"'+estado+'","municipio":"'+municipio+'","email":"'+email+'","telefono":"'+telefono+'","situacion":"'+situacion+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_Proveedor").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctamente Modificados","success") 
            listarProveedores();           
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesProveedores.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true) 

}

function  modificarEstatusProveedores(id, estado)
{
    var mensaje = "";
    var idProveedor = id;

    if (estado == "0") {
        mensaje = "Inactivo";
    } else {
        mensaje = "Activo";
    }

    var cadObj = '{"idProveedor":"' + idProveedor + '","estado":"' + estado + '"}';

    function funcAjax() {
        var resp = peticion_http.responseText;
        arrResp = resp.split("|");
        if (arrResp[0] == "1") {
            listarProveedores();
        Swal.fire(
            "Mensaje De Confirmacion",
            "El Proveedor se " + mensaje + " con exito",
            "success"
        );
        } else {
        Swal.fire(
            "Mensaje De Error",
            "Lo sentimos, no se pudo modificar el registro",
            "error"
        );
        }
    }
    obtenerDatosWeb(
        "funciones/paginaFuncionesProveedores.php",funcAjax,"POST","funcion=7&cadObj=" + cadObj,true);
}

