$(document).ready(function() {
  cargar_cliente();
  $('#buscar').on('click', function () {
    cargar_cliente();
  });
});

function cargar_cliente(){
  $.ajax({
    data: {
      'Nombre': $('#Nombre').val(),
      'Cedula': $('#Cedula').val()
    },
    url: "index.php?c=historial&a=ver",
    type: "post",
    success:function(e){
      var data = JSON.parse(e);
      if(data["error"]==0){
        var html="";
        $.each(data["data"], function(i, item) {
          
            html+='<div class="row">';
            html+=  '<div class="col-md-12">';
            html+=    '<div class="container-data">';
            html+=      '<div class="container-nombre">';
            html+=        '<h6 class="nombreCliente">'+data["data"][0].nombre+'</h6>';
            html+=      '</div>';
            html+=      '<div class="container-counta">';
            html+=        '<h6 class="counta">Cuota: $'+data["data"][0].couta+'- pago: $'+data["data"][0].pago+'</h6>';
            html+=      '</div>';
            html+=      '<div class="container-total-venta">';
            html+=        '<h6 class="total-venta">Total de ventas: $'+data["data"][0].tVenta+'</h6>';
            html+=      '</div>';
            html+=      '<div class="container-valores">';
            html+=        '<h6 class="total-pagado">Pagado: $'+data["data"][0].pagado+'-Debe: $'+data["data"][0].debe+'';
            html+=      '</div>';          
            html+=      '</div>';
            html+=  '</div>';
            html+='</div>';
            html+='<hr>';
          });

          $(".container-cliente").html(html);
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
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  formData.append('idPres',ip);
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