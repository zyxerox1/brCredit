var ip=0;
var tipo=99;
var latitud=0;
var longitud=0;
var ipRed=0;
var codAtual=0;
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

  $("#guardarAbono").on('click', function () {
     tipo=0;
    $("#confirmAbonar").modal("show");
  });

  $("#guardarAbonoManual").on('click', function () {
     tipo=1;
    $("#confirmAbonar").modal("show");
  });

  $("#guardarAbonoConfirm").on('click', function () {
    registrar_abono($("#formulario-crear-abonar").attr('action'),$("#formulario-crear-abonar").serializeArray());
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

function cargar_cliente(){
  if ( $.fn.dataTable.isDataTable( '#datacliente' ) ) {
   $("#datacliente").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=abono&a=cargar";
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
          { data: 'Direcionc' },
          { data: 'Direcionr' },
          { data: 'valorDeuda'},
          { data: 'id' }
      ],
      "columnDefs": [ {
           "targets": 5,
           "data": "id_cobro",
           "render": function ( data, type, row, meta ) {
              if(row.valorDeuda<0){
                   return "<h4 style='background-color:red;color:white'>Hubo un error concultando este usuario.</h4>";
              }
              var html="";
              html="<h4 class='valorDebeTable'>$"+row.valorDeuda+".00</h4>";
              return html;
           }
         },
         /*{
           "targets": 6,
           "data": "orden",
           "render": function ( data, type, row, meta ) {
              var html="";
              if(row.cumplimiento!=0){
                html+='<button class="btn btn-outline-success auto" style="float:left" id="auto" data-cliente="'+row.id+'"  data-prestamo="'+row.idPres+'" data-cod="'+row.cumplimiento+'"><i class="fas fa-cogs"></i> Actualizar</button>';
              }else{
                html+='<button class="btn btn-outline-primary auto" style="float:left" id="auto" data-cliente="'+row.id+'" data-prestamo="'+row.idPres+'" data-cod="0"><i class="fas fa-cogs"></i> Automatico</button>';
              }
              
              return html;
           }
         },*/
         {
           "targets": 6,
           "data": "orden",
           "render": function ( data, type, row, meta ) {
              var html="";
              if(row.cumplimiento!=0){
                html+='<button class="btn btn-outline-success pagar" style="float:right" id="manual" data-cliente="'+row.id+'" data-prestamo="'+row.idPres+'" data-cod="'+row.cumplimiento+'"><i class="fas fa-hands-wash"></i> Actualizar pago</button>';
              }else{
                html+='<button class="btn btn-outline-primary pagar" style="float:right" id="manual" data-cliente="'+row.id+'" data-prestamo="'+row.idPres+'" data-cod="0"><i class="fas fa-hands-wash"></i>  Hacer Pago </button>';
              }
              
              return html;
           }
         }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 100,
        drawCallback: function () {
          /*$('.auto').on('click', function () {
            var i=$(this).attr('data-cliente');
            var prestamo=$(this).attr('data-prestamo');
            codAtual=$(this).attr('data-cod');
            tipo=0;
            modalAbonoAuto(i,0,prestamo,codAtual);
          });*/

          $('.pagar').on('click', function () {
            var i=$(this).attr('data-cliente');
            var prestamo=$(this).attr('data-prestamo');
            codAtual=$(this).attr('data-cod');
            modalAbonoAuto(i,prestamo,codAtual);
          });
        }
    });
  }


function modalAbonoAuto(id,prestamo,codAtual=0){
  ip=prestamo;
  $.ajax({
    data: {
      'id':id
    },
    url: "index.php?c=abono&a=obtenerDataCliente",
    type: "post",
    success:function(e){
      var data = JSON.parse(e);
      if(data["error"]==0){
        $(".tittle").html("Registrar abono al cliente "+data["data"][0].nombre);
        $(".img-cliente").attr("src","./view/assets/imagenes_cliente/"+data["data"][0].foto);
        $(".nPres").html(data["data"][0].nPrestamo);
        $(".totalV").html(data["data"][0].totalVenta);
        $(".totalP").html(data["data"][0].totalPagado);
        $(".totalD").html(data["data"][0].debe);
        $(".numeroCouta").html(data["data"][0].nCouta);
        $(".valor").html(data["data"][0].valorPagar);
        $("#guardarAbono").html("<i class='fas fa-check'></i> Hacer pago de "+data["data"][0].valorPagar);
        $('#modalAbono').modal("show");
      }
    },
    error:function(){
        ohSnap('Error desconocido',{color: 'red'});
    }
  });
}



function registrar_abono(action,datos) {
  if(ip==0){
    ohSnap('Error desconocido.',{color: 'red'});
    return false;
  }
  gelocalizacion();
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  formData.append('idPres',ip);
  formData.append('tipo',tipo);
  formData.append('latitud',latitud);
  formData.append('longitud',longitud);
  formData.append('codAtual',codAtual);
  $.ajax({
      data: formData,
      url: action,
      type: "post",
      contentType: false,
      processData: false,
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]!=0){
            if(obj["error"]==1){
              ohSnap(obj["mensaje"],{color: 'red'});
            }
            check_todo_input_verificado();
            validate_errores_peticion_ajax(obj);
          }else if(obj["error"]==0){
            cargar_cliente();
            $('#modalAbono').modal("hide");
            $('#confirmAbonar').modal("hide");
            $('#valorAbono').val('');
            $('#Nota').val('');
            ohSnap('Se guardo correctamente',{color: 'green'});
          }else{
            ohSnap('Error desconocido.',{color: 'red'});
          }
      },
      error:function(){
          ohSnap('Error desconocido.',{color: 'red'});
      }
  });
}