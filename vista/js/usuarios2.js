var table;
function listarUsuarios() {
    table = $("#tbl_usuarios").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Usuario',
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
          url: "funciones/paginaFuncionesUsuarios.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreCompleto" },
            { data: "email" }, 
            { data: "nombrePerfil" }, 
            { data: "fotoPerfil",
                render: function(data, type, row){
                    return '<img class="img-responsive" style="width:40px" src="fotos/'+data+'">';
                } 
            },   
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
                    targets:7,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                "<span class='btEditar text-primary px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-pencil-alt fs-5'></i>"+
                                "</span>"+
                                "<span class='btfoto text-primary px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-camera-retro fs-5'></i>"+
                                "</span>"+
                                "</center>"
                    }
                }
        ],
        language: idioma_espanol,
        select: true,
        
    });

}

$("#tbl_usuarios").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_usuarios").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_usuarios").modal("show");

     $("#txtIdUsuario").val(data.id);
     $("#txt_nombre_modifi").val(data.nombre);
     $("#txt_apPaterno_modifi").val(data.apPaterno);
     $("#txt_apMaterno_modifi").val(data.apMaterno);
     $("#txt_rfc_modifi").val(data.rfc);
     $("#txt_genero_modifi").val(data.genero);
     $("#txt_telefono_modifi").val(data.telmovil);
     $("#txt_email_modifi").val(data.email);
     $("#txt_fechaNac_modifi").val(data.fechaNac);
     $("#cmb_estado_modifi").val(data.estado);
     $("#txt_municipio_modifi").val(data.municipio);
     $("#txt_Localidad_modifi").val(data.localidad);
     $("#txt_usuario_modifi").val(data.usuario);
     $("#txt_cont1_modifi").val(data.passw);
     $("#txt_cont2_modifi").val(data.passw);
     $("#cmb_Perfil_modifi").val(data.idPerfil);
     $("#txt_Situacion").val(data.situacion);

     obtenerMunicipio(data.municipio);
    
});

$("#tbl_usuarios").on("click", ".btfoto", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_editar_foto").modal({ backdrop: "static", keyboard: false });
    $("#modal_editar_foto").modal("show");

    $("#txtIdUsuarioFoto").val(data.id);
    document.getElementById('lbl_usuario').innerHTML=data.nombreCompleto;
});


function abrirModuloRegistro()
{
    $("#modal_registro_usuarios").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_usuarios").modal("show");
}

function registrar_usuario1()
{
    var nombre=$("#txt_nombre").val();
    var apPaterno=$("#txt_apPaterno").val();
    var apMaterno=$("#txt_apMaterno").val();
    var rfc=$("#txt_rfc").val();
    var genero=$("#txt_genero").val();
    var telefono=$("#txt_telefono").val();
    var email=$("#txt_email").val();
    var estado=$("#cmb_estado").val();
    var municipio=$("#txt_municipio").val();
    var localidad=$("#txt_Localidad").val();
    var usuario=$("#txt_usuario").val();
    var pass1=$("#txt_cont1").val();
    var pass2=$("#txt_cont2").val();
    var perfil=$("#cmb_Perfil").val();
    var fechaNac=$("#txt_fechaNac").val();
    var foto=$("#txt_foto").val();



    if(nombre.length==0 || apPaterno.length==0 || apMaterno.length==0 || usuario.length==0 || pass1.length==0 || pass2.length==0 || perfil==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados * son obligatorios","warning");
    }

    if(pass1!=pass2)
    {
        return Swal.fire("Mensaje De Advertencia","Las contraseñas deben coincidir","warning"); 
    }

    let extension = foto.split('.').pop();
    let nombreFoto="";
    let f = new Date();
    let compFecha = f.getDate()+""+(f.getMonth()+1)+""+f.getFullYear()+""+f.getHours()+""+f.getMilliseconds();

    if(foto.length>0){
        nombreFoto="img"+compFecha+"."+extension;
    }

    let formData = new FormData();
    let fotoObj = $("#txt_foto")[0].files[0];


    var cadObj='{"nombre":"'+nombre+'","apPaterno":"'+apPaterno+'","apMaterno":"'+apMaterno+'","rfc":"'+rfc+'","genero":"'+genero+'","telefono":"'+telefono+'","email":"'+email+'","estado":"'+estado+'","municipio":"'+municipio+'","localidad":"'+localidad+'","usuario":"'+usuario+'","pass1":"'+pass1+'","perfil":"'+perfil+'","fechaNac":"'+fechaNac+'","nombreFoto":"'+nombreFoto+'","fotoObj":"'+fotoObj+'"}';

    //console.log(cadObj);

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_usuarios").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nuevo Usuario Registrado","success") 
            listarUsuarios();  
            limpiarCamposModalRegistro();
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesUsuarios.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true)  
}

