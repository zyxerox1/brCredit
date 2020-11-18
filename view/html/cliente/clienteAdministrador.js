$(document).ready(function() {
  $('#codigo').on('change', function () {
    cargar_data_cliente($(this).val());
 });

 $('#buscar').on('click', function () {
    cargar_cliente();
  });

 $("#datacliente").css("display","none");

});

function cargar_data_cliente(ruta){
  $.ajax({
      data: {'ruta':ruta},
      url: "index.php?c=cliente&a=obtenerClienteRuta",
      type: "post",
      success:function(e){
        var clientes = JSON.parse(e);
        $("#Nombre option").remove();
        $("#Cedula option").remove();
        $('#Nombre').append("<option value='0' selected='selected' >Busqueda por nombre</option>");
        $('#Cedula').append("<option value='0' selected='selected' >Busqueda por documento</option>");
        if(clientes.length>0){
          clientes.forEach(element => $('#Nombre').append("<option value='"+element["id"]+"' >"+element["cliente"]+"</option>"));
          $('#Nombre').prop( "disabled", false );

          clientes.forEach(element => $('#Cedula').append("<option value='"+element["documento"]+"' >"+element["documento"]+"</option>"));
          $('#Cedula').prop( "disabled", false );

          $(".container-filtro-cliente").show();
        }else{
          ohSnap('No se encuentra cliente en esta ruta',{color: 'red'});
          $(".container-filtro-cliente").hide();
        }


      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
    });
}

function cargar_cliente(){
  if ( $.fn.dataTable.isDataTable( '#datacliente' ) ) {
   $("#datacliente").dataTable().fnDestroy();
  }

  if($('#codigo').val()==0){
    ohSnap('Tiene que selecionar una ruta.',{color: 'yellow'});
    return false;
  }
    var MY_AJAX_ACTION_URL = "index.php?c=cliente&a=cargar";
    table = $('#datacliente').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'Cedula':$('#Cedula').val(),
            'Nombre':$('#Nombre').val(),
            'ruta':$('#codigo').val()
          },
          "url": MY_AJAX_ACTION_URL
        },
        "type": "get",
        "paging": true,
        "searching": false,
        "ordering": false,
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
          { data: 'Nombres' },
          { data: 'Apellidos'},
          { data: 'Telefono' },
          { data: 'Moroso' },
          //{ data: 'Estado' },
          { data: 'totalCarVenNro'},
          { data: 'Direcion'},
          { data: 'ventas' },
          { data: 'vendido' },
          { data: 'pagado' },
          { data: 'Limite'},
          { data: 'Referencia' },
          { data: 'id' },
          { data: 'autorizar' }
      ],
      "columnDefs": [{
           "targets": 3,
           "data": "Moroso",
           "render": function ( data, type, row, meta ) {
              var input="";
              if(data=='Si'){
                input='<h6 style="color:red">'+data+'</h6>';
              }else{
                input='<h6 style="color:green">'+data+'</h6>';
              }
             return input;
           }
         },/*{
           "targets": 4,
           "data": "Estado",
           "render": function ( data, type, row, meta ) {
              var input="";
              if(data==1){
                input='<input type="checkbox" data-estado="'+row.id+'" checked data-toggle="toggle" data-size="sm" class="estado_clie">';
              }else{
                input='<input type="checkbox" data-estado="'+row.id+'" data-toggle="toggle" data-size="sm" class="estado_clie">';
              }
             return input;
           }
         },*/{
           "targets": 7,
           "data": "vendido",
           "render": function ( data, type, row, meta ) {
              var input="";
              input=formaterNumeroDecimales(data); 
             return "$"+input;
           }
         },{
           "targets": 8,
           "data": "pagado",
           "render": function ( data, type, row, meta ) {
              var input="";
              input=formaterNumeroDecimales(data); 
             return "$"+input;
           }
         },{
        "targets": 11,
        "data": "id",
        "render": function ( data, type, row, meta ) {
            return '<button class="btn btn-outline-primary edit" data-usu="'+row.id+'"><i class="fas fa-user-edit"></i></button>';
        }

      },{
        "targets": 12,
        "data": "autorizar",
        "render": function ( data, type, row, meta ) {
            if(data==1){
              return '<button class="btn btn-outline-primary autorizar" data-usu="'+row.id+'">'+row.valoresAutoriazar+'</button>';
            }else{
              return "No hay solicitud";
            }
            
        }
      }],
      "processing": true,
      "serverSide": true,
      "pageLength" : 10,

      drawCallback: function () {
        $('.prestamoModal').on('click', function () {
          var i=$(this).attr('data-cliente');
          abrirPrestamoModal(i);
        });

        $('.estado_clie').on('click', function () {
            var clien=$(this).attr("data-estado");
            var estado=1;
            if( $(this).is(':checked') ){
              estado=0;
            } else {
              estado=1;
            }
            cambiar_estado(clien,estado);
          });

        $('.autorizar').on('click', function () {
            var usu=$(this).attr("data-usu");
            autorizarAumentoSaldo(usu);
          });
        

        $('.edit').on('click', function () {
          var i=$(this).attr('data-usu');
          window.location.href="index.php?c=cliente&a=editar&i="+i;
        });
      }
    });

    $("#datacliente").css("display","block");

  }

function cambiar_estado(id,estado){
  $.ajax({
    data: {
      'id':id,
      'estado':estado
    },
    url: "index.php?c=cliente&a=cambiar_estado",
    type: "post",
    success:function(e){
      var data = JSON.parse(e);
      if(data["error"]==0){
        ohSnap('Se cambio el estado corretamente',{color: 'green'});
      }else{
        error_501();
        cargar_cliente();
      }
    },
    error:function(){
        ohSnap('Error desconocido',{color: 'red'});
    }
  });
}


function autorizarAumentoSaldo(id){
  $.ajax({
    data: {
      'id':id
    },
    url: "index.php?c=cliente&a=autrizarCambioSaldo",
    type: "post",
    success:function(e){
      var data = JSON.parse(e);
      if(data["error"]==0){
        cargar_cliente();
        ohSnap('Se cambio el estado corretamente',{color: 'green'});
      }else if(data["error"]==1){
        ohSnap(data["mensaje"],{color: 'red'});
      }else{
        error_501();
        cargar_cliente();
      }
    },
    error:function(){
        ohSnap('Error desconocido',{color: 'red'});
    }
  });
}
