$( document ).ajaxSend(function(event,xhr,options) {
  if(options.username!="master"){
    $(".loader").fadeIn('slow');
  }
});

$( document ).ajaxComplete(function() {
   setTimeout(function() {
        $(".loader").fadeOut(1500);
    },1000);
});

$(".btn-atras").on('click', function () {
  window.history.back();
  return false;
});

$(".cerrraDia").on('click', function () {
  gelocalizacioncoor();
    cerrraDia();
});

function geo_successCoor(position) {
  latitud=position.coords.latitude;
  longitud=position.coords.longitude;
  $(".locationCoor").html('<input hidden value="'+latitud+'" name="latitud"><input hidden value="'+longitud+'" name="longitud">');
}

function geo_errorCoor() {
  alert("Si no conocemos tu ubicacion puede generar errores a la de hacer tu cierre");
}

function gelocalizacioncoor(){
  alert("Por favor permita la localizacion, Si no conocemos tu ubicacion puede generar errores a la de hacer tu cierre");
  var geo_optionscoor = {
    enableHighAccuracy: true, 
    maximumAge        : 30000, 
    timeout           : 27000
  };

  var wpid = navigator.geolocation.getCurrentPosition(geo_successCoor, geo_errorCoor, geo_optionscoor);
}

function cerrraDia(){
  $.ajax({
      data: {
        'latitud':latitud,
        'logitud':longitud
      },
      url: "index.php?c=home&a=cerrarDia",
      type: "post",
      success:function(e){
        var data = JSON.parse(e);
        if(data["error"]!=0){
          ohSnap('Error desconocido del sistema',{color: 'red'});
        }else if(data["error"]==0){
          ohSnap('Ha cerrado el dia correctamente',{color: 'green'});
          setTimeout(function() {window.location.href = 'index.php' },1000);
        }else{
          error_501();
        }
      },
      error:function(){
          ohSnap('Error desconocido',{color: 'red'});
      }
    });
}

$(".desplegue-btn").on('click', function () {
  if($(this).hasClass('fa-chevron-down')){
    $(this).parent(".card-header").parent(".card").find(".divDesplegableContainer").show("slow");
    $(this).removeClass('fa-chevron-down');
    $(this).addClass('fa-chevron-up');
  }else if($(this).hasClass('fa-chevron-up')){
    $(this).parent(".card-header").parent(".card").find(".divDesplegableContainer").hide("slow");
    $(this).addClass('fa-chevron-down');
    $(this).removeClass('fa-chevron-up');
  }
});

function format(input)
{
  var num = input.value.replace(/\./g,'');
  if(!isNaN(num)){
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/,'');
    input.value = num;
  } 
  else{ alert('Solo se permiten numeros');
    input.value = input.value.replace(/[^\d\.]*/g,'');
  }
}

function formatValor(valor)
{
  var num = valor.replace(/\./g,'');
  if(!isNaN(num)){
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/,'');
    valor = num;
  }
  return valor; 
}

function formaterNumeroDecimales(numero){
  if(numero===null){
    numero=0;
  }
  numero=numero.toString();
  var valor = numero.split(".", 2);
  if(valor.length==2){
    numero=formatValor(valor[0])+"."+valor[1];
  }else{
    numero=formatValor(numero)+".00";
  }
  return numero;
}


 /*configurar el Spinner*/
/*var config = {
  decrementButton: "<strong>-</strong>", // button text
  incrementButton: "<strong>+</strong>", // ..
  groupClass: "spiner-container", // css class of the resulting input-group
  buttonsClass: "btn-outline-secondary",
  buttonsWidth: "20px",
  textAlign: "center",
  autoDelay: 500, // ms holding before auto value change
  autoInterval: 100, // speed of auto value change
  boostThreshold: 10, // boost after these steps
  boostMultiplier: "auto" // you can also set a constant number as multiplier
}
$(".Spinner").inputSpinner(config);*/

function cambiar_vista_tabla(tipo,table){
  if(tipo==1){
    $("#"+table).removeClass('cards');
    $(".tittle-card-table").addClass('list-tabla-curso');
    $(".list-tabla-curso").removeClass('tittle-card-table');
    $(".cuerpo-card-table").addClass('list-tabla-curso');
    $(".list-tabla-curso").removeClass('cuerpo-card-table');
    $(".group-cuerpo-cuad").hide();
    $(".group-cuerpo-list").show();
  }else if(tipo==2){
        $("#"+table).addClass('cards');
        $(".tittle-card-table").removeClass('list-tabla-curso');
        $(".list-tabla-curso").addClass('tittle-card-table');
        $(".cuerpo-card-table").removeClass('list-tabla-curso');
        $(".list-tabla-curso").addClass('cuerpo-card-table');
        $(".group-cuerpo-cuad").show();
        $(".group-cuerpo-list").hide();
  }    
}

function crearObjetoFormData(datos){
  var formularioData = new FormData();
  $(datos ).each(function(index, obj){
      formularioData.append(obj.name,obj.value);
  });
  return formularioData;
}

function check_todo_input_verificado(){
  $("input").each(function(index) {
    $(this).removeClass("is-invalid");
    $(this).addClass("is-valid");
  });

  $("select").each(function(index) {
    $(this).removeClass("is-invalid");
    $(this).addClass("is-valid");
  });
}

//errores de peticion ajax
function validate_errores_peticion_ajax(errores){
  $.each( errores, function( key, value ) {
    $("[name="+value["control"]+"]").addClass("is-invalid");
    $("[name="+value["control"]+"]").removeClass("is-valid");
    $(".invalid-feedback").remove();
    $("[name="+value["control"]+"]").after('<div class="invalid-feedback">'+value["error"]+'</div>');
    if(errores.length<=5){
      ohSnap(value["error"],{color: 'red'});
    }
    
  });

  $( "html, body" ).animate({
      scrollTop:0
  }, 1300, function() {
      shake($("[name="+errores[0]["control"]+"]"));
      $("[name="+errores[0]["control"]+"]").focus();
  });
}



function shake(control) {
    var interval = 100;
    var distance = 10;
    var times = 4;

    $(control).css('position', 'relative');

    for (var iter = 0; iter < (times + 1) ; iter++) {
        $(control).animate({
            left: ((iter % 2 == 0 ? distance : distance * -1))
        }, interval);
    }                                                                                                          
    $(control).animate({ left: 0 }, interval);
}

function error_501(){
  ohSnap('Error desconocido del servidor, lamentamos lo susedido por favor comuniquese con el administador',{color: 'red'});
}

function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function() {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}

$(document).ready(function() {

  

  //select 2 antiguo
  $( ".select2" ).each(function( index ) {
    $(".select2").select2({
      theme: 'bootstrap4',
      dropdownParent: $(".container-select2:eq("+index+")"),
      width: '100%'
    });
  });
  //select 2 antiguo sin dropdownParent
  $(".select-2").select2({
    theme: 'bootstrap4',
    width: '100%'
  });

});