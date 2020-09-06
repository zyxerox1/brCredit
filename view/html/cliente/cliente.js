$(document).ready(function() {
  cargar_cliente();
  $('#buscar').on('click', function () {
    cargar_cliente();
  });
});


function cargar_cliente(){
  console.log("llego");
  if ( $.fn.dataTable.isDataTable( '#datacliente' ) ) {
   $("#datacliente").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=cliente&a=cargar";
    table = $('#datacliente').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'Cedula':$('#Cedula').val(),
            'Nombre':$('#Nombre').val()
          },
          "url": MY_AJAX_ACTION_URL
        },
        "type": "get",
        "paging": true,
        "searching": false,
        "ordering": true,
        "language": {
          "zeroRecords": "Pagina no encontrada",
          "processing": 'Cargando...'
        },
        //"stateSave": true,
        "bLengthChange" : true,
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          { data: 'CC' },
          { data: 'nombre'},
          { data: 't1' },
          { data: 't2' },
          { data: 'Direcionr' },
          { data: 'Direcionc' },
          { data: 'Correo' },
          { data: 'fecha_cobro'},
          { data: 'id_cobro'},
          { data: 'id' },
      ],
      "columnDefs": [ {
           "targets": 8,
           "data": "id_cobro",
           "render": function ( data, type, row, meta ) {
              return '<button class="btn btn-outline-primary" data-usu="'+row.id+'"><i class="fas fa-user-edit"></i></button>';
           }
         },
         {
           "targets": 9,
           "data": "id",
           "render": function ( data, type, row, meta ) {
              return '<button class="btn btn-outline-primary edit" data-usu="'+row.id+'"><i class="fas fa-user-edit"></i></button>';
           }
         }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
          $('.estado_usu').on('click', function () {
            var id_u=$(this).attr("data-estado");
            var estado=1;
            if( $(this).is(':checked') ){
              estado=0;
            } else {
              estado=1;
            }
          });

          $('.edit').on('click', function () {
            var i=$(this).attr('data-usu');
            window.location.href="index.php?c=cliente&a=editar&i="+i;
          });
        }
    });
  }
