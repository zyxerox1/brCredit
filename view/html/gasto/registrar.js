var valor;
$(document).ready(function() {
    $("#input-b5").fileinput(
    	{
    		theme: 'fas',
      		language: 'es',
    		showCaption: false, 
    		dropZoneEnabled: false,
    		showUpload: false,
            mainClass: "input-group-lg",
            browseIcon: "<i class='fas fa-camera'></i>&nbsp;",
            allowedFileExtensions: ["jpg", "png", "jpeg","pdf","docx","doc"],
    	}
    );
    obtener_tipo();
    $("#add").click(function() {
		  abrirModal();    	
    });

    $( "#formulario-crear-tipo" ).submit(function( event ) {
      event.preventDefault();
      crear_tipo($(this).attr('action'),$(this).serializeArray());
  	});

    $( "#formulario-crear-gasto" ).submit(function( event ) {
      event.preventDefault();
      crear_gasto($(this).attr('action'),$(this).serializeArray());
  	});
    
    $(".btn-secondary").addClass("btn-danger");
    $(".btn-danger").addClass("btn-secondary");
    $(".fileinput-cancel").hide();
});

function crear_tipo(action,datos) {
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  $.ajax({
      data: formData,
      url: action,
      type: "post",
      contentType: false,
      processData: false,
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]!=0){
            if(obj["error"]!=3){
              check_todo_input_verificado();
              validate_errores_peticion_ajax(obj);
            }else{
              ohSnap('El tipo ya se encuentra registrado.',{color: 'red'});
            }
          }else if(obj["error"]==0){
            ohSnap('Se guardo correctamente',{color: 'green'});
            obtener_tipo();
            $(".modal").modal("hide");
          }else{
            ohSnap('Error desconocido.',{color: 'green'});
          }
      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
  });
}

function obtener_tipo() {
  $.ajax({
      url: "index.php?c=tipo_gasto&a=obtener",
      type: "get",
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]!=0){
              ohSnap('Error desconocido.',{color: 'green'});
          }else if(obj["error"]==0){
            if(obj["data"].length>0){
              $('#Tipo').html('<option>Seleciones un tipo</option>');
              $.each(obj["data"], function(i, item) {
                $('#Tipo').append("<option value="+obj['data'][i].id+">"+obj['data'][i].tipo+"</option>");
              });
            }
          }else{
            ohSnap('Error desconocido.',{color: 'green'});
          }
      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
  });
}


function crear_gasto(action,datos) {
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  if($('#input-b5').val() !== undefined){
    var files = $('#input-b5')[0].files[0];
    formData.append('img_name',$('#input-b5').val().split('\\').pop());
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
          	$("input").val('');
          	$("textarea").val('');
            $('#Tipo').val('0'); 
          	$('#Tipo').trigger('change');;
            $('#input-b5').fileinput('clear');
            setTimeout(function() {window.location.href = 'index.php?c=gasto' },1000);
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

function abrirModal(){
	$("#agragar").modal("show");
}