var table;
function listarCitaMedicas() {
    table = $("#tbl_cita_medicas").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
           
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
          url: "funciones/paginaFuncionesControlCitas.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombrePaciente" },
            { data: "fechaCita" }, 
            { data: "horaCita" }, 
             
            { data: "situacion", 
                render: function (data, type, row) {
                    if (data == "1") {
                        return "<span class='badge bg-success'>POR ATENDER</span>";
                    } else {
                        if(data == "2")
                        {
                            return "<span class='badge bg-primary'>ATENDIDA</span>";
                        }else{
                            return "<span class='badge bg-danger'>CANCELADA</span>";
                        }
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
                                "<span title='Abrir' class='btAbrir text-primary px-2' style='cursor:pointer;'>" +
                                    "<i class='fas fa-stethoscope fs-5'></i>"+
                                "</span>"+
                                "<span title='Cambiar estado' class='btEliminar text-primary px-1' style='cursor:pointer;'>" +
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

/*FUNCION PARA CAMBIAR EL ESTADO DE LA CITA*/
$("#tbl_cita_medicas").on("click", ".btEliminar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }
  
    Swal.fire({
      title: "¿Esta seguro de querer Cancelar esta Cita?",
      text: "Una vez hecho esto no podrá visualizarlo",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
    }).then((result) => {
      if (result.value) {
        modificarEstatusCita(data.id, "0");
      }
    });
});

$("#tbl_cita_medicas").on("click", ".btAbrir", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#myModal").modal({ backdrop: "static", keyboard: false });
    $("#myModal").modal("show");
    
    $("#txtIdCita").val(data.id);
    $("#txtidPaciente").val(data.idPaciente);
    
});

  function modificarEstatusCita(id, estado)
  {
    var mensaje = "";
    var idCita = id;

    if (estado == "0") {
        mensaje = "Cancelado";
    } else {
        mensaje = "Activo";
    }

    var cadObj = '{"idCita":"' + idCita + '","estado":"' + estado + '"}';

    function funcAjax() {
        var resp = peticion_http.responseText;
        arrResp = resp.split("|");
        if (arrResp[0] == "1") {
            listarCitaMedicas();
        Swal.fire("Mensaje De Confirmacion","La cita se ha " + mensaje + " con exito","success");
        } else {
        Swal.fire("Mensaje De Error","Lo sentimos, no se pudo modificar el registro","error");
        }
    }
    obtenerDatosWeb(
        "funciones/paginaFuncionesControlCitas.php",funcAjax,"POST","funcion=2&cadObj=" + cadObj,true);
  }

  function registrar_Consulta()
  {
    var idTipoConsulta=$("#cmb_TipoConsulta").val();
    var data=$("#t_consulta").val();
    var idCita=$("#txtIdCita").val();
    var idPaciente=$("#txtidPaciente").val();

    if(idTipoConsulta==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idTipoConsulta":"'+idTipoConsulta+'","data":"'+data+'","idCita":"'+idCita+'","idPaciente":"'+idPaciente+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#myModal").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, guardados","success") 
            listarCitaMedicas()
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesControlCitas.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 

  }

  function abriModalCarga()
  {
    $("#src_img_upload").modal({ backdrop: "static", keyboard: false });
    $("#src_img_upload").modal("show");
  }

$('#inputArchivos').change(function() {
    const inputArchivos = document.querySelector("#inputArchivos");
    var btnEnviar = document.querySelector("#btnEnviar");
    var estado = document.querySelector("#estado");

    var fileLength=this.files.length;
    var match=["image/jpeg", "image/png", "image/jpg", "image/gif"];

    var i;
    for(i=0; i<fileLength; i++){
        var file = this.files[i];
        var imagefile = file.type;

        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3]))) {
            alert('Please select a valid image file (JPEG/JPG/PNG/GIF).');
            $("#inputArchivos").val('');
            return false;
        }
    }

    btnEnviar.addEventListener("click", async()=>{
        alert();
    });

});
