var ip=0;
var latitud=0;
var longitud=0;
var ipRed=0;
var hisg=0;
var tipo=0;
$(document).ready(function() {
  cargar_cliente();
  $('#buscar').on('click', function () {
    cargar_cliente();
  });
  gelocalizacion();
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
  if ( $.fn.dataTable.isDataTable( '#datahistoria' ) ) {
   $("#datahistoria").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=historial&a=ver";
    table = $('#datahistoria').DataTable({
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
          { data: 'nombre' },
          { data: 'couta'},
          { data: 'tVenta' },
          { data: 'diasV' },
      ],
      "columnDefs": [{
          "targets": 0,
          "data": "nombre",
          "render": function ( data, type, row, meta ) {
            if(row.cumplimiento==0){
              return "<div class='nombreTableR'><h5>Nombre: "+data+"</h5><h5 class='valTable'>Sin validar <i class='fas fa-thumbs-down'></i></h5></div>";
            }else{
              return "<div class='nombreTableV'><h5>Nombre: "+data+"</h5><h5 class='valTable'>Validado <i class='fas fa-thumbs-up'></i></h5></div>";
            }
          }
        },
        {
          "targets": 1,
          "data": "couta",
          "render": function ( data, type, row, meta ) {
            var html="";
            if(row.pago==null){
              row.pago=0;
            }
            html="<div class='coutaTable'><h5>Couta: $R "+data+" - Pago: $R "+row.pago+"</h5></div>";
            return html;
          }
        },{
          "targets": 2,
          "data": "tVenta",
          "render": function ( data, type, row, meta ) {
            var html="";
            html="<div class='coutaTable'><h5>Total ventas: $R "+data+" - Debe: $R "+row.debe+"</h5></div>";
            if(row.debe!=0){
              if(row.cumplimiento!=0){
                dataControl="data-pres='"+row.idPres+"'";
                tipo=1;
              }else{
                dataControl="data-pres='"+row.idPrestamos+"'";
                tipo=2;
              }
              html+="<button type='button'class='btn btn-primary edit' "+dataControl+" data-tipo='"+tipo+"' data-clie='"+row.idClie+"' data-abono='"+row.pago+"' data-his='"+row.idRuta+"' id='EditarPrestamo'><i class='fas fa-user-edit'></i> Editar</button>";
            }
            return html;
          }
        },{
          "targets": 3,
          "data": "tVenta",
          "render": function ( data, type, row, meta ) {
            var html="";
            html="<div class='coutaTable'><h5>Dias vencido: "+data+"</h5></div>";
            return html;
          }
        }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
           $('.edit').on('click', function () {
            var id=$(this).attr("data-clie");
            var pres=$(this).attr("data-pres");
            var pago=$(this).attr("data-abono");
            var his=$(this).attr("data-his");
            var tipo=$(this).attr("data-tipo");
            cargarAbonoModal(id,pres,pago,his,tipo);
          });
        }
    });
  }

function cargarAbonoModal(id,pres,pago,his,tipo){
  ip=pres;
  hisg=his;
  tipo=tipo;
  $.ajax({
    data: {
      'id':id
    },
    url: "index.php?c=historial&a=obtenerDataCliente",
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
        $(".valorAbonoAnterior").html("Valor abonado: $R "+pago);
        $("#valorAbono").val(pago);
        //$("#guardarAbono").html("<i class='fas fa-check'></i> Hacer pago de "+data["data"][0].valorPagar);
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
  if(hisg==0){
    ohSnap('Error desconocido.',{color: 'red'});
    return false;
  }
  if(tipo==0){
    ohSnap('Error desconocido.',{color: 'red'});
    return false;
  }
  
  gelocalizacion();
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  formData.append('idPres',ip);
  formData.append('latitud',latitud);
  formData.append('longitud',longitud);
  formData.append('his',hisg);
  formData.append('tipo',tipo);
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