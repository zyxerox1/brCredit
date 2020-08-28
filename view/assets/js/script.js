$( document ).ajaxSend(function() {
  $(".loader").fadeIn('slow');

});

$( document ).ajaxComplete(function() {
   setTimeout(function() {
        $(".loader").fadeOut(1500);
    },1000);
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
   $( ".select2" ).each(function( index ) {
        $(".select2").select2({
          theme: 'bootstrap4',
          dropdownParent: $(".container-select2:eq("+index+")"),
           width: '100%'
        });
    });
   
});