/*=============================================
ALTURA COL1          
=============================================*/

var alturaBody = $("body").height();

if(alturaBody < 1020 && window.innerWidth > 767){
    
	$("#col1").css({"height":"150vh"})
}
if(alturaBody > 1020 && window.innerWidth > 767){
	$("#col1").css({"height":alturaBody+"px"})
}

/*=====  Fin de ALTURA COL1  ======*/

/*=============================================
BOTONES ADMINISTRADOR          
=============================================*/
$("p#member span").click(function(){
	$("#cabezote #admin").slideToggle("fast")
	$("p#member span").toggleClass("fa-chevron-down");
	$("p#member span").toggleClass("fa-chevron-up");
})

/*=====  Fin de BOTONES ADMINISTRADOR  ======*/

/*=============================================
SLIDE            
=============================================*/
var numeroSlide = 1;
var formatearLoop = false;
var cantidadImg = $("#slide ul li").length;

$("#slide ul").css({"width": (cantidadImg*100) + "%"});
$("#slide ul li").css({"width": (100/cantidadImg) + "%"});

if (cantidadImg == 0) {
	$("#slideIzq").css({"display":"none"});
	$("#slideDer").css({"display":"none"});

}

for (index = 0; index < cantidadImg; index++) {
	
	$("#indicadores").append('<li role-slide = "' +(index+1)+'"><span class="fa fa-circle"></span></li>');
}

/* INDICADORES */

$("#indicadores li").click(function(){

	 var roleSlide = $(this).attr("role-slide");
			
	 $("#slide ul li").css({"display":"none"});
			
	 $("#slide ul li:nth-child("+roleSlide+")").fadeIn();
			
	 $("#indicadores li").css({"opacity":".5"});
			
	 $("#indicadores li:nth-child("+roleSlide+")").css({"opacity":"1"});

	 formatearLoop = true;

	numeroSlide = roleSlide;

})

/* FLECHA AVANZAR */

function avanzar(){

	if(numeroSlide >= cantidadImg){numeroSlide = 1;}

	else{numeroSlide++}

	$("#slide ul li").css({"display":"none"});
			
	$("#slide ul li:nth-child("+numeroSlide+")").fadeIn();
			
	$("#indicadores li").css({"opacity":".5"});
			
	$("#indicadores li:nth-child("+numeroSlide+")").css({"opacity":"1"});
}


$("#slideDer").click(function(){

	avanzar();

	formatearLoop = true;

})

/* FLECHA RETROCEDER */

$("#slideIzq").click(function(){

	if(numeroSlide <= 1){numeroSlide = cantidadImg;}

	else{numeroSlide--}


	$("#slide ul li").css({"display":"none"});
			
	$("#slide ul li:nth-child("+numeroSlide+")").fadeIn();
			
	$("#indicadores li").css({"opacity":".5"});
			
	$("#indicadores li:nth-child("+numeroSlide+")").css({"opacity":"1"});

	formatearLoop = true;

})

/* LOOP */

setInterval(function(){

	if(formatearLoop == true){

		formatearLoop = false;
	}

	else{

	avanzar();

	}

},5000);

/*=====  Fin de SLIDE  ======*/

/*=============================================
GALERÍA         
=============================================*/

$("ul#lightbox li a").fancybox({

	openEffect  : 'elastic',
	closeEffect  : 'elastic',
	openSpeed  : 150,
	closeSpeed : 150,
	helpers : {title :{type : 'inside'}}

});

/*=====  Fin de GALERÍA   ======*/

/*=============================================
BUSCADOR         
=============================================*/

$('#tablaSuscriptores').DataTable({
	"language": {
            "sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
        }
});

/*=====  Fin de BUSCADOR   ======*/

// /*=============================================
// ORDENAR SLIDE     
// =============================================*/

// /* Ordenar Slide */
// var almacenarOrdenImagen = new Array();
// var cambioOrdenImagen = false;

// $("#ordenarSlide").click(function(){

// 	$( "#columnasSlide").css({"cursor":"move"})
// 	$( "#columnasSlide span").hide()
		 
// 	$( "#columnasSlide").sortable({
//       	revert: true,
//       	connectWith: ".bloqueSlide",
//       	handle: ".handleImg",	
//       	stop: function( event, ui ) {

//       	cambioOrdenImagen = true;

//       	for(var i= 0; i < $( "#columnasSlide li").length; i++){

//       		almacenarOrdenImagen[i] = event.target.children[i].children[1].src;
      		
//       		}
//       	}
//     })

//     $("#ordenarSlide").hide();
//     $("#guardarSlide").show();

// })

// /* Guardar Orden Slide */ 

// $("#guardarSlide").click(function(){

// 	if(cambioOrdenImagen){

// 		$("#textoSlide ul").html("")

// 		for(var i= 0; i < $( "#columnasSlide li").length; i++){

// 	      	$("#textoSlide ul").append('<li><span class="fa fa-pencil" style="background:blue"></span><img src="'+almacenarOrdenImagen[i]+'" style="float:left; margin-bottom:10px" width="80%"><h1></h1><p></p></li>')
// 	      	}
//      }

// 	$("#columnasSlide").css({"cursor":"auto"})
// 	$("#columnasSlide span").show()

// 	$("#columnasSlide").disableSelection();

// 	$("#ordenarSlide").show();

// 	$("#guardarSlide").hide();

// })


// /*=====  Fin de ORDENAR SLIDE   ======*/