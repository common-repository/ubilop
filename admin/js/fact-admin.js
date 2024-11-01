
var chekarray = [];
var albarray = [];
var arrayRemitentes;
var arrayServicios;
var conta = 0;



(function( $ ) {
	'use strict';

	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */

	

	$( document ).ready(function() {

		/*$.ajax({
			url: factdata.url,
			type: 'POST',
			dataType: 'json',
			data : {
				action: 'fact_estado',
				nonce: factdata.seguridad
			}, success: function( data ){
				
	
			}, error: function( d,x,v ) {
			
				console.log(d);
				console.log(x);
				console.log(v);
				
			}
		}); */

		/*
		función de boostrap para filtrar información en en listados de tablas 
	*/

	 /**
	 * Ejecutamos la funcion de actualización de estados en los envíos
	 */
	$('.update-state-send').on('click', function(e){
		e.preventDefault();
		$('.update-state-send').addClass('disabled');
		$.ajax({
			url: factdata.url,
			type: 'POST',
			dataType: 'json',
			data : {
				action: 'fact_state',
				nonce: factdata.seguridad
			}, success: function( data ){
				if(data.result){

					$('#notifySend').attr('style','display: block; margin-top: -12px;');
					$('.update-state-send').removeClass('disabled');
					setTimeout(function(){

						$('#notifySend').fadeOut(1000);

					},2000);
				}
				
			//console.log(data.result.length)

			}, error: function( d,x,v ) {
			
				console.log(d);
				console.log(x);
				console.log(v);
				
			}
		});

   })

	document.addEventListener('DOMContentLoaded', function() {
		var elems = document.querySelectorAll('select');
		var instances = M.FormSelect.init(elems, options);
	  });

	  $(document).ready(function(){
		//$('select').formSelect();
			
	  });
	
	
		
	$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();

	
	
	});

	// elemento de carga cuando se ejecuta un crud
	var $preload = $('.preload'),
	url="?page=fact_options&id=";
	var url2="?page=fact_options&idOrden="
	var url3="?post_type=shop_order&idOrden="


	//al abrir el modal se oculta el elemento preloader
	$preload.css('display','none');
	
	//Se inicializa el elemento Modal
	$('.modal').modal()

	var accion= '';
	var idRegistro = $('#idR').attr('idRegistro');
	
	//función que filtra los resultados de ordenes transmitidas por palabras claves
	$('#buscar').on('keyup', function(e) {
		e.preventDefault();
		var value = $(this).val().toLowerCase();
		$('#tblOrdenes tr').filter( function() {

			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			
		});

	})


	/**
	 * Ejecutamos el evento keyup en el campo WS para acortar e imprimir la Url Iris 
	 */
	$('#urlWS').on('keyup', function(e) {

		e.preventDefault();
		let url = $(this).val();
		var pos = url.indexOf("FACTWS");
		let iris = url.substring(0, pos);
		$('#urlIris').val(iris+'Iris/Seguimiento?s=');

	})

	$('.txtPais').on('focusout', function(e) {

		e.preventDefault();
		let pais = $(this).val();
		let pais1 = pais.substring(0,  3);
		$('.txtPais').val(pais1);

	})

	
	/**
	 * Ejecutamos el evento click en el boton de agregar configuración fact
	 */
    $('.add-fact-table').on('click', function(e){
		e.preventDefault();
		$('#add_fact_table').modal('open');
		
		//console.log('id',idRegistro);
		
		if(idRegistro != null){
			//Si hay un registro en la tablad e config
			$('form label').addClass('active');
			$('#codigo').val($('#cod').attr('codigo')) ;
			$('#clave').val($('#cla').attr('clave')) ;
			$('#urlWS').val($('#wse').attr('webService'));
			$('#urlIris').val($('#iri').attr('iris'));
			accion = 'update';

		}else{
			//Si hay un registro en la tablad e config
			accion = 'add';
		}
	})

	/**
	 * Ejecutamos el evento click en el boton de agregar configuración fact
	 */
    $('.view_tuto').on('click', function(e){
		e.preventDefault();
		$('#view_tutorial').modal('open');
		
		//console.log('id',idRegistro);
		
	})



/**
* Ejecutamos el evento click en cada checkbox  para agregar el enlace de transmision masiva
*/
$('#the-list .check-column input').on('click', function() {
	//e.preventDefault();
	//console.log('funciona', $(".chkOrigen:checked").val());
  
	//if($(this).prop('checked')){

		console.log('dentro');
  
		chekarray = [];
  
		$('#the-list .check-column input:checked').each(
			function() {
				chekarray.push($(this,":checked").val())					
			}
		);
  
		console.log('dentro', chekarray);
  
		if(chekarray.length > 0){
  
		  if ($('#tranMasive').length) {
			  // si existe
			} else {

				//console.log('string', $('.wp-heading-inline').html().length);

				if($('.wp-heading-inline').html().length >  1){

					$( '<a id="tranMasive" class="tranMasive button" style="margin-left: 10px;" onclick="FactMasive();"  ><i class="icon-send"></i>&nbsp;Transmitir Masivamente</a>' ).insertAfter( ".action" );
			  		//$('.dropdown-menu').append('<li><a id="tranMasive" class="tranMasive pointer" onclick="FactMasive();"  ><i class="icon-send"></i>&nbsp;Transmitir Masivamente</a></li>');
				}
  
			  
			}
		  
  
		}else if(chekarray.length < 1){
  
		  $('.tranMasive').remove();
		}
  
		//console.log('dentro', chekarray.length);		
  
  });

  $('#cb-select-all-1, #cb-select-all-2').on('click', function() {
	//e.preventDefault();

  
		chekarray = [];

	setTimeout(function(){
  
		$('.check-column input:checked').each(
			function() {
				if($(this,":checked").val() != 'on'){
					chekarray.push($(this,":checked").val())
				}					
			}
		);
  
		console.log('dentro', chekarray);
  
		if(chekarray.length > 0){
  
		  if ($('#tranMasive').length) {
			  // si existe
			} else {

				

				if($('.wp-heading-inline').html().length == 8){
	
				$( '<a id="tranMasive" class="tranMasive button" style="margin-left: 10px;" onclick="FactMasive();"  ><i class="icon-send"></i>&nbsp;Transmitir Masivamente</a>' ).insertAfter( ".action" );
				//$('.dropdown-menu').append('<li><a id="tranMasive" class="tranMasive pointer" onclick="FactMasive();"  ><i class="icon-send"></i>&nbsp;Transmitir Masivamente</a></li>');
				}
			}
		  
  
		}else if(chekarray.length < 1){
  
		  $('.tranMasive').remove();
		}
	},2000);
  
		//console.log('dentro', chekarray.length);		
  
  });

  

	/**
	 * Ejecutamos el evento click en el select para mostrar la data de cada remitente
	 */
	$( ".sltRemitente" ).change(function(e) {
		e.preventDefault();
		var datos = $(".sltRemitente").val();
		var parsero = JSON.parse(datos);
		//$('.btn-transmitir').attr('id-remitente', parsero.id);
		$('.sltRemitente').attr('value', parsero.id);
		$('.btn-transmitir').attr('remitente', parsero.id);
		$('#nombre').attr('remitente', parsero.id);
		//console.log('datos', parsero);
		$('#idRemi').val(parsero.id);
		var nombre = parsero.nombre.replace(/-/g, " ");
		$('#nombre').val(nombre);
		var direccion = parsero.direccion.replace(/-/g, " ");
		$('#direccion').val(direccion);
		var poblacion = parsero.poblacion.replace(/-/g, " ");
		$('#poblacion').val(poblacion);
		$('#codPostal').val(parsero.cod_postal);
		$('#telefono').val(parsero.telefono);
		$('#email').val(parsero.email);
		$('#contacto').val(parsero.contacto);
		$('.servicio').empty();
		$('.servicio').append('<option value="'+parsero.servicio+'">'+parsero.servicio+'</option>');
		
		
		

		let estado = parsero.estado;
		$('#sltEstado').val(estado);
		if(estado == 1){			
			$('#sltEstado').attr('disabled', true);
			$('#sltEstado').attr('value', 1);
		}else{
			$('#sltEstado').attr('disabled', false);
			$('#sltEstado').attr('value', 0);
		}
		
			
	

	});
	


	$( ".sltRemi" ).change(function(e) {
		//e.preventDefault();
		var datos = $(".sltRemi").val();
		var parsero = JSON.parse(datos);
		//$('.btn-transmitir').attr('id-remitente', parsero.id);
		$('.sltRemi').attr('value', parsero.id);

		console.log('sltRemi');

		$('.sltRemi').append('<option value="'+parsero.id+'">'+parsero.nombre+'</option>');
					
	

	});

    $(document).on( 'click', '[data-sender]', function(e){
		
		e.preventDefault();

		//var dir = $('.imgSpinner').attr('dir');
		//$('.imgLoading').attr('style', 'display:block; margin:3px 4px;')
		if(arrayRemitentes == null){

		$('.sltRemitente').empty();
		$('.sltRemitente').append('<option value="">...</option>');				
		$.ajax({
			url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_senders',
					nonce: factdata.seguridad,
					tipo: 'view'
				}, success: function( data ){
					
					
					
					// si la respuesta de la accion en db es verdadera
					if( data.remitentes ){

						arrayRemitentes = data.remitentes;

						//split convierte una cadena string indentificada por un separador(" " , - etc) en un array
						//arrayServicios = servicios.split(" ");

						//console.log('arrayServicios', arrayServicios);
						$('.sltRemitente').empty();
						var i = 0;
						$.each(arrayRemitentes, function(key,value){
							/*var campos = new Array();
							campos['id'] = value.id;
							campos['nombre'] = value.nombre;
							campos['direccion'] = value.direccion;
							campos['poblacion'] = value.poblacion;
							campos['cod_postal'] = value.cod_postal;
							campos['pais'] = value.pais;
							campos['telefono'] = value.telefono;
							campos['email'] = value.email;
							campos['contacto'] = value.contacto;
							campos['estado'] = value.estado; */

							var json = JSON.stringify(arrayRemitentes[i]);

							var data1 = json.replace(/ /g, "-");

							//arrayCampos = campos.split(",");

							$('.sltRemitente').append('<option value='+data1+'>'+value.nombre+'</option>');
							//console.log('arrayRemitentes', json);
							i++;
						});

						//$('.imgLoading').attr('style', 'display:none;')


					}
					else{


					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
		});

		}				
		
	});

	$(document).on( 'click', '[data-sender1]', function(e){
		
		e.preventDefault();

		//var dir = $('.imgSpinner').attr('dir');
		//$('.imgLoading').attr('style', 'display:block; margin:3px 4px;')
		if(arrayRemitentes == null){

		$('#sltRemitente').empty();
		$('#sltRemitente').append('<option value="">...</option>');				
		$.ajax({
			url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_senders',
					nonce: factdata.seguridad,
					tipo: 'view'
				}, success: function( data ){
					
					
					
					// si la respuesta de la accion en db es verdadera
					if( data.remitentes ){

						arrayRemitentes = data.remitentes;
						$('#sltRemitente').empty();
						var i = 0;
						$.each(arrayRemitentes, function(key,value){

							var json = JSON.stringify(arrayRemitentes[i]);

							var data1 = json.replace(/ /g, "-");

							//arrayCampos = campos.split(",");

							$('#sltRemitente').append('<option value='+data1+'>'+value.nombre+'</option>');
							//console.log('arrayRemitentes', json);
							i++;
						});

						//$('.imgLoading').attr('style', 'display:none;')


					}
					else{


					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
		});

		}				
		
	});



	/**
	 * Ejecutamos el evento click en el selectpara traer servicios autorizados del cliente
	 */
	
    $(document).on( 'click', '[data-service]', function(e){
		
		e.preventDefault();

		//var dir = $('.imgSpinner').attr('dir');
		//$('.imgLoading').attr('style', 'display:block; margin:3px 4px;')
		if(arrayServicios == null){

		//$('.servicio').empty();
		$('.servicio').append('<option value="">...</option>');				
		$.ajax({
			url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_service',
					nonce: factdata.seguridad,
					tipo: 'view'
				}, success: function( data ){
					
					
					
					// si la respuesta de la accion en db es verdadera
					if( data.servicios ){

						let servicios = data.servicios;

						//split convierte una cadena string indentificada por un separador(" " , - etc) en un array
						arrayServicios = servicios.split(" ");

						//console.log('arrayServicios', arrayServicios);
						$('.servicio').empty();

						$.each(arrayServicios, function(key,value){
							$('.servicio').append('<option value="'+value+'">'+value+'</option>');
						});

						//$('.imgLoading').attr('style', 'display:none;')


					}
					else{


					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
		});

		}				
		
	});

	

	/**
	 * Ejecutamos el evento click en el boton  ver detalles del álbaran fact
	 */
	$(document).on( 'click', '[data-fact-id-view]', function(){

		$('#tblEnvio tbody tr td').html( '' );

		var albaran = $(this).attr('data-fact-id-view');
		//console.log('albaran', albaran);
		
		$('#view_fact_order').modal('open');

		if(albaran != null){
			$preload.css('display','flex');
			$.ajax({
				url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_view',
					nonce: factdata.seguridad,
					albaran: albaran,
					tipo: 'view'
				}, success: function( data ){
					
					
					// si la respuesta de la accion en db es verdadera
					if( data.llaves ){

						//console.log('llaves', data.llaves);
						$('#tblEnvio tbody tr td').append( data.llaves );
						
						//esperamos un segundo y redirigimos a la pagina fact_options
						setTimeout(function(){
							$preload.css('display','none');
						},300);

					}
					else{


					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
			});
		}

	});

	/**
	 * Ejecutamos el evento click en el boton  ver detalles del álbaran fact
	 */
	$(document).on( 'click', '[data-fact-return-view]', function(){

		$('#tblRecogida tbody tr td').html( '' );

		var recogida = $(this).attr('data-fact-return-view');
		//console.log('albaran', albaran);
		
		$('#view_fact_return').modal('open');

		if(recogida != null){
			$preload.css('display','flex');
			$.ajax({
				url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_view_return',
					nonce: factdata.seguridad,
					recogida: recogida,
					tipo: 'view'
				}, success: function( data ){
					
					
					// si la respuesta de la accion en db es verdadera
					if( data.llaves ){

						//console.log('llaves', data.llaves);
						$('#tblRecogida tbody tr td').append( data.llaves );
						
						//esperamos un segundo y redirigimos a la pagina fact_options
						setTimeout(function(){
							$preload.css('display','none');
						},300);

					}
					else{


					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
			});
		}

	});


	/**
	 * Ejecutamos el evento click en el boton de ver estados del envio fact
	 */

	$(document).on( 'click', '[data-fact-id-list]', function(){

		$('#tblEstados tbody').html( '' );

		var albaran = $(this).attr('data-fact-id-list');
		
		$('#view_fact_list').modal('open');

		if(albaran != null){
			$preload.css('display','flex');
			$.ajax({
				url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_list',
					nonce: factdata.seguridad,
					albaran: albaran,
					tipo: 'view'
				}, success: function( data ){				
					
					// si la respuesta de la accion en db es verdadera
					if( data.estados ){

						$('#tblEstados tbody').append( data.estados);
						
						//esperamos un segundo y redirigimos a la pagina fact_options
						setTimeout(function(){
							$preload.css('display','none');
						},300);

					}
					else{


					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
			});
		}

	});

	/**
	 * Ejecutamos el evento click en el boton de ver estados de la recogida fact
	 */

	$(document).on( 'click', '[data-fact-return-list]', function(){

		$('#tblEstadosReturn tbody').html( '' );

		var recogida = $(this).attr('data-fact-return-list');
		
		$('#view_fact_state').modal('open');

		if(recogida != null){
			$preload.css('display','flex');
			$.ajax({
				url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_list',
					nonce: factdata.seguridad,
					recogida: recogida,
					tipo: 'viewReturn'
				}, success: function( data ){				
					
					// si la respuesta de la accion en db es verdadera
					if( data.estados ){

						$('#tblEstadosReturn tbody').append( data.estados);
						
						//esperamos un segundo y redirigimos a la pagina fact_options
						setTimeout(function(){
							$preload.css('display','none');
						},300);

					}
					else{


					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
			});
		}

	});


	/**
	 * Ejecutamos el evento click en el boton de filtrar ordenes transmitidas al fact
	 */
	$('#btnFiltrar').on('click', function(e){ 

		e.preventDefault();

		$('#btnFiltrar').addClass('disabled');
		$('.imgSpinner').removeClass('hide');
		let fechaDesde = $('#fechaDesde').val();
		let fechaHasta = $('#fechaHasta').val();
		//window.location.reload();
		window.location.href = factdata.url1 + '?page=fact_orders&fechaDesde=' + fechaDesde + '&fechaHasta=' + fechaHasta;

	})

	/**
	 * Ejecutamos el evento click en el boton de nuevo remitente para limpliar los controles
	 */
	$('.newSender').on('click', function(e){ 

		//e.preventDefault();

		$('#idRemi').val('');
		$('#nombre').val('');
		$('#direccion').val('');
		$('#poblacion').val('');
		$('#codPostal').val('');
		$('#telefono').val('');
		$('#email').val('');
		$('#contacto').val('');
		$('#nombre').attr('remitente','');
		$('#sltEstado').attr('disabled', false);
		$('#sltRemitente').empty();
		$('#sltRemitente').append('<option value="">Nuevo Remitente</option>');

	})
	
    
	/**
	 * Ejecutamos el evento click en el boton de guardar configuración fact
	 */
	$('#crearFactConfig').on('click', function(e){

		e.preventDefault();

		$('#crearFactConfig').addClass('disabled');
		$('.imgSpinner').removeClass('hide');

		var $codigo = $('#codigo'),
		cv = $codigo.val();
		var $clave = $('#clave'),
		lv = $clave.val();
		//console.log('clave', clave);
		var $ws = $('#urlWS'),
		wv = $ws.val();
		var iris = $('#urlIris').val();
			
			//verificamos que ningunos de los campos del formulario estés vacios
			if(cv == ""){
				$('#codigo').addClass('invalid');
				$preload.css('display','none');
				$('#crearFactConfig').removeClass('disabled');
				$('.imgSpinner').addClass('hide');
			}else if(lv == ""){
				$('#clave').addClass('invalid');
				$('#crearFactConfig').removeClass('disabled');
				$('.imgSpinner').addClass('hide');
			}else if(wv == ""){
				$('#urlWS').addClass('invalid');
				$('#crearFactConfig').removeClass('disabled');
				$('.imgSpinner').addClass('hide');
				
			} else if(cv != "" && lv != "" && wv != ""){

				//ejecutamos ajax para el guardado de los datos en db
				$.ajax({
					url: factdata.url,
					type: 'POST',
					dataType: 'json',
					data : {
						action: 'fact_data',
						nonce: factdata.seguridad,
						id: idRegistro,
						codigo_cliente: cv,
						clave: lv,
						url_ws: wv,
						iris: iris,
						tipo: accion
					}, success: function( data ){
						//console.log('result', data);

						// si la respuesta de la accion en db es verdadera
						if( data.result ){							

							if(idRegistro != null){
								url += idRegistro;
							}else{
								url += data.insert_id;
							}

							//esperamos un segundo y redirigimos a la pagina fact_options
							setTimeout(function(){
								location.href = url;
								
							},3);

						}
						else{
							$('#crearFactConfig').removeClass('disabled');
							$('.imgSpinner').addClass('hide');
						}
					}, error: function( d,x,v ) {
                    
						console.log(d);
						console.log(x);
						console.log(v);
						
					}
				});
	
			}
		
	})


	/**
	 * Ejecutamos el evento click en el boton de guardar remitente fact
	 */
	$('.remitenteg').on('click', function(e){

		e.preventDefault();

		$('.remitenteg').addClass('disabled');
		$('.imgSpinner').removeClass('hide');

		var idRemitente = $('#nombre').attr('remitente');
		//console.log('id', idRemitente.typeOf);

		if(idRemitente != ""){

			accion = 'update';

		}else{

			accion = 'add';
		}

		var $nombre = $('#nombre'),
		nb = $nombre.val();
		var direccion = $('#direccion').val();
		var $poblacion = $('#poblacion'),
		pb = $poblacion.val();
		var codPostal = $('#codPostal').val();
		var pais = $('#pais').val().toUpperCase();
		var $telefono = $('#telefono'),
		tf = $telefono.val();
		var email = $('#email').val();
		var contacto = $('#contacto').val();
		let observacion = $('#observaciones').val();
		let servicio = $('#servicio').val();
		if($(".chkServicio:checked").val() == "on"){

			$('.servicio1').val() != "" ? servicio = $('.servicio1').val() : servicio = '1';

		}else{

			$('#servicio').val() != "" ? servicio = $('#servicio').val() : servicio = '1';

		}
		let estado ;
 
		$('#sltEstado').val() != "" ? estado = $('#sltEstado').val() : estado = 0 ;
			
			//verificamos que ningunos de los campos del formulario estés vacios
			if(nb == ""){
				$('#nombre').addClass('invalid');
				$('.remitenteg').removeClass('disabled');
				$('.imgSpinner').addClass('hide');
				Swal.fire({title   : 'Grabe Remitente con los datos requeridos', icon : 'error'});
			}else if(pb == ""){
				$('#poblacion').addClass('invalid');
				$('.remitenteg').removeClass('disabled');
				$('.imgSpinner').addClass('hide');
				Swal.fire({title   : 'Grabe Remitente con los datos requeridos', icon : 'error'});
			}else if(tf == ""){
				$('#telefono').addClass('invalid');
				$('.remitenteg').removeClass('disabled');
				$('.imgSpinner').addClass('hide');
				Swal.fire({title   : 'Grabe Remitente con los datos requeridos', icon : 'error'});
				
			} else if(nb != "" && nb != "" && tf != ""){


				//ejecutamos ajax para el guardado de los datos en db
				$.ajax({
					url: factdata.url,
					type: 'POST',
					dataType: 'json',
					data : {
						action: 'fact_sender',
						nonce: factdata.seguridad,
						remitente: idRemitente,
						nombre: nb,
						direccion: direccion,
						poblacion: pb,
						codigo: codPostal,
						pais: pais,
						telefono: tf,
						email: email,
						contacto: contacto,
						observaciones: observacion,
						servicio: servicio,
						estado: estado,
						tipo: accion
					}, success: function( data ){
						console.log('result', data);

						// si la respuesta de la accion en db es verdadera
						if( data.result ){
							console.log('observa', data.observa);
							
							//$('#btnRemitente').removeClass('disabled');
							$('.imgSpinner').addClass('hide');

							setTimeout(function(){

								window.location.reload(); 

							},100);

						}
						else{
							$('.remitenteg').removeClass('disabled');
							$('.imgSpinner').addClass('hide');
						}
					}, error: function( d,x,v ) {
                    
						console.log(d);
						console.log(x);
						console.log(v);
						
					}
				});
	
			}
		
	})


	/**
	 * Ejecutamos el evento click en el boton de guardar parametros CRON
	 */
	$('#btnCron').on('click', function(e){
		e.preventDefault();

		$('#btnCron').addClass('disabled');
		$('.imgSpinner').removeClass('hide');

		var idCron = $('#cron').attr('cron');
		//console.log('id', idRemitente.typeOf);

		if(idCron != ""){

			accion = 'update';
			console.log('id', accion);
		}else{

			accion = 'add';
			console.log('id', accion);
		}

		let documentado = $('#documentado').val();
		let transmitido = $('#transmitido').val();
		let procesado = $('#procesado').val();
		let transito = $('#transito').val();
		let reparto = $('#reparto').val();
		let entregado = $('#entregado').val();
		let cancelado = $('#cancelado').val();
		let incidencia = $('#incidencia').val();
		let horas = $('#tiempo').val();



				//ejecutamos ajax para el guardado de los datos en db
				$.ajax({
					url: factdata.url,
					type: 'POST',
					dataType: 'json',
					data : {
						action: 'fact_cron',
						nonce: factdata.seguridad,
						cron: idCron,
						documentado: documentado,
						transmitido: transmitido,
						procesado: procesado,
						transito: transito,
						reparto: reparto,
						entregado: entregado,
						cancelado: cancelado,
						incidencia: incidencia,
						hora: horas,
						tipo: accion
					}, success: function( data ){
						//console.log('result', data);

						// si la respuesta de la accion en db es verdadera
						if( data.result ){

							$('.imgSpinner').addClass('hide');

							setTimeout(function(){

								window.location.reload(); 

							},100);

						}
						else{
							$('#btnCron').removeClass('disabled');
							$('.imgSpinner').addClass('hide');
						}
					}, error: function( d,x,v ) {
                    
						console.log(d);
						console.log(x);
						console.log(v);
						
					}
				});
	
			
		
	})

	let orderId;
	let metodoPago;
	let captureIdOrders = document.getElementsByClassName('btn-transmitir');
		for (let captureIdOrder of captureIdOrders) {
			captureIdOrder.addEventListener('click', function (event) {
				event.preventDefault();
				

				//createDraft(createDraftButton);
				
				var father= $(this).parent().parent().attr('id');
				console.log('parent',father);
				orderId = father.replace(/[^0-9]+/g, "")
				console.log('Replace',orderId);
				//orderId = parseInt(captureIdOrder.getAttribute('data-order-id'));
				metodoPago = captureIdOrder.getAttribute('metodo-pago');
				let servicio = captureIdOrder.getAttribute('servicio');
				let weight = captureIdOrder.getAttribute('peso');
				let idRemi = captureIdOrder.getAttribute('remitente');
				//console.log(idRemi.length);
				let nombreRemi = captureIdOrder.getAttribute('nombre');

				if(weight == "" || weight == 0 ){
					weight = 1;
				}
				if(!servicio){
					servicio = "1";
				}
				
				//console.log('metodo', metodoPago);
				var html;
				var dir = $('.imgSpinner').attr('dir');
				var transmitido = 0;

				//<img class="imgLoading" style="margin: 3px 4px; display:none;" src="'+dir+'admin/img/loader2.gif" width="25px"  alt="">

				if(metodoPago == 'cod'){

					html = '<img src="'+dir+'admin/img/sb-black.png" style="margin-top: 5px;border-radius: 50%;" width="52px" /><br><br><form action="" method="post" form-fact><table style="padding:5px;">'+
					'<tr><td colspan="2"><label for="sltRemitente" style="font-size: 1rem; color: #9e9e9e;" class="active">Remitente Predeterminado</label><br><select data-sender="" id="sltRemitente" style="width:92%;" value="'+idRemi+'" class="form-control validate sltRemitente"><option value="'+idRemi+'" selected="">'+nombreRemi+'</option></select></td>'+
					'<tr><td><input chk-servicio="" type="checkbox"  id="chkServicio" class="chkServicio"><label for="servicio" style="font-size: 1rem; color: #9e9e9e;" class="active">&nbsp Servicio</label><br><input type="text"  name="servicio" class="servicio1" style="display:none" value="'+servicio+'"/><select data-service="" id="servicio" style="width:83%;" value="'+servicio+'" class="form-control validate servicio"><option value="'+servicio+'" selected="">'+servicio+'</option></select></td>'+
					'<td><label for="bultos" style="font-size: 1rem; color: #9e9e9e;" class="active">Bultos</label><input type="text" id="bultos" value="1" class="validate"></td></tr>'+
					'<tr><td><label for="peso" style="font-size: 1rem; color: #9e9e9e;" class="active">Peso</label><input type="text" id="peso" value="'+ weight +'" class="validate"></td>'+
					'<td><label for="alto" style="font-size: 1rem; color: #9e9e9e;" class="active">Alto</label><input type="text" id="alto" value="1" class="validate"></td></tr>'+
					'<tr><td><label for="ancho" style="font-size: 1rem; color: #9e9e9e;" class="active">Ancho</label><input type="text" id="ancho" value="1" class="validate"></td>'+
					'<td><label for="largo" style="font-size: 1rem; color: #9e9e9e;" class="active">Largo</label><input type="text" id="largo" value="1" class="validate"></td></tr>'+
					'<tr><td colspan="2"><label style="font-size: small;"> <input type="checkbox" checked id="chkPortes" class="portesD">&nbsp Incluir costo del envío </td></tr>'+
					//'<tr><td colspan="2"><label style="font-size: small;">&nbsp&nbsp <input type="checkbox" id="chkDebido" class="debidoP">&nbsp Incluir Portes Debido &nbsp&nbsp </td></tr>'+
					'</table></form>';
				}else{

					html = '<img src="'+dir+'admin/img/sb-black.png" style="margin-top: 5px;border-radius: 50%;" width="52px"  /><br><br><form action="" method="post" form-fact><table style="padding:5px;">'+
					'<tr><td colspan="2"><label for="sltRemitente" style="font-size: 1rem; color: #9e9e9e;" class="active">Remitente Predeterminado</label><br><select data-sender="" id="sltRemitente" style="width:92%;" value="'+idRemi+'" class="form-control validate sltRemitente"><option value="'+idRemi+'" selected="">'+nombreRemi+'</option></select></td>'+
					'<tr><td><input chk-servicio="" type="checkbox"  id="chkServicio" class="chkServicio"><label for="servicio" style="font-size: 1rem; color: #9e9e9e;" class="active">&nbsp Servicio</label><br><input type="text"  name="servicio" class="servicio1" style="display:none" value="'+servicio+'"/><select data-service="" id="servicio" style="width:83%;" value="'+servicio+'" class="form-control validate servicio"><option value="'+servicio+'" selected="">'+servicio+'</option></select></td>'+
					'<td><label for="bultos" style="font-size: 1rem; color: #9e9e9e;" class="active">Bultos</label><input type="text" id="bultos" value="1" class="validate"></td></tr>'+
					'<tr><td><label for="peso" style="font-size: 1rem; color: #9e9e9e;" class="active">Peso</label><input type="text" id="peso" value="'+ weight +'" class="validate"></td>'+
					'<td><label for="alto" style="font-size: 1rem; color: #9e9e9e;" class="active">Alto</label><input type="text" id="alto" value="1" class="validate"></td></tr>'+
					'<tr><td><label for="ancho" style="font-size: 1rem; color: #9e9e9e;" class="active">Ancho</label><input type="text" id="ancho" value="1" class="validate"></td>'+
					'<td><label for="largo" style="font-size: 1rem; color: #9e9e9e;" class="active">Largo</label><input type="text" id="largo" value="1" class="validate"></td></tr>'+
					'</table></form>';
				}

				
			
			   // $('.btn-transmitir i').addClass('fa fa-spinner fa-spin');
			   $('.post-'+orderId+' .imgSpinner').attr('style', 'display:block; margin:3px 4px;')
			   $('.btn-transmitir').addClass('disabled');
			   
			   //$("button[data-order-id='"+orderId+"']").next("td.fact_label").html("<p>Ajai</p>");

			   

				if(orderId != ""){

					Swal.fire({
						title				: "Transmitir Orden",
						text				: 'Confirma los datos',
						html				: html,
						//icon                : "question",
						showCancelButton    : true,
						confirmButtonText   : "Generar Etiqueta",
						closeOnConfirm      : true,
						showLoaderOnConfirm : true,
						preConfirm: () => {
							return fetch('')
							  .then(response => {
							
							$("button[data-order-id='"+orderId+"']").addClass('disabled');
							var servicio;
							var bultos;
							var peso;
							var alto ;
							var ancho;
							var largo ;
							var portes = false;
							var debido = false;
							var parserito = $('#sltRemitente').val();
							
							if(parserito.length > 5){
								console.log(parserito.length);
								parserito = JSON.parse($('#sltRemitente').val());
								$('#sltRemitente').val()!= "" ? idRemi = parserito.id : idRemi = '';
								//console.log('remitente', idRemi);
							}else{
								$('#sltRemitente').val()!= "" ? idRemi = $('#sltRemitente').val() : idRemi = '';
							}

							
							if($(".chkServicio:checked").val() == "on"){

								$('.servicio1').val() != "" ? servicio = $('.servicio1').val() : servicio = '1';
					
							}else{
					
								$('#servicio').val() != "" ? servicio = $('#servicio').val() : servicio = '1';
					
							}
							$('#bultos').val() != "" ? bultos = $('#bultos').val() : bultos = 0;
							$('#peso').val() != "" ? peso = $('#peso').val() : peso = 0;
							$('#alto').val() != "" ? alto = $('#alto').val() : alto = 0;
							$('#ancho').val() != "" ? ancho = $('#ancho').val() : ancho = 0;
							$('#largo').val() != "" ? largo = $('#largo').val() : largo = 0;
							$("#chkPortes:checked").val() == "on" ? portes = "true" : portes = "false";
							//$("#chkDebido:checked").val() == "on" ? debido = "true" : debido = "false";
							//console.log('remitente', idRemi);

						
			
							$.ajax({

								url: factdata.url,
								type: 'POST',
								dataType: 'json',
								data: {
				
									action: 'fact_send',
									nonce: factdata.seguridad,
									servicio: servicio,
									bultos: bultos,
									pes: peso,
									alt: alto,
									anch: ancho,
									larg: largo,
									portes: portes,
									debido: debido,
									order: orderId,
									idsender: idRemi
								}, success: function( data ){
									//console.log('data', data);				

										if(data.infoWs == 'OK'){

											console.log('parametros', data.param);
											console.log('resultado', data.result);

											//console.log('result', data.result);
											/*Swal.fire({
												title   : 'Transmición al Fact',
												text    : 'La Orden: ' + data.idOrden + ' ha sido grabada correctamente en FACT con el numero de Albaran: '+ data.albaran +'',
												icon    : 'success',
												timer   : 5000
											}); */
											
											//location.href = url3;
											$("button[data-order-id='"+orderId+"']").removeClass('button btn-transmitir');
											$("button[data-order-id='"+orderId+"']").addClass('order-status status-processing tips disabled');
											$("button[data-order-id='"+orderId+"'] span").html('Transmitido');
											$(".post-"+orderId+" .fact_label").html('<button type="button" class="button btnLabel" albaran="' + data.albaran + '"><span>Imprimir Etiqueta</span></button>');
											$('.btn-transmitir').removeClass('disabled');
											$('.post-'+orderId+' .imgSpinner').attr('style', 'display:none; margin:3px 4px;');


										}else{

				
											$('.btn-transmitir').removeClass('disabled');
											$('.post-'+orderId+' .imgSpinner').attr('style', 'display:none; margin:3px 4px;')

											Swal.fire({
												icon: 'error',
												title: 'Oops...',
												text: data.infoWs
											  })
											  


										}

								}, error: function( d,x,v ) {
							
									console.log(d);
									console.log(x);
									console.log(v);
									$('.post-'+orderId+' .imgSpinner').attr('style', 'display:none; margin:3px 4px;')
									
								}
							});
								
							  })
							  
						  },
						  allowOutsideClick: () => !Swal.isLoading()
					}).then((result) =>{
			
						if( result.isConfirmed ) {

							//$('#codigo').addClass('invalid')
							
							
		    
								
								
						
							
							
			
						} else {
			
							$('.btn-transmitir').removeClass('disabled');
							$('.post-'+orderId+' .imgSpinner').attr('style', 'display:none; margin:3px 4px;');
							//$('.imgSpinner').addClass('hide');
							
			
						}
						arrayServicios = null;
						arrayRemitentes = null;
						
			
					}); 

					
				
		}

			

			});
			
		}


		/**
	 * Ejecutamos el evento click en el boton para imprimir la etiqueta desde el listado de woocomerce
	 */

	$(document).on( 'click', '[albaran]', function(){

		var albaran = $(this).attr('albaran');
		console.log('albaran', albaran);

		$(this).addClass('disabled');
		$(this).removeClass('hide');
		
		$.ajax({
			url: factdata.url,
			type: 'POST',
			dataType: 'json',
			data : {
				action: 'fact_label',
				nonce: factdata.seguridad,
				albaran: albaran,
				tipo: 'view'
			}, success: function( data ){
				
				// si la respuesta de la accion en db es verdadera
				if( data.etiqueta){
					
					
					window.open(data.etiqueta);

				}
				else{
					Swal.fire({
						title   : 'Etiqueta',
						text    : 'Info: ' + data.mensaje + '',
						type    : 'error',
						timer   : 3500
					});

				}
			}, error: function( d,x,v ) {
			
				console.log(d);
				console.log(x);
				console.log(v);
				
			}
		}); 
		
		setTimeout(function(){
		    
		    $('.btnLabel').removeClass('disabled');
		    
		},3000);

	 })

	/**
	 * Ejecutamos el evento click en el boton para imprimir la etiqueta desde el listado de ordenes transmitidas
	 */
	$(document).on( 'click', '[data-fact-id-label]', function(){
		
		$('#urlLabelPdf').attr('href','');
		$('#ifmLabelPdf').attr('src','');
		$(this).addClass('disabled');

		var albaran = $(this).attr('data-fact-id-label');
		//console.log('albaran', albaran);
		
		//$('#view_fact_label').modal('open');

		if(albaran != null){
			$preload.css('display','flex');

			$.ajax({
				url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_label',
					nonce: factdata.seguridad,
					albaran: albaran,
					tipo: 'view'
				}, success: function( data ){
					
					
					// si la respuesta de la accion en db es verdadera
					if( data.etiqueta){
						
						//$('#tblEtiqueta tbody tr td').append( data.etiqueta );
						$('#urlLabelPdf').attr('href',data.etiqueta);
						$('#ifmLabelPdf').attr('src',data.etiqueta);
						
						window.open(data.etiqueta);
						

						setTimeout(function(){
							$('.label').removeClass('disabled');
							$preload.css('display','none');
						},300);

					}
					else{
						$('.label').removeClass('disabled');
						//$('#view_fact_label').modal('close');

						Swal.fire({
							title   : 'Etiqueta',
							text    : 'Info: ' + data.mensaje + '',
							type    : 'error',
							timer   : 3500
						});

					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					$('.label').removeClass('disabled');
					
				}
			}); 
		}

	});

	
	/**
	 * Ejecutamos el evento click en el boton para imprimir la etiqueta pdf de la recogida 
	 */
	$(document).on( 'click', '[data-fact-return-label]', function(){
		
		$(this).addClass('disabled');

		var recogida = $(this).attr('data-fact-return-label');
		//console.log('albaran', albaran);
		
		//$('#view_fact_label').modal('open');

		if(recogida != null){
			$preload.css('display','flex');

			$.ajax({
				url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_label',
					nonce: factdata.seguridad,
					recogida: recogida,
					tipo: 'viewReturn'
				}, success: function( data ){
					
					
					// si la respuesta de la accion en db es verdadera
					if( data.etiqueta){
						
						
						window.open(data.etiqueta);
						

						setTimeout(function(){
							$('.label').removeClass('disabled');
							$preload.css('display','none');
						},300);

					}
					else{
						$('.label').removeClass('disabled');
						//$('#view_fact_label').modal('close');

						Swal.fire({
							title   : 'Etiqueta',
							text    : 'Info: ' + data.mensaje + '',
							type    : 'error',
							timer   : 3500
						});

					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					$('.label').removeClass('disabled');
					
				}
			}); 
		}

	});


	/**
	 * Ejecutamos el evento click en el boton para mostrar e imprimir las etiquetas PDF en Masivo
	 */
	$(document).on( 'click', '[alba-desde-masive]', function(){
		
		$('#urlMasivePdf').attr('href','');
		$('#ifmMasivePdf').attr('src','');
		$(this).addClass('disabled');

		var albaranDesde = $(this).attr('alba-desde-masive');
		var albaranHasta = $(this).attr('alba-hasta-masive');
		
		//$('#view_fact_masive').modal('open');

			$preload.css('display','flex');

			$.ajax({
				url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_masive',
					nonce: factdata.seguridad,
					albaDesde: albaranDesde,
					albaHasta: albaranHasta,
					tipo: 'view'
				}, success: function( data ){	
					
					console.log('data', data);
					console.log('etiqueta', data.etiqueta);
					
					// si la respuesta de la accion en db es verdadera
					if( data.etiqueta){
						
						//$('#tblEtiqueta tbody tr td').append( data.etiqueta );
						$('#urlMasivePdf').attr('href',data.etiqueta);
						$('#ifmMasivePdf').attr('src',data.etiqueta);

						
						window.open(data.etiqueta);
						

						setTimeout(function(){
							$('.masive').removeClass('disabled');
							$preload.css('display','none');
						},300);

					}
					else{
						$('.masive').removeClass('disabled');
						//$('#view_fact_masive').modal('close');

						Swal.fire({
							title   : 'Etiqueta',
							text    : 'Info: ' + data.info + '',
							type    : 'error',
							timer   : 3500
						});

					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
			}); 
	

	});

	


	/**
	 * Ejecutamos el evento click en el boton para mostrar e imprimir el manifiesto
	 */
	$(document).on( 'click', '[data-fact-id-manifest]', function(){
		
		$('#urlManifiestoPdf').attr('href','');
		$('#ifmManifiestoPdf').attr('src','');
		$(this).addClass('disabled');

		var albaran = $(this).attr('data-fact-id-manifest');
		var fecha =  $('#fechaHasta').val();
		//console.log('albaran', albaran);
		
		//$('#view_fact_manifest').modal('open');

		if(albaran != null){
			$preload.css('display','flex');

			$.ajax({
				url: factdata.url,
				type: 'POST',
				dataType: 'json',
				data : {
					action: 'fact_manifest',
					nonce: factdata.seguridad,
					albaran: albaran,
					fecha: fecha,
					tipo: 'view'
				}, success: function( data ){
					console.log('data', data);
					
					
					// si la respuesta de la accion en db es verdadera
					if( data.etiqueta){
						

						$('#urlManifiestoPdf').attr('href',data.etiqueta);
						$('#ifmManifiestoPdf').attr('src',data.etiqueta);

						
						window.open(data.etiqueta);
						

						setTimeout(function(){
							$('.manifest').removeClass('disabled');
							$preload.css('display','none');
						},1000);

					}
					else{
						$('.manifest').removeClass('disabled');
						//$('#view_fact_manifest').modal('close');

						Swal.fire({
							title   : 'Etiqueta',
							text    : 'Info: ' + data.mensaje + '',
							type    : 'error',
							timer   : 3500
						});

					}
				}, error: function( d,x,v ) {
				
					console.log(d);
					console.log(x);
					console.log(v);
					
				}
			}); 
		}

	});


	/**
	 * Ejecutamos el evento click en el checkbox de devolución para mostrar el formulario de una nueva dirección
	 */
	$(document).on('click', '[id-origen]', function() {
		//e.preventDefault();
		//console.log('funciona', $(".chkOrigen:checked").val());

		if($(".chkOrigen:checked").val() == "on"){
			
			$('#frmDesti').attr('style','display: block;');
		}else{
			$('#frmDesti').attr('style','display: none;');
		}

	});

	/**
	 * Ejecutamos el evento click en el checkbox de devolución para mostrar el formulario de una nueva dirección
	 */
	$(document).on('click', '[chk-servicio]', function() {
		//e.preventDefault();
		//console.log('funciona', $(".chkOrigen:checked").val());

		if($(".chkServicio:checked").val() == "on"){
			
			$('.servicio1').attr('style','display: block;');
			$('.servicio').attr('style','display: none;');
		}else{
			$('.servicio').attr('style','display: block;');
			$('.servicio1').attr('style','display: none;');
		}

	});

	
	$(document).on('click', '[param-config]', function() {

		$.ajax({

			url: factdata.url,
			type: 'POST',
			dataType: 'json',
			data: {

				action: 'fact_email',
				nonce: factdata.seguridad


			}, success: function( data ){
				console.log('data', data);				

					if(data){

						//console.log('result', data.result);
						Swal.fire({
							title   : 'Petición exitosa '+ data.success,
							text    : 'Solicitud recibida, en breve nos comunicaremos con usted.  ' ,
							icon    : 'success'
						});
						
						//location.href = url3;
						//window.location.reload();

					

					}else{
						

						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: data.infoWs
						  })
						  
						  $(this).removeClass('disabled');
						$('.imgSpinner').addClass('hide');


					}

			}, error: function( d,x,v ) {
				
		
				console.log(d);
				console.log(x);
				console.log(v);
				
			}
		});

	});


	/**
	 * Ejecutamos el evento click en el boton  de devolución para generar uma recogida de este albaran en el fact
	 */
	$(document).on( 'click', '[data-fact-id-devolucion]', function(e){
		e.preventDefault();

		var albaran = $(this).attr('data-fact-id-devolucion');
		$(this).addClass('disabled');
		//console.log('albaran', albaran);

		var html = 'Desea generar una recogida del envío con albaran: '+ albaran +'<br><div class="switch"><label>Usar Dirección de origen<input type="checkbox" id-origen="chkOrigen" class="chkOrigen"><span class="lever"></span>Establecer otra dirección</label></div><div id="frmDesti" style="display:none;"><form action="" method="post" form-fact><table style="padding:5px;">'+
	   '<tr><td><label for="nombre" style="font-size: 1rem; color: #9e9e9e;" class="active">Nombre</label><input type="text" id="nombre" value="" class="validate"></td>'+
		'<td><label for="direccion" style="font-size: 1rem; color: #9e9e9e;" class="active">Dirección</label><input type="text" id="direccion" value="" class="validate"></td></tr>'+
		'<tr><td><label for="poblacion" style="font-size: 1rem; color: #9e9e9e;" class="active">Población</label><input type="text" id="poblacion" value="" class="validate"></td>'+
		'<td><label for="codPostal" style="font-size: 1rem; color: #9e9e9e;" class="active">Codigo Postal</label><input type="text" id="codPostal" value="" class="validate"></td></tr>'+
		'<tr><td><label for="pais" style="font-size: 1rem; color: #9e9e9e;" class="active">Pais</label><input type="text" id="pais" value="ESP" class="validate"></td>'+
		'<td><label for="telefono" style="font-size: 1rem; color: #9e9e9e;" class="active">Teléfono</label><input type="text" id="telefono" value="" class="validate"></td></tr>'+
		'</table></form></div>';
		

		if(albaran != ""){

			Swal.fire({
				title				: "Devolver Pedido",
				//text				: 'Desea generar una recogida del envío con albaran: '+ albaran,
				html                : html,
				icon                : "question",
				showCancelButton    : true,
				confirmButtonText   : "SI",
				closeOnConfirm      : true,
				showLoaderOnConfirm : true,
				preConfirm: () => {
					return fetch('')
					  .then(response => {

						var origen = "";
						var nombre = "";
						var direccion = "";
						var poblacion = "";
						var postal = "";
						var pais = "";
						var telefono = "";


						//$("#chkOrigen:checked").val() == "Establecer otra dirección" ? origen = "true" : origen = "false";

						//verificamos que ningunos de los campos del formulario estés vacios
					if($(".chkOrigen:checked").val() == "on"){
						origen = $(".chkOrigen").val();
						nombre = $("#nombre").val();
						direccion = $("#direccion").val();
						poblacion = $("#poblacion").val();
						postal = $("#codPostal").val();
						pais = $("#pais").val();
						telefono = $("#telefono").val();

					}
	
					$.ajax({

						url: factdata.url,
						type: 'POST',
						dataType: 'json',
						data: {
		
							action: 'fact_return',
							nonce: factdata.seguridad,
							albaran: albaran,
							origen: origen,
							nombre: nombre,
							direccion: direccion,
							poblacion: poblacion,
							postal: postal,
							pais: pais,
							telefono: telefono


						}, success: function( data ){
							//console.log('data', data);				

								if(data.infoWs == 'OK'){

									//console.log('result', data.result);
									Swal.fire({
										title   : 'Transmición al Fact',
										text    : 'Se ha generado correctamente una devolución con el numero de Recogida: '+ data.recogida +'',
										icon    : 'success',
										timer   : 5000
									});
									
									//location.href = url3;
									window.location.reload();

								

								}else{
									

									Swal.fire({
										icon: 'error',
										title: 'Oops...',
										text: data.infoWs
									  })
									  
									  $(this).removeClass('disabled');
									$('.imgSpinner').addClass('hide');


								}

						}, error: function( d,x,v ) {
							
					
							console.log(d);
							console.log(x);
							console.log(v);
							
						}
					});
						
					  })
					  
				  },
				  allowOutsideClick: () => !Swal.isLoading()
			}).then((result) =>{
	
				if( result.isConfirmed ) {

		
						$(this).removeClass('disabled');
						

					
					
	
				} else {
		
						$(this).removeClass('disabled');
						$('.imgSpinner').addClass('hide');
	
					
	
				}
	
			}); 

			
		
	}
	
	});

	

	
});



})( jQuery );


function FactMasive() {

	//console.log(chekarray);

	jQuery(function($){

	orderId = chekarray;
	metodoPago = '';
	let servicio = '';
	let idRemi = '';
	dir = $('.imgSpinner').attr('dir');
	var tiempo = chekarray.length.toString() + '000';
    var tiempo1= chekarray.length.toString() + '000';
	
	let albaDesde;
	let albaHasta;

	$('.btnTransmitir').addClass('disabled');
	$('.btnTransmitir').html('&nbsp;&nbsp;<img src="../images/loader2.gif" width="30px"/>&nbsp; Procesando... &nbsp;');
	   
	   
	
	//console.log(url_ajax);
	var html;
	var pesot = '';
	var peso = null;

	if(chekarray.length == 1){
		pesot = '<td><label for="peso" style="font-size: 1rem; color: #9e9e9e;" class="active">Peso</label><input type="text" id="peso" value="1" class="myform-control form-control validate"></td>';
	}
	
	html = '<br><br><form action="" method="post" form-fact><table id="mdlTransmicion"  style="padding:5px; margin: 0px; width:100%">'+
					'<tr><td colspan=""><label for="sltRemitente" style="font-size: 1rem; color: #9e9e9e;" class="active">Remitente</label><br><select data-sender1="" id="sltRemitente" style="width:100%;" value="'+idRemi+'" class="myform-control form-control validate sltRemi"><option value="'+idRemi+'" selected="">Predeterminado</option></select></td>'+
					'<td colspan=""><label for="servicio" style="font-size: 1rem; color: #9e9e9e;" class="active">Servicio</label><br><select data-service="" id="servicio" style="width:100%;" value="'+servicio+'" class="myform-control form-control validate servicio"><option value="'+servicio+'" selected="">Predeterminado</option></select></td></tr>'+
					'<tr><td><label for="bultos" style="font-size: 1rem; color: #9e9e9e;" class="active">Bultos</label><input type="text" id="bultos" value="1" class="myform-control form-control validate"></td>'+
					'<td><label for="alto" style="font-size: 1rem; color: #9e9e9e;" class="active">Alto</label><input type="text" id="alto" value="1" class="myform-control form-control validate"></td></tr>'+
					'<tr><td><label for="ancho" style="font-size: 1rem; color: #9e9e9e;" class="active">Ancho</label><input type="text" id="ancho" value="1" class="myform-control form-control validate"></td>'+
					'<td><label for="largo" style="font-size: 1rem; color: #9e9e9e;" class="active">Largo</label><input type="text" id="largo" value="1" class="myform-control form-control validate"></td></tr>'+	
					'<tr>'+pesot+'</tr>'+	
					'<tr><td colspan="2"><label style="font-size: small;"> <input type="checkbox" checked id="chkPortes" class="portesD">&nbsp Incluir costo del envío </td></tr>'+
					//'<tr><td colspan="2"><label style="font-size: small;">&nbsp&nbsp <input type="checkbox" id="chkDebido" class="debidoP">&nbsp Incluir Portes Debido &nbsp&nbsp </td></tr>'+					
					'</table></form>';
	
					

					Swal.fire({
						title				: "Transmitir los ("+ chekarray.length +") Pedidos seleccionados",
						text				: 'Confirma los datos',
						html				: html,
						//icon                : "question",
						showCancelButton    : true,
						confirmButtonText   : "Generar Etiquetas",
						closeOnConfirm      : true,
						showLoaderOnConfirm : true,
						preConfirm: () => {
							return fetch('')
							  .then(response => {

							

							var servicio;
							var bultos;
							var alto ;
							var ancho;
							var largo ;
							var portes = false;
							var debido = false;
							var parserito = $('.sltRemi').val();
						   
						   if(parserito.length > 5){
							   console.log(parserito.length);
							   parserito = JSON.parse($('.sltRemi').val());
							   $('.sltRemi').val()!= "" ? idRemi = parserito.id : idRemi = '';
							   //console.log('remitente', idRemi);
						   }else{
							   $('.sltRemi').val()!= "" ? idRemi = $('.sltRemi').val() : idRemi = '';
						   }

							$('#servicio').val() != "" ? servicio = $('#servicio').val() : servicio = '';
							$('#bultos').val() != "" ? bultos = $('#bultos').val() : bultos = 0;
							$('#alto').val() != "" ? alto = $('#alto').val() : alto = 0;
							$('#ancho').val() != "" ? ancho = $('#ancho').val() : ancho = 0;
							$('#largo').val() != "" ? largo = $('#largo').val() : largo = 0;
							$("#chkPortes:checked").val() == "on" ? portes = "true" : portes = "false";
							//$("#chkDebido:checked").val() == "on" ? debido = "true" : debido = "false";
							//console.log('check', portes);

							if(chekarray.length == 1){
								$('#peso').val() != "" ? peso = $('#peso').val() : peso = 0;

							}


							$.each(chekarray, function(key,value){

							//console.log(value);
			
							$.ajax({

								url: factdata.url,
								type: 'POST',
								dataType: 'json',
								data: {
				
									action: 'fact_send',
									nonce: factdata.seguridad,
									servicio: servicio,
									bultos: bultos,
									pes: peso,
									alt: alto,
									anch: ancho,
									larg: largo,
									portes: portes,
									debido: debido,
									order: value,
									idsender: idRemi
								}, success: function( data ){
													

										if(data.infoWs == 'OK'){

										   /*console.log('parametros', data.param);
										   console.log('delivery', data.delivery_details);
										   console.log('order', data.order_details); */

										   albarray.push(data.albaran);
										   conta ++;
										   console.log('chekarray.length', chekarray.length);
										   console.log('conta', conta);

										   if (chekarray.length == conta) {

                                            if(albarray.length == 1){
												albaDesde = albarray[0];
												albaHasta = albarray[0];
											}else{
												albaDesde = albarray[0];
												albaHasta = albarray.pop();
											}
											console.log('albarray', albarray);
											console.log('albaDesde', albaDesde);
											console.log('albaHasta', albaHasta);
											


                                            setTimeout(() => {

                                                Swal.fire({
                                                    title: 'Etiquetas Generadas',
                                                    text: 'Transmisión masiva ejecutada correctamente',
                                                    icon: 'success',
                                                    timer: 5000
                                                });
												

												if(albaDesde != "" && albaHasta != ""){
				
													$.ajax({
														url: factdata.url,
														type: 'POST',
														dataType: 'json',
														data : {
															action: 'fact_masive',
															nonce: factdata.seguridad,
															albaDesde: albaDesde,
															albaHasta: albaHasta,
															tipo: 'view'
														}, success: function( data ){					
															
															// si la respuesta de la accion en db es verdadera
															if( data.etiqueta){
																
																window.open(data.etiqueta);

																setTimeout(function(){
                     
																	window.location.reload(); 
										
																},5000);
																					
										
															}
															else{
																

																setTimeout(function(){
                     
																	window.location.reload(); 
										
																},5000);
										
															}

															setTimeout(function(){
                     
																window.location.reload(); 
									
															},15000);

														}, error: function( d,x,v ) {
														
															console.log(d);
															console.log(x);
															console.log(v);
															
														}
													});
					
												}
               
            
                                               
                                            }, 1000);                                 
                                    }
										

										}else{

				
										/*	$('.btnTransmitir').removeClass('disabled');
											//$('.imgSpinner').addClass('hide');

											if(data.infoWs != ''){

												Swal.fire({
													icon: 'error',
													title: 'Oops...',
													text: 'El pedido '+ value + ' '+ data.infoWs
												  })
	
												  return;

												
											}*/
										}

										

								}, error: function( d,x,v ) {
							
									console.log(d);
									console.log(x);
									console.log(v);
																
								}
							});

						});
								
							  })
							  
						  },
						  allowOutsideClick: () => !Swal.isLoading()
					}).then((result) =>{
			
						if( result.isConfirmed ) {

							//$('#codigo').addClass('invalid')

							tiempo1 = tiempo * 3;

							

							var html2 ='<center><div class="spinner-border"><img src="'+dir+'admin/img/loader2.gif" width="100px"></div></center>';

							setTimeout(function(){

								Swal.fire({
									title    : 'Procesando...',
									html	: html2,
									icon    : 'info',
									timer   : tiempo1
								});
	
							},1000);

						setTimeout(function(){

							Swal.fire({
								title   : 'Transmisión al Fact',
								text    : 'Transmisión masiva ejecutada correctamente',
								icon    : 'success',
								timer   : 5000
							});

							

							window.location.reload(); 
	

						},tiempo1);

							
			
						} else {

							
			 
							$('.btnTransmitir').removeClass('disabled');
							
			
						} 
						arrayServicios = null;
						arrayRemitentes = null;
			
					});
					
				
			});
}