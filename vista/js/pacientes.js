var table;
function listarPacientes() {
    table = $("#tbl_pacientes").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Paciente',
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
          url: "funciones/paginaFuncionesPacientes.php",
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
            { data: "fotoPerfil",
                render: function(data, type, row){
                    return '<img class="img-responsive" style="width:40px" src="'+data+'">';
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
                    targets:6,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                "<span title='Modificar datos' class='btEditar text-primary px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-pencil-alt fs-5'></i>"+
                                "</span>"+
                                "<span title='Modificar Foto' class='btfoto text-primary px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-camera-retro fs-5'></i>"+
                                "</span>"+
                                "<span title='TimeLine' class='btTimeLine text-primary px-4' style='cursor:pointer;'>" +
                                "<i class='fas fa-i-cursor fs-5'></i>"+
                            "</span>"+
                                "</center>"
                    }
                }
        ],
        language: idioma_espanol,
        select: true,
        
    });
}

$("#tbl_pacientes").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_paciente").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_paciente").modal("show");

    $("#txtIdPaciente").val(data.id);
    $("#txt_nombre_modificar").val(data.nombre);
    $("#txt_apPaterno_modificar").val(data.apPaterno);
    $("#txt_apMaterno_modificar").val(data.apMaterno);
    $("#txt_rfc_modificar").val(data.rfc);
    $("#txt_genero_modificar").val(data.genero);
    $("#txt_telefono_modificar").val(data.telefono);
    $("#txt_email_modificar").val(data.email);
    $("#txt_fechaNac_modificar").val(data.fechaNac);
    $("#cmb_estado_modificar").val(data.estado);
    $("#txt_municipio_modifica").val(data.municipio);
    $("#txt_calle_modificar").val(data.calle);
    $("#txt_numero_modificar").val(data.numero);
    $("#txt_colonia_modificar").val(data.colonia);
    $("#txt_codPostal_modificar").val(data.codPostal);
    $("#txt_Localidad_modificar").val(data.localidad);
    $("#txt_peso_modificar").val(data.peso);
    $("#txt_estatura_modificar").val(data.estatura);
    $("#txt_Situacion").val(data.situacion);
    
});

$("#tbl_pacientes").on("click", ".btTimeLine", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_timeLine").modal({ backdrop: "static", keyboard: false });
    $("#modal_timeLine").modal("show");
    
    $("#txtIdPacienteTime").val(data.id);
});



function obtenerMunicipiosPorEstado(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:2};

    $.post("funciones/paginaFuncionesPacientes.php", params, function(data){
      $("#txt_municipio").html(data);
    });            
}

function obtenerMunicipiosPorEstado2(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:3};

    $.post("funciones/paginaFuncionesPacientes.php", params, function(data){
      $("#txt_municipio_modificar").html(data);
    });            
}

function abrirModuloRegistro() {
    $("#modal_registro_paciente").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_paciente").modal("show");
}

function registrar_paciente()
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
                            $('#modal_registro_paciente').modal('hide');
                            limpiarCamposModalRegistro();
                            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nuevo Paciente Registrado","success") 
                            //$('#modal_registro_usuarios').trigger('reset');
                            listarPacientes();
                    break;
                    case '2':
                            $('#modal_registro_paciente').modal('hide');
                            limpiarCamposModalRegistro();
                            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
                            $('#modal_registro_paciente').trigger('reset');
                    break;
                    case '3':
                            Swal.fire("Las contraseñas no coinciden","error")
                    break;
                }
        }
    }
    xhttp.open("POST","funciones/paginaFuncionesPacienteGuardar.php", true);
    xhttp.send(data); 
}

function modificar_paciente()
{
    var idPaciente=$("#txtIdPaciente").val();
    var nombre=$("#txt_nombre_modificar").val();
    var apPaterno=$("#txt_apPaterno_modificar").val();
    var apMaterno=$("#txt_apMaterno_modificar").val();
    var rfc=$("#txt_rfc_modificar").val();
    var genero=$("#txt_genero_modificar").val();
    var telefono=$("#txt_telefono_modificar").val();
    var email=$("#txt_email_modificar").val();
    var fechaNac=$("#txt_fechaNac_modificar").val();
    var estado=$("#cmb_estado_modificar").val();
    var municipio=$("#txt_municipio_modificar").val();
    var calle=$("#txt_calle_modificar").val();
    var numero=$("#txt_numero_modificar").val();
    var colonia=$("#txt_colonia_modificar").val();
    var codPostal=$("#txt_codPostal_modificar").val();
    var localidad=$("#txt_Localidad_modificar").val();
    var peso=$("#txt_peso_modificar").val();
    var estatura=$("#txt_estatura_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(nombre.length==0 || apPaterno.length==0 || apMaterno.length==0 || telefono.length==0 || email.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idPaciente":"'+idPaciente+'","nombre":"'+nombre+'","apPaterno":"'+apPaterno+'","apMaterno":"'+apMaterno+'","rfc":"'+rfc
    +'","genero":"'+genero+'","telefono":"'+telefono+'","email":"'+email+'","fechaNac":"'+fechaNac+'","estado":"'+estado+'","municipio":"'+
    municipio+'","calle":"'+calle+'","numero":"'+numero+'","colonia":"'+colonia+'","codPostal":"'+codPostal+'","localidad":"'+
    localidad+'","peso":"'+peso+'","estatura":"'+estatura+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_paciente").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Paciente modificado","success") 
            listarPacientes();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesPacientes.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true) 

}

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

function limpiarCamposModalRegistro()
{
    $("#iptImagen").val('');
    $("#txt_nombre").val('');
    $("#txt_apPaterno").val();
    $("#txt_apMaterno").val();
    $("#txt_rfc").val('');
    $("#txt_genero").val('-1');
    $("#txt_telefono").val('');
    $("#txt_email").val('');
    $("#txt_fechaNac").val('');
    $("#cmb_estado").val('-1');
    //$("#txt_municipio").val('');
    $("#txt_calle").val('');
    $("#txt_numero").val('');
    $("#txt_colonia").val('');
    $("#txt_codPostal").val('');
    $("#txt_Localidad").val('');

}