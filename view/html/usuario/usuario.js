$(document).ready(function() {
  $('.cambiar-vista-list').on('click', function () {cambiar_vista_tabla(1,"datausuarios")});
  $('.cambiar-vista-cuad').on('click', function () {cambiar_vista_tabla(2,"datausuarios")}); 
  cargar_usuarios();
  $('#buscar').on('click', function () {
    cargar_usuarios();
  });
});
function cargar_usuarios(){
  if ( $.fn.dataTable.isDataTable( '#datausuarios' ) ) {
   $("#datausuarios").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=usuario&a=cargar";
    table = $('#datausuarios').DataTable({
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
        "stateSave": true,
        "bLengthChange" : true,
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          { data: 'CC' },
          { data: 'Nombre'},
          { data: 'Apellido'},
          { data: 't1' },
          { data: 't2' },
          { data: 'Correo' },
          { data: 'fecha'},
          { data: 'Estado'},
          { data: 'id' },
      ],
      "columnDefs": [ {
           "targets": 7,
           "data": "Estado",
           "render": function ( data, type, row, meta ) {
              var input="";
              if(data==1){
                input='<input type="checkbox" data-estado="'+row.id+'" checked data-toggle="toggle" data-size="sm" class="estado_usu">';
              }else{
                input='<input type="checkbox" data-estado="'+row.id+'" checked data-toggle="toggle" data-size="sm" class="estado_usu">';
              }
             return input;
           }
         },{
           "targets": 8,
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
            cambiar_estado(id_u,estado);
          });

          $('.edit').on('click', function () {
            var i=$(this).attr('data-usu');
            window.location.href="index.php?c=usuario&a=editar&i="+i;
          });
        }
    });
  }

function cambiar_estado(id,estado){
  $.ajax({
    data: {
      'id':id,
      'estado':estado
    },
    url: "index.php?c=usuario&a=cambiar_estado",
    type: "post",
    success:function(e){
      var data = JSON.parse(e);
      if(data["error"]==0){
        ohSnap('Se cambio el estado corretamente',{color: 'green'});
      }else{
        error_501();
        cargar_usuarios();
      }
    },
    error:function(){
        ohSnap('Error desconocido',{color: 'red'});
    }
  });
}