function registrar_usuario()
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
                            Swal.fire("Los campos con * son Obligatorios","error")
                    break;
                    case '1':
                            $('#modal_registro_usuarios').modal('hide');
                            limpiarCamposModalRegistro();
                            Swal.fire("Los datos se guardaron correctamente","success");
                            //$('#modal_registro_usuarios').trigger('reset');
                            listarUsuarios();
                    break;
                    case '2':
                            $('#modal_registro_usuarios').modal('hide');
                            limpiarCamposModalRegistro();
                            Swal.fire("Los datos no fueron guardados","error");
                            $('#modal_registro_usuarios').trigger('reset');
                    break;
                    case '3':
                            Swal.fire("Las contraseñas no coinciden","error")
                    break;
                }
        }
    }
    xhttp.open("POST","funciones/paginaFuncionesUsuariosGuardar.php", true);
    xhttp.send(data); 
};

function obtenerMunicipiosPorEstado(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:2};

    $.post("funciones/paginaFuncionesUsuarios.php", params, function(data){
      $("#txt_municipio").html(data);
    });            
}

function obtenerMunicipiosPorEstado2(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:2};

    $.post("funciones/paginaFuncionesUsuarios.php", params, function(data){
      $("#txt_municipio_modifi").html(data);
    });            
}

function obtenerMunicipio(mpio)
{
  mpio = mpio;
  var params={mpio:mpio,funcion:4};
  $.post("funciones/paginaFuncionesUsuarios.php", params, function(data){
    $("#txt_municipio_modifi").html(data);
  });    
}

function modificar_usuario()
{
    var nombre=$("#txt_nombre_modifi").val();
    var apPaterno=$("#txt_apPaterno_modifi").val();
    var apMaterno=$("#txt_apMaterno_modifi").val();
    var rfc=$("#txt_rfc_modifi").val();
    var genero=$("#txt_genero_modifi").val();
    var telefono=$("#txt_telefono_modifi").val();
    var email=$("#txt_email_modifi").val();
    var fechaNac=$("#txt_fechaNac_modifi").val();
    var estado=$("#cmb_estado_modifi").val();
    var municipio=$("#txt_municipio_modifi").val();
    var localidad=$("#txt_Localidad_modifi").val();
    var usuario=$("#txt_usuario_modifi").val();
    var pass1=$("#txt_cont1_modifi").val();
    var pass2=$("#txt_cont2_modifi").val();
    var perfil=$("#cmb_Perfil_modifi").val();
    var situacion=$("#txt_Situacion").val();
    var idUsuario=$("#txtIdUsuario").val();
   
    
    

    if(nombre.length==0 || apPaterno.length==0 || apMaterno.length==0 || email.length==0 || usuario.length==0 || pass1.length==0 || pass2.length==0 || situacion==-1 || perfil==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados * son obligatorios","warning");
    }

    if(pass1!=pass2)
    {
        return Swal.fire("Mensaje De Advertencia","Las contraseñas deben coincidir","warning"); 
    }

    var cadObj='{"nombre":"'+nombre+'","apPaterno":"'+apPaterno+'","apMaterno":"'+apMaterno+'","rfc":"'+rfc+'","genero":"'+genero+'","telefono":"'+telefono+'","email":"'+email+'","fechaNac":"'+fechaNac+'","estado":"'+estado+'","municipio":"'+municipio+'","localidad":"'+localidad+'","usuario":"'+usuario+'","pass1":"'+pass1+'","situacion":"'+situacion+'","idUsuario":"'+idUsuario+'","idPerfil":"'+perfil+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_usuarios").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Usuario Modificado","success") 
            listarUsuarios();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo actualizar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesUsuarios.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,true)  
}

function modificar_foto_usuario()
{
    var frm = document.getElementById('form_modificar_foto');
    var data = new FormData(frm);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState==4){
            var msg = xhttp.responseText;
            switch(msg)
                {
                    case '1':
                            $('#modal_editar_foto').modal('hide');
                            limpiarCamposModalRegistro();
                            Swal.fire("Mensaje De Confirmacion","La foto fue modificada correctamente","success") 
                            listarUsuarios();
                    break;
                    case '2':
                            $('#modal_editar_foto').modal('hide');
                            limpiarCamposModalModificarFoto();
                            Swal.fire("Mensaje De Error","Los cambios no fueron realizados","error");
                            $('#modal_editar_foto').trigger('reset');
                    break;
                }
        }
    }
    xhttp.open("POST","funciones/paginaFuncionesUsuarioModificarFoto.php", true);
    xhttp.send(data); 

}

function limpiarCamposModalRegistro()
{
    $("#txt_nombre").val('');
    $("#txt_apPaterno").val(-1);
    $("#txt_apMaterno").val(-1);
    $("#txt_rfc").val('');
    $("#txt_genero").val('-1');
    $("#txt_telefono").val('');
    $("#txt_email").val('');
    $("#cmb_estado").val('-1');
    $("#txt_municipio").val('');
    $("#txt_Localidad").val('');
    $("#txt_usuario").val('');
    $("#txt_cont1").val('');
    $("#txt_cont2").val('');
    $("#cmb_Perfil").val('-1');
    $("#txt_fechaNac").val('');
    $("#id_file").val('');

}

function limpiarCamposModalModificarFoto()
{
    $("#id_file_editar").val('');
}