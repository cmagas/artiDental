function listar_usuario() {
    var table = $("#tabla_usuario").DataTable({
        "ordering": false,
        "bLengthChange": false,
        "searching": { "regex": true },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/controlador_usuario_listar.php",
            type: 'POST'
        },
        "columns": [
            { "data": "reg" },
            { "data": "nombre" },
            { "data": "apPaterno" },
            { "data": "apMaterno" }, 
            {
                "data": "sexo",
                render: function (data, type, row) {
                    if (data == '1') {
                        return "MASCULINO";
                    } else {
                        return "FEMENINO";
                    }
                }
            },
            { "data": "empresa" }, 
            {
                "data": "estatus",
                render: function (data, type, row) {
                    if (data == '1') {
                        return "<span class='label label-success'>ACTIVO</span>";
                    } else {
                        return "<span class='label label-danger'>INACTIVO</span>";
                    }
                }
            },
            { "defaultContent": "<button style='font-size:13px;' type='button' class='desactivar btn btn-danger'><i class='fa fa-trash'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='activar btn btn-success'><i class='fa fa-check'></i></button>" }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_usuario_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

}

function filterGlobal() {
    $('#tabla_usuario').DataTable().search(
        $('#global_filter').val(),
    ).draw();
}

function abrirModalRegistro(){
    $("#modal_registro").modal({backdrop:'static',keyboard:false})
    $("#modal_registro").modal('show');
}