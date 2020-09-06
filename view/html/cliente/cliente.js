var ip=0;
$(document).ready(function() {
  cargar_cliente();
  $('#buscar').on('click', function () {
    cargar_cliente();
  });

  $(".btn-depliegue").on('click', function () {
    if($('#desplegue-cliente').hasClass('fa-chevron-down')){
      $(".card-prestamo-usu").show("slow");
      $('#desplegue-cliente').removeClass('fa-chevron-down');
      $('#desplegue-cliente').addClass('fa-chevron-up');
    }else if($('#desplegue-cliente').hasClass('fa-chevron-up')){
      $(".card-prestamo-usu").hide("slow");
      $('#desplegue-cliente').addClass('fa-chevron-down');
      $('#desplegue-cliente').removeClass('fa-chevron-up');
    }
  });

  var fecha_edad=new Date();
  $('.datetimepicker').datetimepicker({ 
    defaultDate: fecha_edad,
    format: 'YYYY-MM-DD',
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      }
    }); 

  $("#guardarPrestamo").on('click', function () {
    registrar_prestamo($("#formulario-crear-prestamo").attr('action'),$("#formulario-crear-prestamo").serializeArray());
  });

});


function cargar_cliente(){
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
              if(row.valorDeuda<0){
                   return "<h4 style='background-color:red;color:white'>Hubo un error concultando este usuario.</h4>";
              }
              var html="";
              if(data!=0){
                html="<h4 class='valorDebeTable'>$"+row.valorDeuda+".00</h4>";
              }else{
                html='<button class="btn btn-success prestamoModal" id="prestamo" data-cliente="'+row.id+'"><i class="far fa-check-circle"></i> paz y salvo</button>';
              }
              return html;
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
          $('.prestamoModal').on('click', function () {
            var i=$(this).attr('data-cliente');
            abrirPrestamoModal(i);
          });

          $('.edit').on('click', function () {
            var i=$(this).attr('data-usu');
            window.location.href="index.php?c=cliente&a=editar&i="+i;
          });
        }
    });
  }


function abrirPrestamoModal(id){
  console.log(ip);
  ip=id;
  console.log(ip);
  $.ajax({
    data: {
      'id':id
    },
    url: "index.php?c=cliente&a=obtenerDataCliente",
    type: "post",
    success:function(e){
      var data = JSON.parse(e);
      if(data["error"]==0){
        if(data["data"][0].valorDeuda!=0){
          ohSnap('Este usuario no puede tener prestamo, Por favor comuniquese con el admindistrador',{color: 'red'});
          return false;
        }
        $(".tittle").html("Registrar prestamo al cliente "+data["data"][0].nombre);
        $(".img-cliente").attr("src","./view/assets/imagenes_cliente/"+data["data"][0].foto);
        $(".cc").html(data["data"][0].cc);
        $(".ccr").html(data["data"][0].ccr);
        $(".telefono1").html(data["data"][0].telefono1);
        $(".telefono2").html(data["data"][0].telefono2);
        $(".direcionc").html(data["data"][0].direcionc);
        $(".direcion").html(data["data"][0].direcion);
        $(".correo").html(data["data"][0].correo);
        $(".fecha").html(data["data"][0].fecha);
        $('#modalPrestamo').modal("show");
      }
    },
    error:function(){
        ohSnap('Error desconocido',{color: 'red'});
    }
  });
}

function registrar_prestamo(action,datos) {
  if(ip==0){
    ohSnap('Error desconocido.',{color: 'red'});
    return false;
  }
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  formData.append('id',ip);
  $.ajax({
      data: formData,
      url: action,
      type: "post",
      contentType: false,
      processData: false,
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]!=0){
            check_todo_input_verificado();
            validate_errores_peticion_ajax(obj);
          }else if(obj["error"]==0){
            cargar_cliente();
            ohSnap('Se guardo correctamente',{color: 'green'});
          }else{
            ohSnap('Error desconocido.',{color: 'green'});
          }
      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
  });
}