$(document).ready(function() {
  var btnCust = ""; /*'<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
      'onclick="alert(\'Call your custom code here.\')">' +
      '<i class="glyphicon glyphicon-tag"></i>' +
      '</button>';*/ 
  $("#avatar-2").fileinput({
      theme: 'fas',
      language: 'es',
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      showBrowse: false,
      browseOnZoneClick: true,
      removeLabel: '',
      removeIcon: '<i class="fas fa-times"></i>',
      removeClass: 'btn btn-sm btn-kv btn-danger',
      removeTitle: 'Cancel or reset changes',
      elErrorContainer: '#kv-avatar-errors-2',
      msgErrorClass: 'alert alert-block alert-danger',
      defaultPreviewContent: '<img src="'+$("#avatar-2").attr('data-src')+'" class="img-perfil-login rounded-circle" alt="Your Avatar"><h6 class="text-muted">Arrastre Ò haga clic para seleccionar</h6>',
      layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
      allowedFileExtensions: ["jpg", "png", "gif"],
      autoOrientImage:false
  });

  fecha_edad=$("#Fecha").val();
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

  calcularEdad(fecha_edad);

  $(".datetimepicker").on('dp.change', function(e){
    var edad=calcularEdad($(this).val());
  });

  $("#estados").change(function() {
    cargarCiudades();
  })

  readTextFile("view/assets/plugins/localidad/Estados.json", function(text){
    var arrayEstados = JSON.parse(text);
    arrayEstados.forEach(data =>dibujarEstado(data.ID,data.Nome));
    cargarCiudades();
  });

  $( "#formulario-editar-cliente" ).submit(function( event ) {
      event.preventDefault();
      editar_cliente($(this).attr('action'),$(this).serializeArray());
  });
});

function cargarCiudades(){
  var id=$("#estados").val();
    $("#ciudades").html("<option value='0'>Selecione un ciudad...</option>");
    readTextFile("view/assets/plugins/localidad/Cidades.json", function(text){
      var arrayCiudad = JSON.parse(text);
      $(".loader").fadeIn('slow');
      arrayCiudad.forEach(element => dibujarCiudades(element,id));
      $(".loader").fadeOut('slow');
    });
}


function dibujarEstado(id,nome){

  if($("#estados").attr("data-id")==id){
    //console.log($("#estados").attr("data-id")+"----"+id);
    $("#estados").append("<option value="+id+" selected='selected'>"+nome+"</option>")
  }else{
    $("#estados").append("<option value="+id+">"+nome+"</option>")
  }
}

function dibujarCiudades(data,id){
  if(data.Estado==id){
    if($("#ciudades").attr("data-id")==data.ID){
      $("#ciudades").append("<option selected='selected' value="+data.ID+">"+data.Nome+"</option>");
    }else{
      $("#ciudades").append("<option value="+data.ID+">"+data.Nome+"</option>");
    }
  }
}

function editar_cliente(action,datos) {
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  if($('#avatar-2').val() !== undefined){
    var files = $('#avatar-2')[0].files[0];
    formData.append('img_name',$('#avatar-2').val().split('\\').pop());
    formData.append('img',files);
  }

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
            setTimeout(function() {window.location.href = 'index.php?c=cliente' },1000);
            //setTimeout(function() {window.history.go(-1) },1000);
            ohSnap('Se actualizo correctamente',{color: 'green'});
          }else{
            ohSnap('Error desconocido.',{color: 'green'});
          }
      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
  });
}

function calcularEdad(fecha) {
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();
    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
    
    if (edad>0) {
      $("#Edad").val(edad);
    }else{
      ohSnap('Selecione una fecha de nacimiento verdadera.',{color: 'yellow'});
    }

    return edad;
}