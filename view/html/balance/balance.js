$(document).ready(function() {
	$(".meta").html("Meta a recaudar: $"+formaterNumeroDecimales($(".meta").html()));
	$(".pagados").html("$"+formaterNumeroDecimales($(".pagados").html()));
	$(".nopagados").html("$"+formaterNumeroDecimales($(".nopagados").html()));
	$(".tvendido").html("$"+formaterNumeroDecimales($(".tvendido").html()));
	$(".saldoInicial").html("$"+formaterNumeroDecimales($(".saldoInicial").html()));

	$(".ventas").html("$"+formaterNumeroDecimales($(".ventas").html()));
	$(".Gastos").html("$"+formaterNumeroDecimales($(".Gastos").html()));
	$(".Retiros").html("$"+formaterNumeroDecimales($(".Retiros").html()));
	$(".caja").html("$"+formaterNumeroDecimales($(".caja").html()));
});