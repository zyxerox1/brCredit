var ip=0;
var latitud=0;
var longitud=0;
$(document).ready(function() {
  cargar_cliente();
  $('#buscar').on('click', function () {
    cargar_cliente();
  });
  gelocalizacion();
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

  $( "#ncoutas" ).change(function() {
    if ($(this).val()==11) {
      $("#inter").val('10');
    }else if ($(this).val()==15){
      $("#inter").val('14');
    }else if ($(this).val()==20){
      $("#inter").val('20');
    }else if ($(this).val()==24){
      $("#inter").val('20');
    }
    calcularValorCoutaDia();
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

  $("#Valor").on('keyup', function () {
    var valor=$(this).val().replace('.', "");
    valor=parseInt(valor);
    if($(this).attr("min")<=valor && $(this).attr("max")>=valor){
      calcularValorCoutaDia();
    }
  });

  $("#Valor").on('blur', function () {
    var valor=$(this).val().replace('.', "");
    valor=parseInt(valor);
    if($(this).attr("min")>valor || $(this).attr("max")<valor){
      ohSnap('Error de valor no esta en le rango correcto',{color: 'yellow'});
    }
  });

  

  $("#ncoutas").on('keyup', function () {
    calcularValorCoutaDia();
  });

  $("#inter").on('keyup', function () {
    calcularValorCoutaDia();
  });
  
});

function geo_success(position) {
  latitud=position.coords.latitude;
  longitud=position.coords.longitude;
  $(".location").html('<input hidden value="'+latitud+'" name="latitud"><input hidden value="'+longitud+'" name="longitud">');
}

function geo_error() {
  alert("Si no conocemos tu ubicacion puede generar errores a la hora de registrar el pago");
}


function gelocalizacion(){
  var geo_options = {
    enableHighAccuracy: true, 
    maximumAge        : 30000, 
    timeout           : 27000
  };

  var wpid = navigator.geolocation.getCurrentPosition(geo_success, geo_error, geo_options);
}


function calcularValorCoutaDia(){
  if($("#ncoutas").val()!="" && $("#inter").val()!="" && $("#Valor").val()!=""){
    var valor = $("#Valor").val().replace('.', "");
    var numeroCouta = $("#ncoutas").val();
    var interes = $("#inter").val();

    interes=(interes*valor)/100;
    valor=parseInt(valor)+parseInt(interes);


    $("#Valorc").html("$"+parseInt(valor)/parseInt(numeroCouta));
  }
}

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
          { data: 'CC' },
          { data: 'nombre'},
          { data: 't1' },
          { data: 'Direcionr' },
          { data: 'Direcionc' },
          { data: 'id_cobro'},
          { data: 'id' },
          { data: 'orden' },
      ],
      "columnDefs": [ {
           "targets": 5,
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
           "targets": 6,
           "data": "id",
           "render": function ( data, type, row, meta ) {
              return '<button class="btn btn-outline-primary edit" data-usu="'+row.id+'"><i class="fas fa-user-edit"></i></button>';
           }
          },
         {
           "targets": 7,
           "data": "orden",
           "render": function ( data, type, row, meta ) {
              var html="";
              html+='<button class="btn btn-outline-primary arriba" style="float:left" id="arriba" data-cliente="'+row.id+'"><i class="fas fa-arrow-up"></i></button>';
              html+='<button class="btn btn-outline-primary abajo" style="float:right" id="abajo" data-cliente="'+row.id+'"><i class="fas fa-arrow-down"></i></button>';
              return html;
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

          $('.arriba').on('click', function () {
            var i=$(this).attr('data-cliente');
            cambiarOrden(i,1);
          });

          $('.abajo').on('click', function () {
            var i=$(this).attr('data-cliente');
            cambiarOrden(i,0);
          });
        }
    });
  }


function abrirPrestamoModal(id){
  ip=id;
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

        $("#Valor").attr("min",data["data"][0].prestamo_minimo);
        $("#Valor").attr("max",data["data"][0].prestamo_maximo);
        $("#Valor").val(data["data"][0].prestamo_minimo);
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
        calcularValorCoutaDia();
        $('#modalPrestamo').modal("show");
      }
    },
    error:function(){
        ohSnap('Error desconocido',{color: 'red'});
    }
  });
}

function cambiarOrden(id,posicion) {
  $.ajax({
      data: {
        "id":id,
        "pos":posicion
      },
      url: "index.php?c=cliente&a=orden",
      type: "post",
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]==1){
            ohSnap('No puede completar esta opcion.',{color: 'red'});
          }else if(obj["error"]==0){
            cargar_cliente();
            ohSnap('Se cambio correctamente',{color: 'green'});
          }else{
            ohSnap('Error desconocido.',{color: 'red'});
          }
      },
      error:function(){
          ohSnap('Error desconocido.',{color: 'red'});
      }
  });
}

function registrar_prestamo(action,datos) {
  if(ip==0){
    ohSnap('Error desconocido.',{color: 'red'});
    return false;
  }
  gelocalizacion();
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  formData.append('id',ip);
  formData.append('latitud',latitud);
  formData.append('longitud',longitud);
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
            $('#modalPrestamo').modal("hide");
            ohSnap('Se guardo correctamente',{color: 'green'});
          }else{
            ohSnap('Error desconocido.',{color: 'green'});
          }
      },
      error:function(){
          ohSnap('Error desconocido.',{color: 'red'});
      }
  });
}